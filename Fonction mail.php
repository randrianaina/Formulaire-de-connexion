<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';



function sendMail ($recipient,$recipient_name,$link){
    $mail = new PHPMailer(true);

/*fonction PHP d'essai(permet de faire des essai dans affichage d'erreur)*/
try {
    //Server settings/options du serveur SMTP
    $mail->SMTPDebug = 0;                      // Disable verbose debug output with 0
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'andrianaina.anthony.rabenjamina@gmail.com';                     // SMTP username
    $mail->Password   = '!!8l8HcI3^g%SYMi3Rg#*g';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         // SSL for Gmail
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Expéditeur
    $mail->setFrom('no-reply@example.com', 'Mailer');
    
    //Recipients/Destinataires
    $mail->addAddress($recipient, $recipient_name);     // Add a recipient
    $mail->addAddress('randrianaina@hotmail.com', 'Rabenjamina');               // Name is optional
    $mail->addAddress('dwwm.futuroscope.2020@gmail.com');

    // Content/Contenu
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Réinitialisation du mot de passe';
    $mail->Body    = 'Bonjour <strong>'.$recipient_name.'</strong>,voici le lien pour réinitialiser le mot de passe : <a href='.$link.'>lien</a>';
    $mail->AltBody = 'Bonjour <strong>$recipient_name</strong>, votre client de messagerie ne supportent pas un affichage en HTML';

    //envoi
    $mail->CharSet='UTF-8'; //encodage des caractères
    $mail->send();
} 

//s'il y a des erreurs 'catch(Exception...)' permettra d'afficher des erreurs
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>