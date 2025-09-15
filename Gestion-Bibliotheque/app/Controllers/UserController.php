<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\SettingsModel;
use App\Models\ReservationModel;

class UserController extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $userModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
        $this->settingsModel = new SettingsModel();

        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    }

    /**
     * Dashboard avec informations des limites
     */
    public function dashboard()
    {
        $userId = session()->get('user_id');
        $settings = $this->settingsModel->getSettings();
        $maxBooksPerUser = $settings['max_books_per_user'] ?? 3;

        $currentLoansCount = $this->loanModel->where('user_id', $userId)
            ->whereIn('status', ['active', 'overdue'])
            ->countAllResults();

        $data = [
            'title' => 'Mon Tableau de bord',
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email'),
                'status' => session()->get('user_status')
            ],
            'active_loans' => $this->loanModel->getUserActiveLoans($userId),
            'available_books' => $this->bookModel->where('available >', 0)->findAll(6),
            'stats' => $this->getUserStats($userId),
            'loan_limits' => [
                'max_books' => $maxBooksPerUser,
                'current_loans' => $currentLoansCount,
                'remaining_loans' => $maxBooksPerUser - $currentLoansCount
            ]
        ];

        return view('user/dashboard', $data);
    }

    /**
     * Livres disponibles
     */
    public function books()
    {
        $data = [
            'title' => 'Livres Disponibles',
            'books' => $this->bookModel->where('available >', 0)->findAll(),
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ]
        ];

        return view('user/books', $data);
    }

    /**
     * Détails d'un livre
     */
    public function getBookDetails($bookId)
    {
        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return $this->response->setJSON(['error' => 'Livre non trouvé'])->setStatusCode(404);
        }
        return $this->response->setJSON($book);
    }

    /**
     * Historique des emprunts
     */
    public function history()
    {
        $userId = session()->get('user_id');
        $data = [
            'title' => 'Mon Historique d\'Emprunts',
            'loan_history' => $this->loanModel->getUserLoanHistory($userId),
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ]
        ];
        return view('user/history', $data);
    }

    /**
     * Détails d'un emprunt
     */
    public function viewLoan($id)
    {
        $userId = session()->get('user_id');
        $loan = $this->loanModel->getLoanWithDetails($id);

        if (!$loan || $loan['user_id'] != $userId) {
            return redirect()->to('/dashboard')->with('error', 'Emprunt non trouvé');
        }

        $data = [
            'title' => 'Détails de mon Emprunt',
            'loan' => $loan,
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ]
        ];

        return view('user/view_loan', $data);
    }

    /**
     * Page Mes Emprunts
     */
    public function myBooks()
    {
        $userId = session()->get('user_id');
        $settings = $this->settingsModel->getSettings();
        $maxBooksPerUser = $settings['max_books_per_user'] ?? 3;

        $currentLoansCount = $this->loanModel->where('user_id', $userId)
            ->whereIn('status', ['active', 'overdue'])
            ->countAllResults();

        $data = [
            'title' => 'Mes Emprunts',
            'active_loans' => $this->loanModel->getUserActiveLoans($userId),
            'available_books' => $this->bookModel->where('available >', 0)->findAll(5),
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ],
            'stats' => $this->getMyBooksStats($userId),
            'settings' => [
                'max_books' => $maxBooksPerUser,
                'current_loans' => $currentLoansCount,
                'remaining_loans' => $maxBooksPerUser - $currentLoansCount
            ]
        ];

        return view('user/my_books', $data);
    }

    /**
     * Page Mes Réservations
     */
    public function myReservations()
    {
        $userId = session()->get('user_id');
        $reservationModel = new ReservationModel();

        $data = [
            'title' => 'Mes Réservations',
            'reservations' => $reservationModel->where('user_id', $userId)->findAll(),
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ]
        ];
        return view('user/my_reservations', $data);
    }

    /**
     * Retourner un livre
     */
    public function returnBook($loanId)
    {
        $userId = session()->get('user_id');
        $loan = $this->loanModel->find($loanId);

        if (!$loan || $loan['user_id'] != $userId) {
            return redirect()->to('/my-books')->with('error', 'Emprunt non trouvé');
        }

        $this->loanModel->update($loanId, [
            'return_date' => date('Y-m-d'),
            'status' => 'returned'
        ]);

        $this->bookModel->incrementAvailable($loan['book_id']);

        return redirect()->to('/my-books')->with('success', 'Livre retourné avec succès');
    }

    /**
     * Profil utilisateur
     */
    public function profile()
    {
        $user = $this->userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Mon Profil',
            'user' => $user
        ];
        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
            'date_of_birth' => 'permit_empty|valid_date',
            'address' => 'permit_empty|max_length[500]',
            'institution' => 'permit_empty|max_length[255]',
            'specialization' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'address' => $this->request->getPost('address'),
            'institution' => $this->request->getPost('institution'),
            'specialization' => $this->request->getPost('specialization'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->update($userId, $data)) {
            session()->set('user_name', $data['first_name'] . ' ' . $data['last_name']);
            session()->set('user_email', $data['email']);
            return redirect()->to('/profile')->with('success', 'Profil mis à jour avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du profil');
        }
    }

    /**
     * Changer mot de passe
     */
    public function changePassword()
    {
        $userId = session()->get('user_id');
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find($userId);

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Mot de passe actuel incorrect');
        }

        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);

        if ($this->userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->to('/profile')->with('success', 'Mot de passe changé avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors du changement de mot de passe');
        }
    }

    /**
     * Méthodes utilitaires privées
     */
    private function getUserStats($userId)
    {
        return [
            'total_loans' => $this->loanModel->where('user_id', $userId)->countAllResults(),
            'active_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'active')->countAllResults(),
            'returned_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'returned')->countAllResults(),
            'overdue_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'overdue')->countAllResults()
        ];
    }

    private function getMyBooksStats($userId)
    {
        return [
            'total_loans' => $this->loanModel->where('user_id', $userId)->countAllResults(),
            'active_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'active')->countAllResults(),
            'returned_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'returned')->countAllResults(),
            'overdue_loans' => $this->loanModel->where('user_id', $userId)->where('status', 'overdue')->countAllResults()
        ];
    }
}
