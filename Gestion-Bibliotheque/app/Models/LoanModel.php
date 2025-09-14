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

    // Dans app/Models/LoanModel.php

    public function getLoansWithDetails($options = [])
    {
        $builder = $this->db->table('loans l')
            ->select('l.*, 
                    b.title as book_title, 
                    b.isbn, 
                    b.cover_image, 
                    b.author,
                    b.category,
                    u.first_name, 
                    u.last_name, 
                    u.email,
                    u.phone')
            ->join('books b', 'b.id = l.book_id')  // Jointure avec la table books
            ->join('users u', 'u.id = l.user_id'); // Jointure avec la table users

        // Appliquer les filtres
        if (!empty($options['status'])) {
            $builder->where('l.status', $options['status']);
        }
        
        if (!empty($options['search'])) {
            $builder->groupStart()
                ->like('b.title', $options['search'])
                ->orLike('u.first_name', $options['search'])
                ->orLike('u.last_name', $options['search'])
                ->orLike('u.email', $options['search'])
                ->orLike('b.author', $options['search'])
                ->groupEnd();
        }

        // Filtre par ID si spécifié
        if (!empty($options['id'])) {
            $builder->where('l.id', $options['id']);
        }

        // Limite pour les emprunts récents
        if (!empty($options['limit'])) {
            $builder->limit($options['limit']);
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
            ->select('l.*, b.title as book_title, b.cover_image, b.author, u.first_name, u.last_name, u.email')
            ->join('books b', 'b.id = l.book_id')
            ->join('users u', 'u.id = l.user_id')
            ->where('l.due_date <', date('Y-m-d'))
            ->where('l.status', 'active')
            ->orderBy('l.due_date', 'ASC')
            ->get()
            ->getResultArray();
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
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'cancelled' => $this->where('status', 'cancelled')->countAllResults()
        ];
    }

        /**
     * Compte les emprunts actifs d'un utilisateur
     */
    public function countUserActiveLoans($userId)
    {
        return $this->where('user_id', $userId)
                ->whereIn('status', ['active', 'overdue'])
                ->countAllResults();
    }


    // Utilisateur ..

        /**
     * Récupère les emprunts actifs d'un utilisateur
     */
    // Dans app/Models/LoanModel.php


    public function getUserActiveLoans($userId)
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title, b.author, b.cover_image, b.isbn, b.category')
            ->join('books b', 'b.id = l.book_id')
            ->where('l.user_id', $userId)
            ->whereIn('l.status', ['active', 'overdue'])
            ->orderBy('l.due_date', 'ASC')
            ->get()
            ->getResultArray();
    }

    
    public function getUserLoanHistory($userId)
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title, b.author, b.cover_image, b.isbn, b.category')
            ->join('books b', 'b.id = l.book_id')
            ->where('l.user_id', $userId)
            ->orderBy('l.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLoanWithDetails($loanId)
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title, b.author, b.cover_image, b.isbn, b.category, b.description')
            ->join('books b', 'b.id = l.book_id')
            ->where('l.id', $loanId)
            ->get()
            ->getRowArray();
    }











}