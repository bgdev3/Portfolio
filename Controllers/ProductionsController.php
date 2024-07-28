<?php

namespace Portfolio\Controllers;

session_start();

class ProductionsController extends Controller
{
    public function index()
    {
       
            //  var_dump($size);
         // Instancie le modèle et effectrue une lecture de la table
         // des enregistrements correspondants à la valeur donnée
        //  $model = new SlideshowAdminModel();
        //  $slides = $model->findAll($_SESSION['size']);
         $data = $this->addSlide();
        
        $this->render('productions/index', ['data' => $data]);
    }
   
    // /* Récupère la largeur d'écran en pixel 
    //  * afin de récupèrer les bonnes images redimensionnées sur le serveur
    //  * Puis renvoi le tableau de données au JS afin d'afficher les images récupérées
    //  */
    private function addSlide()
    {
         // Récupère la taille d'écran 
         $content = trim(file_get_contents("php://input"));
         $data = json_decode($content, true);
         $_SESSION['data'] = $data;
        global $size;
         // Assigne la valeur selon les pixels retournés
         // dans une session afin de stocker le fomrat de photos à intégrer
            if ($data  >= 1024) {
 
                 $size= 'normal';
                //  $size = array ('w' => 1350,'h' => 495);
 
            } elseif ($data > 576 && $data  <= 1024) {
 
                 $size = 'medium';
                //  $size = array ('w' => 800,'h' => 300);
 
            } elseif ($data <= 576) {
 
                 $size = 'small';
                //  $size = array ('w' => 500,'h' => 183);
             }

             return $data;
    }
}