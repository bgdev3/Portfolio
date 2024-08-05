<?php
namespace Portfolio\Controllers;

use Portfolio\Core\Form;
use Portfolio\Models\AdminUserModel;

session_start();

class AdminController extends Controller
{
    /**
     * Traite les données de connexion admin
     */
    public function index()
    {
        global $error;
        // Si les champs ne sont pas vides
        if(Form::validatePost($_POST, ['email', 'password'])) {

            // Filtre le bon format d'email
            if (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
                // Stocke le message d'erreur
                $error = 'Le format de l\'email n\'est pas valide.';
            } 
            // Si l'email est bien déclaré
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
            // Si le mdp est bien déclaré
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;

            $admin = new AdminUserModel();
            // Récupère l'enregistrement correspondant
            $admin = $admin->find($email);
            // Teste le bon mot de passe renseigné par l'administrateur
            $error = $this->validateAuth($email, $password, $admin);
        } else {
            $error = !empty($_POST) ?  "Veuillez remplir tous les champs" : "";
        }
        // Renvoi à la vue
        $this->render('admin/index', ['error' => $error]);
    }


    /**
    * Valide l'authentification de l'administrateur 
    * 
    * @param string [email] récupère l'email de l'admin
    * @param string [password] récupère le mdp hashé afin de le tester
    * @param object [admin] récupère l'objet creation AdminUserModel;
    * 
    * @return string $error Le message d'erreur
    */
    private function validateAuth($email, $password, $admin): string
    {
        // Si la session n'existe pas
        if (!isset($_SESSION['username_admin'])) {
            // Si les champs ne sont pas vides et si token est bien déclaré
            if ($email!= null && $password != null && isset($_SESSION['token']) && isset($_SESSION['token_time'])) {
                // Si la SESSION token correspond au POST Token
                if ($_SESSION['token'] == $_POST['token']) {
                    $timestamp = time() - 10 * 60;
                    // Si le jeton n'est pas expiré
                    if ($_SESSION['token_time'] >= $timestamp) {
                        // Si l'utilisateur existe et si le nbUser correspond
                        if ($admin) {
                            // if (password_verify($password, $admin->password)) {
                                // Génère un nouvel PHPSESSID afin d'eviter un détournement de session
                                // et on stocke le nom d'utilisateur et l-ID puis on redirige vers la liste des réservations
                                session_regenerate_id();
                                $_SESSION['username_admin'] = $admin->surname;
                                $_SESSION['id_admin'] = $admin->idUser;
                    
                                header("location:index.php?controller=adminProduction&action=index");
                            // } else {
                            //     $error = "Le mot de passe est incorrect";
                            // }
                        } else {
                        $error =  "Une erreur est survenue";
                        }
                    } else {
                    $error=  "Le delai de connexion a expiré";
                    }
                } else {
                $error = "Il semble qu'il y ai un problème";
                }
            } else {
            $error =  "L'email ou le mot de passe est incorrect";
            }
        } else {
        $error =  "Vous êtes déja connecté en tant que ". $_SESSION['username_admin'];
        }
        return $error;
    }
}