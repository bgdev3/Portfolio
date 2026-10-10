<?php 

namespace Portfolio\Controllers;

use Portfolio\Models\AdminUserModel;

class HomeController extends Controller{

    public function __construct (
        private readonly AdminUserModel $adminUserModel
    ){}

     /**
      * Renvoi la page d'accueil en mettant à jour le bon cv
      */
    /**
     * Renvoi la page d'accueil en mettant à jour le bon cv
     */
    public function index(): void{

        $data_profile = $this->adminUserModel->findProfile();
        $this->render('home/index', ['data_profile' => $data_profile]);
    }   

     // Renvoi vers les mentions légales
     public function mentions(): void 
     {
        $this->render('home/mentions');
     }
}