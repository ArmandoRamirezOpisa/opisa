<?php
    if($_POST){
        $nombre  = $_POST['nombre'];
        $correo  = $_POST['correo'];
        $mensaje = $_POST['mensaje'];

        $email_to      = "info@opisa.com";
        $email_subject = "Contacto desde el sitio web opisa.com";

        $email_message  = "Detalles del formulario de contacto:\n\n";
        $email_message .= "Nombre: "    . $nombre   . "\n";
        $email_message .= "Correo: "    . $correo   . "\n";
        $email_message .= "Teléfono: "  . $telefono . "\n";
        $email_message .= "Empresa: "   . $empresa  . "\n";
        $email_message .= "Mensaje: "   . $mensaje  . "\n\n";

        $headers = 'From: '.$correo."\r\n".
        'Reply-To: '.$correo."\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Se envia el correo

        @mail($email_to, $email_subject, $email_message, $headers);

    }
?>

