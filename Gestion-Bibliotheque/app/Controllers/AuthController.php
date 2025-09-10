<?php
namespace App\Controllers;

use App\Models\UserModel;
use Config\Services;

class AuthController extends BaseController
{
    protected $validation;
    protected $userModel;

    public function __construct()
    {
        $this->validation = Services::validation();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function register()
    {
        $data = [
            'title' => 'Inscription - Bibliothèque en Ligne',
            'validation' => $this->validation
        ];
        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
            'address' => 'permit_empty|max_length[500]',
            'date_of_birth' => 'permit_empty|valid_date',
            'status' => 'required|in_list[student,teacher,professor,professional,other]',
            'institution' => 'permit_empty|max_length[255]',
            'student_id' => 'permit_empty|max_length[50]',
            'professional_title' => 'permit_empty|max_length[100]',
            'specialization' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if ($this->userModel->emailExists($this->request->getPost('email'))) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cet email est déjà utilisé');
        }

        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'status' => $this->request->getPost('status'),
            'institution' => $this->request->getPost('institution'),
            'student_id' => $this->request->getPost('student_id'),
            'professional_title' => $this->request->getPost('professional_title'),
            'specialization' => $this->request->getPost('specialization'),
            'activation_code' => $this->userModel->createActivationCode(),
            'membership_expiry' => date('Y-m-d', strtotime('+1 year')),
            'is_active' => 1
        ];

        try {
            $this->userModel->insert($userData);
            
            return redirect()->to('/login')
                ->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'inscription: ' . $e->getMessage());
        }
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(session('user_role') === 'admin' ? '/admin/dashboard/accueil' : '/dashboard');
        }
        
        $data = ['title' => 'Connexion - Bibliothèque en Ligne'];
        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->checkLogin($email, $password);

        if ($user) {
            $sessionData = [
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'user_name' => $user['first_name'] . ' ' . $user['last_name'],
                'user_first_name' => $user['first_name'],
                'user_last_name' => $user['last_name'],
                'user_role' => $user['role'],
                'user_status' => $user['status'],
                'logged_in' => true
            ];

            session()->set($sessionData);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard/accueil')
                    ->with('success', 'Bienvenue Administrateur ' . $user['first_name'] . ' !');
            } else {
                return redirect()->to('/dashboard')
                    ->with('success', 'Bienvenue ' . $user['first_name'] . ' !');
            }
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Email ou mot de passe incorrect');
    }

    public function logout()
    {
        $userName = session()->get('user_first_name', 'Utilisateur');
        session()->destroy();
        
        return redirect()->to('/')
            ->with('success', 'Au revoir ' . $userName . ' ! Vous êtes déconnecté.');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function attemptForgotPassword()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $resetToken = $this->userModel->createResetToken();
            $resetExpires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->userModel->update($user['id'], [
                'reset_token' => $resetToken,
                'reset_expires' => $resetExpires
            ]);

            return redirect()->to('/login')
                ->with('success', 'Un email de réinitialisation a été envoyé');
        }

        return redirect()->back()
            ->with('error', 'Email non trouvé');
    }

    public function resetPassword($token)
    {
        $user = $this->userModel->findByResetToken($token);

        if (!$user) {
            return redirect()->to('/login')
                ->with('error', 'Token invalide ou expiré');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function attemptResetPassword()
    {
        $token = $this->request->getPost('token');
        $user = $this->userModel->findByResetToken($token);

        if (!$user) {
            return redirect()->to('/login')
                ->with('error', 'Token invalide ou expiré');
        }

        $rules = [
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($user['id'], [
            'password' => $this->request->getPost('password'),
            'reset_token' => null,
            'reset_expires' => null
        ]);

        return redirect()->to('/login')
            ->with('success', 'Mot de passe réinitialisé avec succès');
    }
}