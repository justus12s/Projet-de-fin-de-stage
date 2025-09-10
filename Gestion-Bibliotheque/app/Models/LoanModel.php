<?php
namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'loans';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'book_id', 'user_id', 'loan_date', 'due_date', 
        'return_date', 'status', 'notes', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'book_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'loan_date' => 'required|valid_date',
        'due_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,active,returned,overdue,cancelled]'
    ];

    /**
     * Récupère les emprunts avec les informations des livres et utilisateurs
     */
    public function getLoansWithDetails($filters = [])
    {
        $builder = $this->db->table('loans l')
            ->select('l.*, b.title as book_title, b.isbn, u.first_name, u.last_name, u.email')
            ->join('books b', 'b.id = l.book_id')
            ->join('users u', 'u.id = l.user_id');

        // Appliquer les filtres
        if (!empty($filters['status'])) {
            $builder->where('l.status', $filters['status']);
        }
        
        if (!empty($filters['search'])) {
            $builder->groupStart()
                   ->like('b.title', $filters['search'])
                   ->orLike('u.first_name', $filters['search'])
                   ->orLike('u.last_name', $filters['search'])
                   ->orLike('u.email', $filters['search'])
                   ->groupEnd();
        }

        return $builder->orderBy('l.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Récupère les emprunts en retard
     */
    public function getOverdueLoans()
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title as book_title, u.first_name, u.last_name, u.email')
            ->join('books b', 'b.id = l.book_id')
            ->join('users u', 'u.id = l.user_id')
            ->where('l.due_date <', date('Y-m-d'))
            ->where('l.status', 'active')
            ->orderBy('l.due_date', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les emprunts actifs d'un utilisateur
     */
    public function getUserActiveLoans($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('status', 'active')
                   ->join('books', 'books.id = loans.book_id')
                   ->select('loans.*, books.title, books.author')
                   ->findAll();
    }

    /**
     * Vérifie si un livre est déjà emprunté
     */
    public function isBookBorrowed($bookId)
    {
        return $this->where('book_id', $bookId)
                   ->where('status', 'active')
                   ->countAllResults() > 0;
    }

    /**
     * Met à jour le statut des emprunts en retard
     */
    public function updateOverdueLoans()
    {
        $this->where('due_date <', date('Y-m-d'))
             ->where('status', 'active')
             ->set('status', 'overdue')
             ->update();
    }

    /**
     * Statistiques des emprunts
     */
    public function getLoanStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'overdue' => $this->where('status', 'overdue')->countAllResults(),
            'returned' => $this->where('status', 'returned')->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults()
        ];
    }
}