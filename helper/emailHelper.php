<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once './vendor/autoload.php';

function sendEmail($to, $body, $altBody, $asunto, $emailRespuesta, $persona)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    //Server settings
    
    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'entornosgraficos20221c@gmail.com';                     //SMTP username
    $mail->Password   = 'gkpoijclrehwjmtp';                             //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    //Recipients
    $mail->setFrom('entornosgraficos20221c@gmail.com', 'UTN FRRo');
    if (empty($to)) {
      $mail->addAddress('entornosgraficos20221c@gmail.com');     //Add a recipient
      $mail->addCC($emailRespuesta);
    } else {
      $mail->addAddress($to);     //Add a recipient
      $mail->addCC('entornosgraficos20221c@gmail.com');
    }
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $asunto;

    $mail->Body = buildMessage($persona, $body);
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = $altBody;

    return $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

function buildMessage($person, $text)
{
  if (empty($person)) {
    $title = "Formulario de contacto";
  } else {
    $title = "Hola, $person";
  }

  $message = "<!DOCTYPE html>
    <html lang='es-AR'>
      <head>
        <meta charset='UTF-8' />
        <meta http-equiv='X-UA-Compatible' content='IE=edge' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <title>Email</title>
        <style>
          body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            text-align: center;
            align-items: center;
            align-content: center;
          }
    
          table.body-wrap {
			      text-align: center;
            width: 100%;
          }
    
          table {
			      text-align: center;
            width: 100%;
            padding: 10px;
          }
          table td {
			      text-align: center;
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
          }
    
          h1,
          h2,
          h3,
          h4,
          h5,
          h6 {
            font-family: sans-serif;
            line-height: 1.1;
            margin-bottom: 15px;
            color: #000;
          }
    
          h1 {
            font-weight: 200;
            font-size: 44px;
          }
          h2 {
            font-weight: 200;
            font-size: 37px;
          }
          h3 {
            font-weight: 500;
            font-size: 27px;
          }
          h4 {
            font-weight: 500;
            font-size: 23px;
          }
          h5 {
            font-weight: 900;
            font-size: 17px;
          }
          h6 {
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            color: #444;
          }
    
          .container {
			      text-align: center;
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important;
          }
        </style>
      </head>
      <body>
        <table class='body-wrap' width='100%'>
          <tr>
            <td></td>
            <td class='container'>
              <div>
                <table width='100%'>
                  <tr>
                    <td>
                      <h3>$title</h3>
                      <p>
                        $text
                      </p>
                      <!-- social & contact -->
                      <table width='100%'>
                        <tr>
                          <td>
                            <table width='100%'>
                              <tr>
                                <td class='container'>
                                  <h5>Información de contacto</h5>
                                  <p>
                                    Direccion:
                                    <strong>Rosario - Zeballos 1341</strong> <br />
                                    Telefono: <strong>0341 - 4481871</strong><br />
                                    Email:
                                    <strong
                                      >entornosgraficos20221c@gmail.com</strong
                                    >
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
            <td></td>
          </tr>
        </table>
      </body>
    </html>
    ";
  return $message;
}
