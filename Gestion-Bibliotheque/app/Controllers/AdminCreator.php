<?php
namespace App\Controllers;

use App\Models\UserModel;

class AdminCreator extends BaseController
{
    public function createAdmin()
    {
        $userModel = new UserModel();
        
        $adminData = [
            'email' => 'superadmmmin@bibliotheque.com',
            'password' => 'Mot2Passe$ecurise2024!', // ← Sera hashé automatiquement
            'first_name' => 'Super',
            'last_name' => 'Administrateur',
            'role' => 'admin',
            'is_active' => 1,
            'status' => 'librarian',
            'institution' => 'Bibliothèque Centrale',
            'membership_expiry' => date('Y-m-d', strtotime('+5 years'))
        ];
        
        try {
            $userModel->insert($adminData);
            
            echo "🎉 Administrateur créé avec succès !<br><br>";
            echo "<strong>Identifiants de connexion :</strong><br>";
            echo "Email: superadmin@bibliotheque.com<br>";
            echo "Mot de passe: Mot2Passe\$ecurise2024!<br><br>";
            echo '<a href="' . site_url('login') . '" class="btn btn-success">Se connecter maintenant</a>';
            
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage();
        }
    }
    
    public function createMultipleAdmins()
    {
        $userModel = new UserModel();
        
        $admins = [
            [
                'email' => 'directeur@bibliotheque.com',
                'password' => 'Directeur123!',
                'first_name' => 'Pierre',
                'last_name' => 'Durand',
                'role' => 'admin',
                'is_active' => 1,
                'status' => 'librarian'
            ],
            [
                'email' => 'bibliothecaire@bibliotheque.com', 
                'password' => 'Biblio2024!',
                'first_name' => 'Marie',
                'last_name' => 'Lefebvre',
                'role' => 'admin',
                'is_active' => 1,
                'status' => 'librarian'
            ]
        ];
        
        foreach ($admins as $admin) {
            $userModel->insert($admin);
            echo "✅ Admin " . $admin['email'] . " créé<br>";
        }
        
        echo '<br><a href="' . site_url('login') . '">Se connecter</a>';
    }
}