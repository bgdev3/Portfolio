<?php
namespace Portfolio\Controllers;

use Portfolio\Services\Form;
use Portfolio\Services\Mailer;
use Portfolio\Services\Captcha;

class ContactController extends Controller
{

    public function __construct (
        private Form $form,
        private Captcha $captcha, 
        private Mailer $mailer
    ){}
    /**
     * Traite les données de fomrulaire
     * 
     * @var bool $validePost  Récupère le booleén de la méthode
     * @var string $error Récupère le message d'erreur
     */
    public function index(): void
    {
          $message = '';
          $error = '';
          $captcha = false;
      
        // Si les champs ne sont pas vides
        if ($this->form->validatePost($_POST, ['name', 'surname', 'email', 'phone', 'object', 'message'])) {


            // // si la clé en post de vérifiaction du captcha est déclaré
            if (isset($_POST['recaptcha_response']))
                $captcha = $this->captcha->verify($_POST['recaptcha_response']);
            
            // // Si la reponse du captcha est valide
            if ($captcha == true) {
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
                $mailer = $this->mailer->sendMail($_POST);

                // Selon le bon déroulement de l'email, une notifictaion est spécifié
                !empty($mailer) ? $error = $mailer : $message = "Votre messsage a bien été envoyé. <br> Votre demande sera traitée dans les plus brefs délais.";
            } else {
                $error = "Le reCpatcha n'est pas valide.";
            }  
        // Sinon un message correspondant est indiqué
        } else {
            $error = !(empty($_POST)) ? 'Merci de remplir tous les champs' : '';  
        }
        // renvoi vers la vue
        $this->render('contact/index', ['error' => $error, 'message' => $message]);
    }
}