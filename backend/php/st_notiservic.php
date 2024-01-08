<?php

if ($_POST) {

    $recipient_email = $f->correo;
    $subject = "Renovar servicio";

    $from_email = $f->correo;
    $reply_to_email = $f->correo;

    $correo = "smafgym@gmail.com";

    // Armo el cuerpo del mensaje
    $message = "¡Hola " . utf8_encode($f->apecli) . "!\n\n";
    $message .= "Te recordamos que tu plan está por finalizar. 😊\n\n";
    $message .= "¡No dejes que se termine tu experiencia en SMAF GYM! \n";
    $message .= "\n\nMás detalles:\n\n";
    $message .= "Nombre: " . utf8_encode($f->apecli) . "\n";
    $message .= "Apellido: " . utf8_encode($f->nomcli) . "\n";
    $message .= "Email: " . $from_email . "\n";
    $message .= "El equipo de SMAF GYM 💪";

    // Encabezados
    $boundary = uniqid('np');
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From:" . $correo . "\r\n";
    $headers .= "Reply-To: " . $reply_to_email . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=" . $boundary . "\r\n";

    // Texto plano
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($message));

    // Adjuntar archivo
    $attachment = file_get_contents("../servicio/ticket.php?id=" . $g->idservc);
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/octet-stream\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"factura.pdf\"\r\n\r\n";
    $body .= chunk_split(base64_encode($attachment));

    // Enviar el correo electrónico
    $sentMail = @mail($recipient_email, $subject, $body, $headers);

    if ($sentMail) {
        echo '<script type="text/javascript">
            swal("Enviado!", "El mensaje fue enviado con éxito!", "success").then(function() {
                window.location = "../servicio/mostrar.php";
            });
            </script>';
    } else {
        echo '<script type="text/javascript">
            swal("Error!", "Se produjo un error y su mensaje no pudo ser enviado.", "error").then(function() {
                window.location = "../servicio/mostrar.php";
            });
            </script>';
    }
} else {
    echo "
        <div>No se adjuntó ningún archivo</div>
    ";
}
