<?php 

namespace Portfolio\Controllers;

use Portfolio\Models\AdminUserModel;

class HomeController extends Controller{

    /**
     * Renvoi la page d'accueil en mettant à jour le bon cv
     */
    public function index(): void{

        $admin = new AdminUserModel();
        $cv = $admin->findCv();
        $this->render('home/index', ['cv' => $cv]);
    }   

     // Renvoi vers les mentions légales
     public function mentions(): void 
     {
        $this->render('home/mentions');
     }
}