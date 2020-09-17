<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
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
    $mail->addAddress('randrianaina@hotmail.com', 'Andrianaina');     // Add a recipient
    $mail->addAddress('andrianaina.anthony.rabenjamina@gmail.com', 'Rabenjamina');               // Name is optional

    // Content/Contenu
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = '1er Test PHP Mailer';
    $mail->Body    = 'Bonjour <strong>Andrianaina</strong>, ceci est le tout premier test de la fonction PHPMailer qui est disponible via <a href="http://www.github.com">Github</a>';
    $mail->AltBody = "Bonjour Andrianaina, ceci est un test qui s'affiche lorsque des clients de messageries ne supportent pas l'affichage en HTML";

    //envoi
    $mail->CharSet='UTF-8'; //encodage des caractères
    $mail->send();
} 

//s'il y a des erreurs 'catch(Exception...)' permettra d'afficher des erreurs
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>