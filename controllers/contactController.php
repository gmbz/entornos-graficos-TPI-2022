<?php

require_once "./helper/emailHelper.php";

function sendContactForm()
{
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $consulta = $_POST["consulta"];

    $body = "$nombre acaba de enviar un formulario de contacto con el cuerpo: <br>$consulta";


    $response = sendEmail("", $body, "Nuevo envio del formulario de contacto", $asunto, $email, "");

    if ($response) {
        return array('tipo' => 'success', 'mensaje' => 'Te has contactado satisfactoriamente, en breve nos comunicaremos.');;
    }

    return array('tipo' => 'danger', 'mensaje' => 'No pudimos enviar el email.');;
}
