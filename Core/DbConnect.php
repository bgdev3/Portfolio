<?php 

namespace Portfolio\Core;

use PDO;
use Exception;

class DbConnect
{
    // Variables protégées
    protected $connexion;
    protected $request;

   // Constructeur qui initialise la connexion lors de l'instanciation de la classe
    public function __construct()
    {
        // Lecture des variables d'environnement définies dans le fichier .env
        // (chargé via vlucas/phpdotenv dans index.php)

        $serveur  = getenv('DB_SERVEUR')  ?: 'localhost';
        $user     = getenv('DB_USER')     ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'test';
        $base     = getenv('DB_BASE')     ?: 'portfolio';

        try {
            $dsn = 'mysql:host=' . $serveur . ';dbname=' . $base . ';charset=utf8mb4';

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false, // meilleure sécurité
            ];

            $this->connexion = new PDO($dsn, $user, $password, $options);

        } catch (Exception $e) {
            // On log l'erreur sans l'exposer à l'utilisateur
            error_log('Erreur de connexion BDD : ' . $e->getMessage());
            die('Une erreur de connexion est survenue. Veuillez réessayer plus tard.');
        }
    }
}