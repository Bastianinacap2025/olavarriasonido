<?php
$secretKey = "6LfS2BcrAAAAACV9d_YhOozjCVkd136VWXHm3rD2";
$recaptchaResponse = $_POST['g-recaptcha-response'];
$remoteIp = $_SERVER['REMOTE_ADDR'];

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse&remoteip=$remoteIp");
$responseData = json_decode($verify);

if (!$responseData->success) {
    die("Verificación de reCAPTCHA fallida. Intenta nuevamente.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    $destinatario = "bastiancampos2109@gmail.com"; // Cambia a tu correo real
    $asunto = "Nuevo mensaje desde el formulario de contacto";

    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $email\n";
    $contenido .= "Teléfono: $telefono\n";
    $contenido .= "Mensaje:\n$mensaje";

    $headers = "From: $email";

    if (mail($destinatario, $asunto, $contenido, $headers)) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje.";
    }
}
?>
