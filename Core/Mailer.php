<?php
namespace Portfolio\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer 
{
    public function sendMail($post)
    {
        $data = $this->contentMail($post);
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                                   //Enable verbose debug output
            $mail->isSMTP();                                                            //Envoi en SMTP
            $mail->Host       = 'smtp.gmail.com';                                       //Adresse serveur SMTP
            $mail->SMTPAuth   = true;                                                   //Active l'authentification
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');                                    //password de l'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                            //Active l'encriptage de l'envoi
            $mail->Port       = 465;                                                    //port SMTP
        
            //Recipients
            $mail->setFrom(getenv('MAIL_USERNAME'), 'Portfolio');                      //Adresse d'envoi
            $mail->addAddress(getenv('MAIL_USERNAME'));                                //Destinatire
        
            //Content
            $mail->isHTML(true);                                                        //Format HTML activé
            $mail->CharSet= 'UTF-8';                                                    //Encodage utf-8
            $mail->Subject = $data['subject'];                                               //Email 
                            
            $mail->Body= $data['content'];                                               //Corps du mail
                                
            $mail->send();                                                              //Envoi
            $message="";
            // Si l'envoi ne s'effectue pas une exception est levé et on affiche un message d'erreur
        } catch (Exception $e) {
            $message =  "Votre message n'a pu être envoyé.";
        }
          // On retourne le message s'il y en a un.
          return $message;
      }

      private function contentMail(array $post): array
      {
        $subject = htmlspecialchars($post['object'], ENT_QUOTES, 'UTF-8');
        $name    = htmlspecialchars($post['name'],    ENT_QUOTES, 'UTF-8');
        $surname = htmlspecialchars($post['surname'], ENT_QUOTES, 'UTF-8');
        $email   = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
        $phone   = htmlspecialchars($post['phone'],   ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8');

        $content = "<html>
                        <body>
                            <header> <h1>Nouveau contact</h1> </header>
                            <main>
                                <p>Infos client :<br>
                                    Nom:". $name ."<br>Prenom:". $surname ."<br>Email:". $email ."<br>Tel:". $phone ."<br>
                                    </p>
                                    <p>Message:<br>" . $message . "
                            </main>
                        </body>
                    </html>";

         $content = array ('subject' => $subject, 'content' => $content);
         return $content;                       
      }
    }
