<?php

namespace App\Controllers;

use App\Models\PromotionModel;

class Home extends BaseController
{
    public function index(): string
    {
        /*
        // Récupération du model...
        $model_promotion = new PromotionModel();
        // CRUD 
        // Ajout->insert();
        // Lecture -> find() or findAll();
        // Modification ->update();
        // suppresion -> delete();
        $donnee = [
            'intitule' => 'Classes Préparatoires'
        ];

        $model_promotion->insert($donnee);
        
        $model_promotion = new PromotionModel();
        $all_promotion = $model_promotion->findAll();
        //$model_promotion->insert(['intitule' => 'Cycle d\ingénieur']);
        $model_promotion->delete(2);

        */
        
        return view('accueil');
    }

    public function accueil():string
    {
        return view('auth/login');  // return view('accueil');
    }

    public function a_propos():string
    {
        return view('auth/register'); // return view('a_propos');
    }

     public function catalogue():string
    {
        return view('catalogue');
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

    public function section_livre():string
    {
        return view('dashboard/section_livre');
    }

    public function add_livre():string
    {
        return view('dashboard/add_livre');
    }

     public function membre():string
    {
        return view('dashboard/membres');
    }



}
