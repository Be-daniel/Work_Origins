<?php

session_start();


require '../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function envoi_email($from_name, $from_email, $message){
    $mail = new PHPMailer(true); 

    try {
        
        $mail->isSMTP();
        $mail->SMTPDebug = 0; 
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username   = $_ENV['SMTP_USERNAME']; 
        $mail->Password   = $_ENV['SMTP_PASSWORD'];   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = $_ENV['SMTP_PORT'];
        if (empty($to_email) || empty($to_name)) {
            throw new Exception("L'adresse email du destinataire ou le nom est manquant.");
        }
        $mail->setFrom($from_email, $from_name);
        $to_email = $_ENV['SMTP_FROM_EMAIL'];
        $to_name = $_ENV['SMTP_FROM_NAME'];

        $mail->addAddress($to_email, $to_name);        
        $mail->addReplyTo($from_email, $from_name);
        $mail->isHTML(true);
        $mail->Subject = 'Message de ' . $from_name;
        $mail->Body    = nl2br(htmlspecialchars($message)); 
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Erreur d\'envoi d\'email: ' . $mail->ErrorInfo); 
    $_SESSION['status'] = "Une erreur s'est produite lors de l'envoi du message: " . $mail->ErrorInfo; 
        return false;
    }   
}

if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['message'])) {
    
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if ($fullname && $email && $message) {
        if (envoi_email($fullname, $email, $message)) {
            $_SESSION['status'] = "Message envoyé avec succès.";
        } else {
            $_SESSION['status'] = "Une erreur s'est produite lors de l'envoi du message.";
        }
    } else {
        $_SESSION['status'] = "Les données du formulaire sont invalides.";
    }
} else {
    $_SESSION['status'] = "Les données du formulaire sont manquantes.";
}

header("Location: Form_contact.php");
exit();

