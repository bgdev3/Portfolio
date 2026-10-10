<?php
namespace Portfolio\Controllers;


use Portfolio\Entities\Admin;
use Portfolio\Models\AdminUserModel;
use Portfolio\Services\Captcha;
use Portfolio\Services\Form;
use Portfolio\Services\ImageGenerate;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AdminController extends Controller
{
    public function __construct (
        private  readonly Form $form,
        private  readonly Captcha $captcha,
        private  readonly AdminUserModel $adminUserModel,
        private  readonly Admin $admin,
        private readonly ImageGenerate $image
    ){}

    /**
     * Traite les données de connexion admin
     */
    public function index(): void
    {
        $error = '';
        $captcha = false;
        // Si les champs ne sont pas vides
        if ($this->form->validatePost($_POST, ['email', 'password'])) {


            // si la clé en post de vérifiaction du captcha est déclaré
            // if (isset($_POST['recaptcha_response']))
            //     $captcha = $this->captcha->verify($_POST['recaptcha_response']);
            
            // Si la reponse du captcha est valide
            // if ($captcha == true) {
                // Filtre le bon format d'email
                if (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
                    // Stocke le message d'erreur
                    $error = 'Le format de l\'email n\'est pas valide.';
                } 
                // Si l'email est bien déclaré
                $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
                // Si le mdp est bien déclaré
                $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
                
                // Si les tokens correspondent pour contrer une faille CSRF
                if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
                    // $admin = new AdminUserModel();
                    // Récupère l'enregistrement correspondant
                    $admin = $this->adminUserModel->find($email);
                    // Teste le bon mot de passe renseigné par l'administrateur
                    $error = $this->validateAuth($email, $password, $admin);
                } else {
                    // Sinon redirige directement vers l'index en supprimant les données de connexion
                    session_unset();
                    session_destroy();
                    header('location:/public/');
                    exit();
                }
            // } else {
            //     $error = "Le reCaptcha n'est pas valide";
            // }
           
        } else {
            $error = !empty($_POST) ?  "Veuillez remplir tous les champs" : "";
        }
        // Renvoi à la vue
        $this->render('admin/index', ['error' => $error]);
    }



    public function register($token): void
    {
        $error = '';
        $nb = 1;
         $imagePaths =[]; $arrayFiles = []; 
        $captcha = false;
        // Si les champs ne sont pas vides
        if ($this->form->validatePost($_POST, ['surname', 'email', 'password'])
             && $this->form->validateFiles($_FILES, ['profile', 'cv'])) {

            $type = array('jpg'=>'image/jpeg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png','pdf'=>'application/pdf');
             // Si un erreur est déclarée sur un des fichier uploadés
             $error = empty($erreur) ? $this->form->errorUpload($_FILES, ['profile', 'cv'], $type) : "" ;
             // Formate les noms de fichier sformatés dans un array 
             $profiles = $this->form->formateFileAdmin($_FILES, ['profile', 'cv']);

              $arrayFiles =  ['profile', 'cv'];

            //  if (file_exists('img/'. $file)) {
            //     $erreur = $file . " déja existant !";
            // } else {
            //     move_uploaded_file($_FILES['cv']["tmp_name"], "img/" . $file);
            // }
            // $cv = "img/" . $file;
             if (empty($error)) {
                        // Boucle sur chaque fichier image  récupérés
                foreach ($profiles as $i => $profile) {
                    $key = $arrayFiles[$i];
                    $tmpPath = $_FILES[$key]['tmp_name'];

                    if ($key === 'profile') {
                        $path = $this->image->imageSize($profile, $tmpPath, 500, 500);
                    } else {
                        $path = 'img/' . $profile;
                        if (!move_uploaded_file($tmpPath, $path)) {
                            $path = '';
                        }
                    }

                    if ($path === '') {
                        $error = $_SESSION['error'] ?? "Erreur lors de l'envoi des fichiers";
                        unset($_SESSION['error']);
                        break;
                    }
                    $imagePaths[] = $path;
                }
             }
             // Instance du reCpatcha
            //  $captcha = new Captcha();

             // si la clé en post de vérifiaction du captcha est déclaré
            //  if (isset($_POST['recaptcha_response']))
                //  $captcha = $this->captcha->verify($_POST['recaptcha_response']);
            
             // Si la reponse du captcha est valide
            //  if ($captcha == true) {
                // Récupère les valeurs POST en supprimant les espace et agissant contre la faille XSS
                $surname = isset($_POST['surname']) ? trim(htmlspecialchars($_POST['surname'], ENT_QUOTES)) : "";
                $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'], ENT_QUOTES)) : "";
                $password = $_POST['password'];

                // Si le mdp est supérieur à une longuer de 12
                if(strlen($password) >= 12) {
                    // Si le mot de passe contient des cartères spéciaux et s'il contient au moins un chiffre et une lettre
                    if(!ctype_alnum($password) && preg_match('#([a-z][0-9])#', $password)) {
                        // Si les tokens correspondent afin de contrer une faile CSRF
                        if(isset($_GET['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
                           
                            // Instance de l'entité
                            // $admin = new Admin();
                            // Hash le mdp avec l'algo le plus récent et hydrate
                            $password = password_hash($password, PASSWORD_DEFAULT);
                            $this->admin->setSurname($surname);
                            $this->admin->setProfile($imagePaths[0]);
                            $this->admin->setEmail($email);
                            $this->admin->setPathCv($imagePaths[1]);
                            $this->admin->setPassword($password);
                            // Effectue la mise à jour
                            // $adminModel = new AdminUserModel();
                            $this->adminUserModel->update($_SESSION['id_admin'], $this->admin);

                            // Supprime les données administrateur et redirige vers la page de connexion
                            unset( $_SESSION['username_admin']);
                            unset($_SESSION['id_admin']);
                            header('location:/public/admin');
                            exit();
                        } else {
                            // Sinon redirige directement vers l'index en supprimant les données de connexion
                            session_unset();
                            session_destroy();
                            header('location:/public/');
                            exit();
                        }
                        
                    } else {
                        $error = " Le mot de passe doit contenir au moins une majuscule et un caractère spécial";
                    }
                } else {
                    $error = "Le mot de passe doit être d'une longeure minimale de 12 caractères";
                }
            // }else {
            //     $error = "Le reCaptcha n'est pas valide";
            // }
        }
        // Renvoi les données à la vue
        $this->render('admin/register', ['error' => $error]);
    }


    /**
    * Valide l'authentification de l'administrateur 
    * 
    * @param string $email récupère l'email afin de tester si l'administrateur existe
    * @param string $password récupère le mdp hashé afin de le tester
    * @param object $admin récupère l'objet creation AdminUserModel;
    * 
    * @return string $error Le message d'erreur
    */
    private function validateAuth($email, $password, $admin): string
    {
        $error ='';
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
                            if (password_verify($password, $admin->password)) {
                                // Génère un nouvel PHPSESSID afin d'eviter un détournement de session
                                // et on stocke le nom d'utilisateur et l-ID puis on redirige vers la liste des réservations
                                session_regenerate_id();
                                $_SESSION['username_admin'] = $admin->surname;
                                $_SESSION['id_admin'] = $admin->idUser;
                    
                                header("location:/public/adminProduction");
                            } else {
                                $error = "Le mot de passe est incorrect";
                            }
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
    

    public function logOut($token): void
    {
        if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            session_unset();
            session_destroy();

            header('location:/public/');
            exit();
        }
    }
}