<?php 
error_reporting(E_ALL);
ini_set("display_errors", "on");

// Importe l'autoloader de composer
require '../vendor/autoload.php';

use Portfolio\Core\Router;

// Instancie le routeur
$route = new Router();
// lance l'application
$route->routes();