<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    
    public function dashboard()
    {
        // Vérifier que l'utilisateur est connecté (normalement fait par le filtre)
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Mon Tableau de bord',
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email'),
                'status' => session()->get('user_status')
            ]
        ];
        
        return view('user/dashboard', $data);
    } 
    

    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        $data = [
            'title' => 'Mon Profil',
            'user' => $user
        ];
        
        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        // Logique de mise à jour du profil
        return redirect()->to('/profile')->with('success', 'Profil mis à jour');
    }

    public function myBooks()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Mes Livres Empruntés'
        ];
        
        return view('user/my_books', $data);
    }

    public function myReservations()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Mes Réservations'
        ];
        
        return view('user/my_reservations', $data);
    }
}

