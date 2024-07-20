<?php 
namespace Portfolio\Controllers;

abstract class Controller
{
    /**
     * Redirige vers les vues
     * 
     * @param string  Récupère le chemin dans les controllers
     * @param array Récupère un tableau de données
     */
    
    public function render(string $path, array $args = []) 
    {
        // Permet d'extraire les données sous forme de variables
        extract($args);

        // On crée le buffer de sortie
        ob_start();

        // Créer le chemin et inclut le fichier de la vue souhaitée.
        include dirname(__DIR__) . '/Views/'. $path . '.php';

        // On vide le buffer dans les varibale $title et $content
        $content = ob_get_clean();

        // On fabrique le template
        include dirname(__DIR__) . '/Views/base.php';
    }
}