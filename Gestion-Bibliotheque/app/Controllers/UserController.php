<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoanModel;
use App\Models\BookModel;

class UserController extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $userModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
    }
    
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Mon Tableau de bord',
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email'),
                'status' => session()->get('user_status')
            ],
            'active_loans' => $this->loanModel->getUserActiveLoans($userId),
            'available_books' => $this->bookModel->where('available >', 0)->findAll(6),
            'stats' => $this->getUserStats($userId)
        ];
        
        return view('user/dashboard', $data);
    }

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
                                             ->whereIn('status', ['active', 'overdue'])
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
        // Logique de mise à jour du profil
        return redirect()->to('/profile')->with('success', 'Profil mis à jour');
    }

    public function myBooks()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Mes Livres Empruntés',
            'active_loans' => $this->loanModel->getUserActiveLoans($userId),
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email')
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
}