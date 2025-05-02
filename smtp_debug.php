<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 2; // Verbose debug output
$mail->Debugoutput = 'html';

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'valgasinsasesp@gmail.com';
    $mail->Password = 'mwtt lcmp xqke rmqv';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('valgasinsasesp@gmail.com', 'Test');
    $mail->addAddress('valgasinsasesp@gmail.com');
    $mail->Subject = 'Prueba';
    $mail->Body    = 'Este es un mensaje de prueba.';

    $mail->send();
    echo 'Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar mensaje: {$mail->ErrorInfo}";
}
