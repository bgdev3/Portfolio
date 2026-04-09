<?php 
error_reporting(E_ALL);
ini_set("display_errors", "on");

// Importe l'autoloader de composer
require __DIR__ . '/../vendor/autoload.php';

// Charge les variables d'environnement depuis le fichier .env
use Dotenv\Dotenv; 
use Portfolio\Core\Router;

// Charge le .env (index.php est dans public/, .env est à la racine)
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Instancie le routeur
$route = new Router();
// lance l'application
$route->routes();