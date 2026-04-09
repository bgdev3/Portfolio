<?php 
namespace Portfolio\Core;

class Router
{
    
    private array $allowedControllers;

    public function __construct()
    {
        $this->allowedControllers = $this->loadAllowedControllers();
    }

    /**
     * Charge la liste blanche depuis le fichier .env
     */
    private function loadAllowedControllers(): array
    {
        $envPath = dirname(__DIR__) . '/.env'; // adapte le chemin selon ta structure

        if (!file_exists($envPath)) {
            throw new \RuntimeException("Fichier .env introuvable : $envPath");
        }

        // Lit le fichier .env et cherche la variable ALLOWED_CONTROLLERS
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Parcourt les lignes du fichier .env
        foreach ($lines as $line) {
            // Ignore les commentaires
            if (str_starts_with(trim($line), '#')) continue;

            // Si la ligne commence par ALLOWED_CONTROLLERS=, extrait la valeur
            if (str_starts_with($line, 'ALLOWED_CONTROLLERS=')) {
                $value = explode('=', $line, 2)[1];
                return array_map('trim', explode(',', $value));
            }
        }

        throw new \RuntimeException("Variable ALLOWED_CONTROLLERS absente du .env");
    }

    // Route les requêtes entrantes vers les contrôleurs et actions appropriés
    public function routes(): void
    {
        // Récupère le nom du contrôleur depuis $_GET ou utilise 'Home' par défaut
        $controllerName = isset($_GET['controller'])
            ? ucfirst(array_shift($_GET))
            : 'Home';

        // Vérifie que le contrôleur est dans la liste blanche avant toute instanciation
        if (!in_array($controllerName, $this->allowedControllers, true)) {
            http_response_code(404);
            echo "La page recherchée n'existe pas";
            return;
        }

        // Construit le nom de la classe du contrôleur
        $controllerClass = '\\Portfolio\\Controllers\\' . $controllerName . 'Controller';
        $action = isset($_GET['action']) ? array_shift($_GET) : 'index';

        $controller = new $controllerClass();

        // Si la méthode existe, l'exécute
        if (method_exists($controller, $action)) {
            isset($_GET)
                ? call_user_func_array([$controller, $action], $_GET)
                : $controller->$action();
        } else {
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    }
}