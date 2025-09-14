<?php

namespace App\Controllers;

use App\Models\PromotionModel;

class Home extends BaseController
{
    public function index(): string
    {

        return view('index');
    }

    public function accueil():string
    {
        return view('auth/login');  // return view('accueil');
    }

    public function a_propos():string
    {
        return view('a_propos'); // return view('a_propos');
    }
    
    public function guide_utilisateur():string
    {
        return view('guide_utilisateur');
    }

     public function connexion():string
    {
        return view('connexion');
    }

     public function inscription():string
    {
        return view('inscription');
    }

    public function livre_description():string
    {
        return view('livre_description');
    }




}
