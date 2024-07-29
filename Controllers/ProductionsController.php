<?php
namespace Portfolio\Controllers;

use Portfolio\Models\ProductionModel;

session_start();

class ProductionsController extends Controller
{
    
    public function index(): void 
    {

       global $pictures;
       
            $model = new ProductionModel();
            $pictures = $model->findAll();
      
        
        $this->render('productions/index', ['pictures' => $pictures]);
    }
   
}