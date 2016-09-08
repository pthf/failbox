<?php
if(isset($_POST['email'])) {

$email_to = "failbox@failbox.com";
$email_subject = "Contacto Failbox";

if(!isset($_POST['nombre']) ||
!isset($_POST['email']) ||
!isset($_POST['subject']) ||
!isset($_POST['phone']) ||
!isset($_POST['message'])) {

echo "<b>Ocurrió un error y el formulario no ha sido enviado. </b><br />";
echo "Por favor, vuelva atrás y verifique la información ingresada<br />";
die();
}

$email_message = "Detalles del formulario de contacto:\n\n";
$email_message .= "Nombre: " . $_POST['nombre'] . "\n";
$email_message .= "Email: " . $_POST['email'] . "\n";
$email_message .= "Asunto: " . $_POST['subject'] . "\n";
$email_message .= "Teléfono: " . $_POST['phone'] . "\n";
$email_message .= "Comentarios: " . $_POST['message'] . "\n\n";


$headers = 'From: '.$_POST['email']."\r\n".
'Reply-To: '.$_POST['email']."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail('hola@failbox.mx', $_POST['subject'], $email_message, $headers);

echo "¡El formulario se ha enviado con éxito!";
}
?>
