<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación básica de campos
    $required_fields = ['nombre', 'email', 'mensaje', 'tipoCliente', 'tipoSolicitud'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("<script>alert('El campo " . ucfirst($field) . " es requerido.'); window.history.back();</script>");
        }
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP para Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'valgasinsasesp@gmail.com'; // El correo que enviará los mensajes
        $mail->Password   = 'mwtt lcmp xqke rmqv'; // Contraseña de 16 caracteres generada en Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8'; // Para soportar acentos y caracteres especiales

        // Remitente y destinatario
        $mail->setFrom('valgasinsasesp@gmail.com', 'Valgasin SAS ESP'); // Correo oficial
        $mail->addAddress('valgasinsasesp@gmail.com'); // Correo receptor (puede ser el mismo o diferente)
        $mail->addReplyTo($_POST['email'], $_POST['nombre']); // Para responder al cliente

        // Contenido del correo (formato profesional)
        $mail->isHTML(true);
        $mail->Subject = 'Nueva solicitud: ' . ucfirst($_POST['tipoSolicitud']) . ' - ' . $_POST['nombre'];

        $mail->Body = '
        <div style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #003366; border-bottom: 2px solid #007bff; padding-bottom: 10px;">Nuevo mensaje desde el formulario</h2>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9; width: 30%;"><strong>Tipo de cliente:</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($_POST['tipoCliente']) . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Nombre/Razón social:</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($_POST['nombre']) . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Tipo de solicitud:</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($_POST['tipoSolicitud']) . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Mensaje:</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">' . nl2br(htmlspecialchars($_POST['mensaje'])) . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Contacto:</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        Email: ' . htmlspecialchars($_POST['email']) . '<br>
                        Teléfono: ' . htmlspecialchars($_POST['celular']) . '
                    </td>
                </tr>
            </table>
            
            <p style="font-size: 12px; color: #777; text-align: center;">
                Mensaje enviado automáticamente desde el formulario de contacto de Valgasin SAS ESP.
            </p>
        </div>
        ';

        // Versión alternativa en texto plano para clientes de correo no HTML
        $mail->AltBody = "Nueva solicitud:\n\n" .
            "Tipo de cliente: " . $_POST['tipoCliente'] . "\n" .
            "Nombre: " . $_POST['nombre'] . "\n" .
            "Tipo de solicitud: " . $_POST['tipoSolicitud'] . "\n" .
            "Mensaje: " . $_POST['mensaje'] . "\n\n" .
            "Contacto:\nEmail: " . $_POST['email'] . "\nTeléfono: " . $_POST['celular'];

        $mail->send();
        header('Location: gracias.html'); // Redirige a página de confirmación
    } catch (Exception $e) {
        // Muestra error y permite volver al formulario
        echo "<script>
            alert('Error al enviar el mensaje. Por favor, inténtelo nuevamente.\\nError: " . str_replace("'", "\\'", $mail->ErrorInfo) . "');
            window.history.back();
        </script>";
    }
} else {
    // Si alguien intenta acceder directamente al archivo
    header('Location: index.html');
}
?>