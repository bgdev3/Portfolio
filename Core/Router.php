<?php 
namespace Portfolio\Core;

class Router
{
    public function routes(): void
    {
        // On teste si la superGlobal $_GET[controller] est déclaré et non vide, puis on ajoute l epremier index de $_GET
        // dans la variable $controller, ou par default home, ainsi que son namespace et le mot controller
        // pour compléter le nom de la classe à instancier.
        $controller = (isset($_GET['controller'])) ? ucfirst(array_shift($_GET)) : 'Home';
        $controller = '\\Portfolio\\Controllers\\' . $controller . 'Controller';

          // On teste si la superGlobale est déclaré et non vide puis on ajoute le premier index 
        // à la variable $action, sinon index.
        $action = (isset($_GET['action'])) ? array_shift($_GET) : 'index';
        
        // Instancie le controller récupéré dans la variable
        $controller = new $controller();

        // Si la méthode existe
        if(method_exists($controller, $action)) {
            // Si get est déclaré, la méthode appelle le controller instancié et le nom de la méthode du controller 
            // récupéré dans la variable action afon d'executer la méthode corredspodante, sinon execute la méthode par default
            isset($_GET) ? call_user_func_array([$controller, $action], $_GET) : $controller -> $action();

        } else {
             // Sinon on affiche la page 404
             http_response_code(404);
             echo "La page recherché n'existe pas";
        }
    }


}