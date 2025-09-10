<?php
namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\UserModel;

class AdminLoanController extends BaseController
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
    }

    /**
     * Liste des emprunts
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        
        $filters = [];
        if (!empty($search)) $filters['search'] = $search;
        if (!empty($status)) $filters['status'] = $status;

        $data = [
            'page_title' => 'Gestion des Emprunts',
            'loans' => $this->loanModel->getLoansWithDetails($filters),
            'stats' => $this->loanModel->getLoanStats(),
            'search' => $search,
            'selected_status' => $status
        ];

        return view('dashboard/section_loans', $data);
    }

    /**
     * Formulaire de création d'emprunt
     */
    public function create()
    {
        $data = [
            'page_title' => 'Nouvel Emprunt',
            'books' => $this->bookModel->where('available >', 0)->findAll(),
            'users' => $this->userModel->where('role', 'user')
                                     ->where('is_active', 1)
                                     ->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('dashboard/create_loan', $data);
    }

    /**
     * Traitement de la création d'emprunt
     */
    public function store()
    {
        $validationRules = [
            'book_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'loan_date' => 'required|valid_date',
            'due_date' => 'required|valid_date',
            'notes' => 'permit_empty|string'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Vérifier si le livre est disponible
        $book = $this->bookModel->find($this->request->getPost('book_id'));
        if (!$book || $book['available'] <= 0) {
            return redirect()->back()->withInput()->with('error', 'Livre non disponible');
        }

        // Vérifier si le livre est déjà emprunté
        if ($this->loanModel->isBookBorrowed($this->request->getPost('book_id'))) {
            return redirect()->back()->withInput()->with('error', 'Livre déjà emprunté');
        }

        $loanData = [
            'book_id' => $this->request->getPost('book_id'),
            'user_id' => $this->request->getPost('user_id'),
            'loan_date' => $this->request->getPost('loan_date'),
            'due_date' => $this->request->getPost('due_date'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'active',
            'created_by' => session()->get('user_id')
        ];

        if ($this->loanModel->save($loanData)) {
            // Mettre à jour la disponibilité du livre
            $this->bookModel->decrementAvailable($loanData['book_id']);
            
            return redirect()->to('/admin/dashboard/loans')->with('success', 'Emprunt créé avec succès !');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'emprunt');
        }
    }

    /**
     * Marquer un emprunt comme retourné
     */
    public function returnLoan($id)
    {
        $loan = $this->loanModel->find($id);
        
        if (!$loan) {
            return redirect()->to('/admin/dashboard/loans')->with('error', 'Emprunt non trouvé');
        }

        if ($this->loanModel->update($id, [
            'status' => 'returned',
            'return_date' => date('Y-m-d H:i:s')
        ])) {
            // Remettre le livre à disposition
            $this->bookModel->incrementAvailable($loan['book_id']);
            
            return redirect()->to('/admin/dashboard/loans')->with('success', 'Livre retourné avec succès !');
        } else {
            return redirect()->to('/admin/dashboard/loans')->with('error', 'Erreur lors du retour du livre');
        }
    }

    /**
     * Supprimer un emprunt
     */
    public function delete($id)
    {
        $loan = $this->loanModel->find($id);
        
        if (!$loan) {
            return redirect()->to('/admin/dashboard/loans')->with('error', 'Emprunt non trouvé');
        }

        if ($this->loanModel->delete($id)) {
            // Si l'emprunt était actif, remettre le livre à disposition
            if ($loan['status'] === 'active') {
                $this->bookModel->incrementAvailable($loan['book_id']);
            }
            
            return redirect()->to('/admin/dashboard/loans')->with('success', 'Emprunt supprimé avec succès !');
        } else {
            return redirect()->to('/admin/dashboard/loans')->with('error', 'Erreur lors de la suppression');
        }
    }

    /**
     * Emprunts en retard
     */
    public function overdue()
    {
        $data = [
            'page_title' => 'Emprunts en Retard',
            'overdue_loans' => $this->loanModel->getOverdueLoans(),
            'stats' => $this->loanModel->getLoanStats()
        ];

        return view('dashboard/section_overdue', $data);
    }

    /**
     * Détails d'un emprunt
     */
    public function view($id)
    {
        $loan = $this->loanModel->getLoansWithDetails(['id' => $id]);
        
        if (!$loan) {
            return redirect()->to('/admin/dashboard/loans')->with('error', 'Emprunt non trouvé');
        }

        $data = [
            'page_title' => 'Détails de l\'Emprunt',
            'loan' => $loan[0]
        ];

        return view('dashboard/view_loan', $data);
    }
}
