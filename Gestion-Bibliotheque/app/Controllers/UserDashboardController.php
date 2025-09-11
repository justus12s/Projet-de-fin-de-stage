<?php
namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\UserModel;

class UserDashboardController extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $userModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
        helper(['form', 'url', 'date']);
        
        // Vérifier que l'utilisateur est connecté et est un user normal
        $session = session();
        if (!$session->get('is_logged_in') || $session->get('user_role') !== 'user') {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }
    }

    /**
     * Tableau de bord utilisateur
     */
    public function index()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'page_title' => 'Mon Tableau de Bord',
            'user' => $this->userModel->find($userId),
            'active_loans' => $this->loanModel->getUserActiveLoans($userId),
            'loan_history' => $this->loanModel->getUserLoanHistory($userId),
            'available_books' => $this->bookModel->where('available >', 0)->findAll(6),
            'stats' => $this->getUserStats($userId)
        ];

        return view('user/dashboard', $data);
    }

    /**
     * Historique des emprunts
     */
    public function history()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'page_title' => 'Mon Historique d\'Emprunts',
            'loan_history' => $this->loanModel->getUserLoanHistory($userId),
            'user' => $this->userModel->find($userId)
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
        
        // Vérifier que l'emprunt appartient à l'utilisateur
        if (!$loan || $loan['user_id'] != $userId) {
            return redirect()->to('/user/dashboard')->with('error', 'Emprunt non trouvé');
        }

        $data = [
            'page_title' => 'Détails de mon Emprunt',
            'loan' => $loan,
            'user' => $this->userModel->find($userId)
        ];

        return view('user/view_loan', $data);
    }

    /**
     * Livres disponibles
     */
    public function books()
    {
        $data = [
            'page_title' => 'Livres Disponibles',
            'books' => $this->bookModel->where('available >', 0)->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        return view('user/books', $data);
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
}