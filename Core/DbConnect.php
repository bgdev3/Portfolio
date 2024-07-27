<?php 

namespace Portfolio\Core;

use PDO;
use Exception;

class DbConnect
{
    // Variables protégées
    protected $connexion;
    protected $request;

    // Constante
    const SERVEUR = 'localhost'/*'127.0.0.1:3306'*/;
    const USER = 'root'/*'u572485290_abcdtaxi'*/;
    const PASSWORD = ''/*'6vzA6U!^T'*/;
    const BASE = 'portfolio'/*'u572485290_abcdtaxi'*/;

    // Constructeur qui initialise la connexion lors de l'instanciation de la classe
    public function __construct()
    {
        // Si la connexion se déroule bien on se connecte
        // sinon on capture une exception
        try {
            $this->connexion = new PDO('mysql:host=' . self::SERVEUR . ';dbname=' . self::BASE, self::USER, self::PASSWORD);
            // Activation des erreurs PDO
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Retour des requêtes en tableau objet
            $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            // Encodag epar default en utf-8
            $this->connexion->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAME utf8');

        // Capture l'erreur
        } catch ( exception $e) {
            die('Erreur:' . $e->getMessage());
        }
    }
}