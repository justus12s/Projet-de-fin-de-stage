<?php
namespace App\Controllers;

use App\Models\UserModel;

class AdminUserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url', 'text']);
    }

    /**
     * Affiche la liste des utilisateurs avec filtres
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        $role = $this->request->getGet('role');
        $status = $this->request->getGet('status');
        
        // Construction de la requête
        $builder = $this->userModel;

        if (!empty($search)) {
            $builder->groupStart()
                   ->like('first_name', $search)
                   ->orLike('last_name', $search)
                   ->orLike('email', $search)
                   ->orLike('student_id', $search)
                   ->groupEnd();
        }
        
        if (!empty($role) && in_array($role, ['admin', 'user'])) {
            $builder->where('role', $role);
        }
        
        if (!empty($status) && in_array($status, ['active', 'inactive'])) {
            $isActive = ($status === 'active') ? 1 : 0;
            $builder->where('is_active', $isActive);
        }

        $users = $builder->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'page_title' => 'Gestion des Utilisateurs',
            'users' => $users,
            'total_users' => $this->userModel->countAll(),
            'total_admins' => $this->userModel->where('role', 'admin')->countAllResults(),
            'total_users' => $this->userModel->where('role', 'user')->countAllResults(),
            'total_active' => $this->userModel->where('is_active', 1)->countAllResults(),
            'search' => $search,
            'selected_role' => $role,
            'selected_status' => $status
        ];

        return view('dashboard/section_users', $data);
    }

    /**
     * Affiche le formulaire de création d'utilisateur
     */
    public function create()
    {
        $data = [
            'page_title' => 'Ajouter un Utilisateur',
            'validation' => \Config\Services::validation()
        ];

        return view('dashboard/create_user', $data);
    }

    /**
     * Traite la création d'un nouvel utilisateur
     */
    public function store()
    {
        $validationRules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,user]',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
            'address' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]',
            'student_id' => 'permit_empty|max_length[50]',
            'institution' => 'permit_empty|max_length[100]',
            'specialization' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'is_active' => ($this->request->getPost('status') === 'active') ? 1 : 0,
            'student_id' => $this->request->getPost('student_id'),
            'institution' => $this->request->getPost('institution'),
            'specialization' => $this->request->getPost('specialization'),
            'professional_title' => $this->request->getPost('professional_title'),
            'date_of_birth' => $this->request->getPost('date_of_birth')
        ];

        // Gestion de la date d'expiration d'userment
        if ($this->request->getPost('membership_expiry')) {
            $userData['membership_expiry'] = $this->request->getPost('membership_expiry');
        }

        if ($this->userModel->save($userData)) {
            return redirect()->to('/admin/dashboard/users')->with('success', 'Utilisateur créé avec succès !');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'utilisateur');
        }
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function view($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Utilisateur non trouvé');
        }

        $data = [
            'page_title' => 'Détails de l\'Utilisateur - ' . $user['first_name'] . ' ' . $user['last_name'],
            'user' => $user
        ];

        return view('dashboard/view_user', $data);
    }

    /**
     * Affiche le formulaire de modification d'utilisateur
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Utilisateur non trouvé');
        }

        $data = [
            'page_title' => 'Modifier l\'Utilisateur - ' . $user['first_name'] . ' ' . $user['last_name'],
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('dashboard/edit_user', $data);
    }

    /**
     * Traite la modification d'un utilisateur
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Utilisateur non trouvé');
        }

        // Règles de validation (email unique sauf pour l'utilisateur actuel)
        $validationRules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role' => 'required|in_list[admin,user]',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
            'address' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]',
            'student_id' => 'permit_empty|max_length[50]',
            'institution' => 'permit_empty|max_length[100]',
            'specialization' => 'permit_empty|max_length[100]'
        ];

        // Si le mot de passe est fourni, on l'ajoute aux règles
        if ($this->request->getPost('password')) {
            $validationRules['password'] = 'min_length[6]';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'id' => $id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'is_active' => ($this->request->getPost('status') === 'active') ? 1 : 0,
            'student_id' => $this->request->getPost('student_id'),
            'institution' => $this->request->getPost('institution'),
            'specialization' => $this->request->getPost('specialization'),
            'professional_title' => $this->request->getPost('professional_title'),
            'date_of_birth' => $this->request->getPost('date_of_birth')
        ];

        // Mise à jour du mot de passe seulement si fourni
        if ($this->request->getPost('password')) {
            $userData['password'] = $this->request->getPost('password');
        }

        // Gestion de la date d'expiration d'userment
        if ($this->request->getPost('membership_expiry')) {
            $userData['membership_expiry'] = $this->request->getPost('membership_expiry');
        }

        if ($this->userModel->save($userData)) {
            return redirect()->to('/admin/dashboard/users')->with('success', 'Utilisateur modifié avec succès !');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'utilisateur');
        }
    }

    /**
     * Supprime un utilisateur
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Utilisateur non trouvé');
        }

        // Empêcher la suppression de son propre compte
        $session = session();
        if ($user['id'] == $session->get('user_id')) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/dashboard/users')->with('success', 'Utilisateur supprimé avec succès !');
        } else {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }

    /**
     * Active/Désactive un utilisateur
     */
    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Utilisateur non trouvé');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $statusText = $newStatus ? 'activé' : 'désactivé';

        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            return redirect()->to('/admin/dashboard/users')->with('success', "Utilisateur {$statusText} avec succès !");
        } else {
            return redirect()->to('/admin/dashboard/users')->with('error', 'Erreur lors de la modification du statut');
        }
    }

    /**
     * Génère un mot de passe aléatoire
     */
    public function generatePassword()
    {
        $password = bin2hex(random_bytes(4)); // Génère un mot de passe de 8 caractères
        return $this->response->setJSON(['password' => $password]);
    }
}