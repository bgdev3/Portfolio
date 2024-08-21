<?php
namespace Portfolio\Controllers;

use Portfolio\Models\ProductionModel;

session_start();

class ProductionsController extends Controller
{
    
    /**
     * Affiche les différentes productions en effectuant une jointure
     * sur les tables productions et templates afin d'afficher les différentes infos relatives
     * aux enregistrements
     */
    public function index(): void 
    {
       $productions = [];
        // Récupère toutes les productions
       $model = new ProductionModel();
       $lists = $model->findAll();

        //Sur chacune d'elles, effectue une jointure stockés dans un array
        foreach($lists as $list) {
         array_push($productions,  $model->join($list->idProduction));
        }

        // Renvoi les jointures à la vue correspondante
       $this->render('productions/index', ['productions' => $productions]);
    }
}