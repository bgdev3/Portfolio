<?php 

namespace Portfolio\Controllers;

use Portfolio\Models\AdminUserModel;

class HomeController extends Controller{

    public function __construct (
        private AdminUserModel $adminUserModel
    ){}

     /**
      * Renvoi la page d'accueil en mettant à jour le bon cv
      */
    /**
     * Renvoi la page d'accueil en mettant à jour le bon cv
     */
    public function index(): void{

        $cv = $this->adminUserModel->findCv();
        $this->render('home/index', ['cv' => $cv]);
    }   

     // Renvoi vers les mentions légales
     public function mentions(): void 
     {
        $this->render('home/mentions');
     }
}