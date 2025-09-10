<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page');
        }

        // Vérification des rôles si spécifiés
        if (!empty($arguments)) {
            $userRole = session()->get('user_role');
            
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/dashboard')
                    ->with('error', 'Accès non autorisé');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Après traitement - rien à faire
    }
}