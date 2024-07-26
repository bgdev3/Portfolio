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
            $mail->Username   = 'boukehaili.g@gmail.com';                               //Identifiant SMTP
            $mail->Password   = 'hekfmufaowzithcv';                                     //password de l'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                            //Active l'encriptage de l'envoi
            $mail->Port       = 465;                                                    //port SMTP
        
            //Recipients
            // email Kevin
            $mail->setFrom('boukehaili.g@gmail.com', 'Portfolio');                      //Adresse d'envoi
            $mail->addAddress('boukehaii.g@gmail.com');                                             //Destinatire
        
            // //Attachments
                                                                        //Si le paramètre facultatif est présent        
        //   $mail->addAttachment($file['file']['tmp_name'], $file['file']['name']);     //Pièce jointe : chemin du fichier temporaire, nom du fichier
        
            //Content
            $mail->isHTML(true);                                                        //Format HTML activé
            $mail->CharSet= 'UTF-8';                                                    //Encodage utf-8
            $mail->Subject = $data['subject'];                                               //Email 
                            
            $mail->Body= $data['content'];                                               //Corps du mail
                                
            $mail->send();                                                              //Envoi
            $message="";
            // Si l'envoi ne s'effectue pas un eexception est levé et on affiche un message d'erreur
        } catch (Exception $e) {
            $message =  "Votre message n'a pu être envoyé.";
        }
          // On retourne le message s'il y en a un.
          return $message;
      }

      private function contentMail(array $post): array
      {
        $subject = $_POST['object'];

        $content = "<html>
                        <body>
                            <header> <h1>Nuveau contact</h1> </header>
                            <main>
                                <p>Infos client :<br>
                                    Nom:". $_POST['name'] ."<br>Prenom:". $_POST['surname'] ."<br>Email:". $_POST['email'] ."<br>Tel:". $_POST['phone'] ."<br>
                                    </p>
                                    <p>Message:<br>" .$_POST['message']. "
                            </main>";

         $content = array ('subject' => $subject, 'content' => $content);
         return $content;                       

      }
    }
