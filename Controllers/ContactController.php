<?php
namespace Portfolio\Controllers;

use Portfolio\Core\Mailer;

class ContactController extends Controller
{
    /**
     * Traite les données de fomrulaire
     * 
     * @var bool $validePost  Récupère le booleén de la méthode
     * @var string $error Récupère le message d'erreur
     */
    public function index(): void
    {
        global $error;
        // Si les champs ne sont pas vides
        if ($this->validatePost($_POST, ['name', 'surname', 'email', 'phone', 'object', 'message'])) {

            // Si le format de tel correspond
            if (!preg_match("#^(\+33|0)[67][0-9]{8}$#", $_POST['phone'])) {
                // Stocke le message d'erreur
                $error = 'Le format du numéro de téléphone n\'est pas valide.';
            // Si l'email correspond
            } elseif (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
                // Stocke le message d'erreur
                $error = 'Le format de l\'email n\'est pas valide.';
            }  
            // Envoi du mail
            $mailer = new Mailer();
            $mailer = $mailer->sendMail($_POST);

            // Si l'envoi du mail s'est bien déroulé, sinon on stocke le message d'erreur.
            $error = !(empty($mailer)) ? $mailer : '';
        // Sinon un message correspondant est indiqué
        } else {
            $error = !(empty($_POST)) ? 'Merci de remplir tous les champs' : '';  
        }
        // renvoi vers la vue
        $this->render('contact/index', ['error' => $error]);
    }


    /**
     * Vérifie que les données du formulaire ne sont pas vides.
     * 
     * @param array $post methode d'envoi envoyé par le formulaire
     * @param array fields Données envoyées par le formulaire
     * 
     */
    private function validatePost(array $post, array $fields): bool
    {
         // Chaque champs est parcouru
         foreach( $fields as $field){
            // On teste si les champs sont vides ou déclarés
            if (empty($post[$field]) || !isset($post[$field])) {
                return false;
            }
        }
        return true;
    }
}