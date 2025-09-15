<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'book_id',
        'reserved_at',
        'status'
    ];

    protected $useTimestamps = false; // On gère 'reserved_at' manuellement
}
