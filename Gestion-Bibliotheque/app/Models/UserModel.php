<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'password', 'first_name', 'last_name', 
        'phone', 'address', 'date_of_birth', 'status',
        'student_id', 'institution', 'specialization', 'professional_title',
        'role', 'is_active', 'membership_expiry', 
        'activation_code', 'reset_token', 'reset_expires'
    ];
    protected $useTimestamps = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    public function checkLogin($email, $password)
    {
        $user = $this->where('email', $email)
                     ->where('is_active', 1)
                     ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function emailExists($email)
    {
        return $this->where('email', $email)->first() !== null;
    }

    public function createActivationCode()
    {
        return bin2hex(random_bytes(16));
    }

    public function createResetToken()
    {
        return bin2hex(random_bytes(16));
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function findByActivationCode($code)
    {
        return $this->where('activation_code', $code)->first();
    }

    public function findByResetToken($token)
    {
        return $this->where('reset_token', $token)
                    ->where('reset_expires >', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function getUsersByStatus($status)
    {
        return $this->where('status', $status)
                    ->where('is_active', 1)
                    ->findAll();
    }

    public function updateMembershipExpiry($userId, $expiryDate)
    {
        return $this->update($userId, ['membership_expiry' => $expiryDate]);
    }

    public function getExpiringMemberships($days = 7)
    {
        return $this->where('membership_expiry >=', date('Y-m-d'))
                    ->where('membership_expiry <=', date('Y-m-d', strtotime("+$days days")))
                    ->where('is_active', 1)
                    ->findAll();
    }
}