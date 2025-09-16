<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\SettingsModel;

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
        
        // Vérification de connexion dans le constructeur
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    }
    
    // ... gardez toutes vos méthodes existantes ...

    /**
     * Détails d'un livre (API) - MÉTHODE MANQUANTE
     */
    public function getBookDetails($bookId)
    {
        // Vérifier que l'utilisateur est connecté
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Non autorisé'])->setStatusCode(401);
        }

        $book = $this->bookModel->find($bookId);
        
        if (!$book) {
            return $this->response->setJSON(['error' => 'Livre non trouvé'])->setStatusCode(404);
        }
        
        return $this->response->setJSON($book);
    }



    /**
     * Emprunter un livre avec vérification des limites
     */
    public function borrowBook($bookId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        // Récupérer les paramètres avec votre méthode existante
        $settings = $this->settingsModel->getSettings('loans');
        $maxBooksPerUser = $settings['max_books_per_user'] ?? 3;
        $loanDurationDays = $settings['loan_duration_days'] ?? 30;
        $lateFeePerDay = $settings['late_fee_per_day'] ?? 1;

        // Vérifier si le livre existe et est disponible
        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return redirect()->to('/books')->with('error', 'Livre non trouvé');
        }

        if ($book['available'] <= 0) {
            return redirect()->to('/books')->with('error', 'Ce livre n\'est plus disponible');
        }

        // Vérifier si l'utilisateur n'a pas déjà ce livre en cours d'emprunt
        $existingLoan = $this->loanModel->where('user_id', $userId)
                                     ->where('book_id', $bookId)
                                     ->whereIn('status', ['active', 'overdue'])
                                     ->first();

        if ($existingLoan) {
            return redirect()->to('/books')->with('error', 'Vous avez déjà ce livre en cours d\'emprunt');
        }

        // Vérifier le nombre maximum d'emprunts
        $currentLoansCount = $this->loanModel->where('user_id', $userId)
                                           ->whereIn('status', ['active', 'overdue'])
                                           ->countAllResults();

        if ($currentLoansCount >= $maxBooksPerUser) {
            return redirect()->to('/books')->with('error', 
                "Vous avez atteint la limite de $maxBooksPerUser emprunt(s) simultané(s). Veuillez retourner un livre avant d'en emprunter un nouveau."
            );
        }

        // Calculer les dates d'emprunt
        $loanDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime("+$loanDurationDays days"));

        // Créer l'emprunt
        $loanData = [
            'book_id' => $bookId,
            'user_id' => $userId,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'active',
            'created_by' => $userId
        ];

        if ($this->loanModel->insert($loanData)) {
            // Décrémenter la disponibilité du livre
            $this->bookModel->decrementAvailable($bookId);
            
            return redirect()->to('/my-books')->with('success', 
                "Livre emprunté avec succès ! Date de retour: " . date('d/m/Y', strtotime($dueDate))
            );
        } else {
            return redirect()->to('/books')->with('error', 'Erreur lors de l\'emprunt');
        }
    }

    /**
     * Page de confirmation d'emprunt avec les paramètres
     */
    public function borrow($bookId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $book = $this->bookModel->find($bookId);

        if (!$book) {
            return redirect()->to('/books')->with('error', 'Livre non trouvé');
        }

        // Récupérer les paramètres avec votre méthode existante
        $settings = $this->settingsModel->getSettings();
        $maxBooksPerUser = $settings['max_books_per_user'] ?? 3;
        $loanDurationDays = $settings['loan_duration_days'] ?? 30;
        $libraryName = $settings['library_name'] ?? 'Notre Bibliothèque';
        $lateFeePerDay = $settings['late_fee_per_day'] ?? 1;

        $userId = session()->get('user_id');
        $currentLoansCount = $this->loanModel->where('user_id', $userId)
                                           ->whereIn('status', ['active', 'overdue'])
                                           ->countAllResults();

        $data = [
            'title' => 'Emprunter un livre',
            'book' => $book,
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ],
            'settings' => [
                'max_books' => $maxBooksPerUser,
                'loan_duration' => $loanDurationDays,
                'library_name' => $libraryName,
                'late_fee' => $lateFeePerDay,
                'current_loans' => $currentLoansCount,
                'remaining_loans' => $maxBooksPerUser - $currentLoansCount
            ]
        ];

        return view('user/borrow', $data);
    }

    /**
     * Dashboard avec informations des limites
     */
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        // Récupérer les paramètres
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

    // ... le reste de vos méthodes existantes ...















    /**
     * Livres disponibles
     */
    public function books()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

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
     * Historique des emprunts
     */
    public function history()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

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
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $loan = $this->loanModel->getLoanWithDetails($id);
        
        // Vérifier que l'emprunt appartient à l'utilisateur
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
     * Statistiques utilisateur
     */

    private function getUserStats($userId)
    {
        return [
            'total_loans' => $this->loanModel->where('user_id', $userId)->countAllResults(),
            'active_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'active')
                                            ->countAllResults(),
            'returned_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'returned')
                                            ->countAllResults(),
            'overdue_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'overdue')
                                            ->countAllResults()
        ];
    }



    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find(session()->get('user_id'));

        $data = [
            'title' => 'Mon Profil',
            'user' => $user
        ];
        
        return view('user/profile', $data);
    }


    public function updateProfile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();

        // Validation des données
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

        // Données à mettre à jour
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

        if ($userModel->update($userId, $data)) {
            // Mettre à jour les données de session
            session()->set('user_name', $data['first_name'] . ' ' . $data['last_name']);
            session()->set('user_email', $data['email']);

            return redirect()->to('/profile')->with('success', 'Profil mis à jour avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du profil');
        }
    }

    


    // Ajoutez cette méthode
    private function getMyBooksStats($userId)
    {
        return [
            'total_loans' => $this->loanModel->where('user_id', $userId)->countAllResults(),
            'active_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'active')
                                            ->countAllResults(),
            'returned_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'returned')
                                            ->countAllResults(),
            'overdue_loans' => $this->loanModel->where('user_id', $userId)
                                            ->where('status', 'overdue')
                                            ->countAllResults()
        ];
    }

    // Modifiez la méthode myBooks()
   
    public function myBooks()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        // Récupérer les paramètres de configuration
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
            'settings' => [ // AJOUTER CETTE LIGNE
                'max_books' => $maxBooksPerUser,
                'current_loans' => $currentLoansCount,
                'remaining_loans' => $maxBooksPerUser - $currentLoansCount
            ]
        ];
        
        return view('user/my_books', $data);
    }




    public function myReservations()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Mes Réservations',
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
            ]
        ];
        
        return view('user/my_reservations', $data);
    }


    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $userModel->find($userId);
        
        // Vérifier le mot de passe actuel
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Mot de passe actuel incorrect');
        }

        // Hasher le nouveau mot de passe
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);

        if ($userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->to('/profile')->with('success', 'Mot de passe changé avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors du changement de mot de passe');
        }
    }  


    // Ajoutez cette méthode pour gérer le retour des livres
    public function returnBook($loanId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $loan = $this->loanModel->find($loanId);
        
        // Vérifier que l'emprunt appartient à l'utilisateur
        if (!$loan || $loan['user_id'] != $userId) {
            return redirect()->to('/my-books')->with('error', 'Emprunt non trouvé');
        }
        
        // Mettre à jour l'emprunt
        $this->loanModel->update($loanId, [
            'return_date' => date('Y-m-d'),
            'status' => 'returned'
        ]);
        
        // Réincrémenter la disponibilité du livre
        $this->bookModel->incrementAvailable($loan['book_id']);
        
        return redirect()->to('/my-books')->with('success', 'Livre retourné avec succès');
    }


    // Méthodes utilitaires à ajouter dans UserController
    private function calculateDaysOverdue($dueDate)
    {
        $due = new \DateTime($dueDate);
        $now = new \DateTime();
        return $now->diff($due)->days;
    }

    private function calculateDaysRemaining($dueDate)
    {
        $due = new \DateTime($dueDate);
        $now = new \DateTime();
        $interval = $now->diff($due);
        return $interval->invert ? 0 : $interval->days;
    }



}










