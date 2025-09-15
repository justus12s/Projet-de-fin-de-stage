<?php
namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'loans';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'book_id', 'user_id', 'loan_date', 'due_date', 
        'return_date', 'status', 'notes', 'created_by',
        'reservation_date', 'expiry_date', 'type'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'book_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'loan_date' => 'permit_empty|valid_date',
        'due_date' => 'permit_empty|valid_date',
        'reservation_date' => 'permit_empty|valid_date',
        'expiry_date' => 'permit_empty|valid_date',
        'status' => 'required|in_list[pending,active,returned,overdue,cancelled,reserved]',
        'type' => 'required|in_list[loan,reservation]'
    ];

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
            ->join('books b', 'b.id = l.book_id')
            ->join('users u', 'u.id = l.user_id');

        if (!empty($options['type'])) {
            $builder->where('l.type', $options['type']);
        }
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
        if (!empty($options['id'])) {
            $builder->where('l.id', $options['id']);
        }
        if (!empty($options['limit'])) {
            $builder->limit($options['limit']);
        }

        return $builder->orderBy('l.created_at', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    public function getOverdueLoans()
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title as book_title, b.cover_image, b.author, u.first_name, u.last_name, u.email')
            ->join('books b', 'b.id = l.book_id')
            ->join('users u', 'u.id = l.user_id')
            ->where('l.type', 'loan')
            ->where('l.due_date <', date('Y-m-d'))
            ->where('l.status', 'active')
            ->orderBy('l.due_date', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function isBookBorrowed($bookId)
    {
        return $this->where('book_id', $bookId)
                   ->where('type', 'loan')
                   ->whereIn('status', ['active', 'overdue'])
                   ->countAllResults() > 0;
    }

    public function isBookReserved($bookId)
    {
        return $this->where('book_id', $bookId)
                   ->where('type', 'reservation')
                   ->where('status', 'reserved')
                   ->countAllResults() > 0;
    }

    public function updateOverdueLoans()
    {
        $this->where('type', 'loan')
             ->where('due_date <', date('Y-m-d'))
             ->where('status', 'active')
             ->set('status', 'overdue')
             ->update();
    }

    public function getLoanStats()
    {
        return [
            'total_loans' => $this->where('type', 'loan')->countAllResults(),
            'active_loans' => $this->where('type', 'loan')->where('status', 'active')->countAllResults(),
            'overdue_loans' => $this->where('type', 'loan')->where('status', 'overdue')->countAllResults(),
            'returned_loans' => $this->where('type', 'loan')->where('status', 'returned')->countAllResults(),
            'total_reservations' => $this->where('type', 'reservation')->countAllResults(),
            'active_reservations' => $this->where('type', 'reservation')->where('status', 'reserved')->countAllResults(),
            'cancelled_reservations' => $this->where('type', 'reservation')->where('status', 'cancelled')->countAllResults()
        ];
    }

    public function countUserActiveLoans($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('type', 'loan')
                   ->whereIn('status', ['active', 'overdue'])
                   ->countAllResults();
    }

    public function countUserActiveReservations($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('type', 'reservation')
                   ->where('status', 'reserved')
                   ->countAllResults();
    }

    public function getUserActiveLoans($userId)
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title, b.author, b.cover_image, b.isbn, b.category')
            ->join('books b', 'b.id = l.book_id')
            ->where('l.user_id', $userId)
            ->where('l.type', 'loan')
            ->whereIn('l.status', ['active', 'overdue'])
            ->orderBy('l.due_date', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getUserReservations($userId)
    {
        return $this->db->table('loans l')
            ->select('l.*, b.title, b.author, b.cover_image, b.isbn, b.category')
            ->join('books b', 'b.id = l.book_id')
            ->where('l.user_id', $userId)
            ->where('l.type', 'reservation')
            ->where('l.status', 'reserved')
            ->orderBy('l.reservation_date', 'DESC')
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

    public function createReservation($data)
    {
        $reservationData = [
            'book_id' => $data['book_id'],
            'user_id' => $data['user_id'],
            'reservation_date' => date('Y-m-d H:i:s'),
            'expiry_date' => date('Y-m-d H:i:s', strtotime('+48 hours')),
            'status' => 'reserved',
            'type' => 'reservation',
            'created_by' => $data['user_id']
        ];
        
        return $this->insert($reservationData);
    }

    public function convertReservationToLoan($reservationId, $adminId)
    {
        $reservation = $this->find($reservationId);
        
        if (!$reservation || $reservation['type'] !== 'reservation') {
            return false;
        }

        $loanData = [
            'type' => 'loan',
            'status' => 'active',
            'loan_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+30 days')),
            'reservation_date' => null,
            'expiry_date' => null,
            'created_by' => $adminId
        ];

        return $this->update($reservationId, $loanData);
    }

    public function getExpiredReservations()
    {
        return $this->where('type', 'reservation')
                   ->where('status', 'reserved')
                   ->where('expiry_date <', date('Y-m-d H:i:s'))
                   ->findAll();
    }

    public function cancelReservation($reservationId)
    {
        return $this->where('id', $reservationId)
                   ->where('type', 'reservation')
                   ->set('status', 'cancelled')
                   ->update();
    }

    public function hasUserReservedBook($userId, $bookId)
    {
        return $this->where('user_id', $userId)
                   ->where('book_id', $bookId)
                   ->where('type', 'reservation')
                   ->where('status', 'reserved')
                   ->countAllResults() > 0;
    }
}
