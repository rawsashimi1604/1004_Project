<?php

/*
 * Email Function Header File
 * Utilizing PHPMailer external module to perform email operations
 * using external SMTP Server aka. Google and a dummy account.
 * 
 * GenerateGameKey to provide customers with their game key after payment confirmation
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../email/vendor/phpmailer/phpmailer/src/Exception.php';
require '../email/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../email/vendor/phpmailer/phpmailer/src/SMTP.php';


function generateGameKey($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $gameKey = '';
    for ($i = 0; $i < $length; $i++) {
        $gameKey .= $characters[rand(0, $charactersLength - 1)];
    }
    return $gameKey;
}

function SendEmail($recipient_email, $recipient_name, $message, $subject){
    $mail = new PHPMailer;
    $mail->SMTPDebug = false;                                           // Enable verbose debug output
    $mail->isSMTP();                                                    // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                                     // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                             // Enable SMTP authentication
    $mail->Username = 'dummy1ict1004@gmail.com';                         // SMTP username
    $mail->Password = 'dummy1ICT1004';                                  // SMTP password
    $mail->SMTPSecure = 'TRUE';                                         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                                  // TCP port to connect to

    $mail->addAddress($recipient_email, $recipient_name);               // Add a recipient
    //$mail->addReplyTo('2102090@sit.singaporetech.edu.sg', 'Name');
    $mail->setFrom("dummy1ict1004@gmail.com", 'GamesDex');

    $mail->isHTML(true);                                                // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        $errormessage = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    } else {
            $errormessage = 'Message has been sent';
    }
}


?>