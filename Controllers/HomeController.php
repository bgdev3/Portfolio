<?php 
 namespace Portfolio\Controllers;

class HomeController extends Controller{

    public function index(): void{

        $this->render('home/index');
    }   

     // Renvoi vers les mentions légales
     public function mentions(): void 
     {
        $this->render('home/mentions');
     }
}