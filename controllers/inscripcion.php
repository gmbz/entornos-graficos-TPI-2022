<?php
require_once "./models/Consulta.php";
require_once "./models/Usuario.php";
require_once "./models/Materia.php";
require_once "./database/inscripcionDb.php";
require_once "./database/consultaDb.php";
require_once "./helper/emailHelper.php";

function asistir()
{
  $legajo = $_SESSION['legajo'];
  $consultaId = $_POST['consultaId'];
  $asunto = $_POST['asunto'];

  $consulta = findConsultaById($consultaId);

  if ($consulta->getCupoDisponible() > 0) {
    crearInscripcionConsulta($consultaId, $legajo, $asunto);
    $profesor = findUsuarioByLegajo($consulta->getProfesor()->getLegajo());
    // lo mejor seria hacer una nueva clase llamada email pero bue
    $emailTo = $profesor->getEmail();
    $emailBody = "El alumno " . $legajo . " asistirá a la consulta con fecha " .  $consulta->getFechaHoraInicio();
    $emailBody .= " con el asunto: <br>$asunto";
    $emailAltBody = "Un alumno se inscribió a una consulta";
    $emailAsunto = "Inscripcion a consulta";
    $emailEmailRespuesta = "entornosgraficos20221c@gmail.com";
    $emailPersona = $profesor->getNombre() . " " . $profesor->getApellido();
    sendEmail($emailTo, $emailBody, $emailAltBody, $emailAsunto, $emailEmailRespuesta, $emailPersona);
  }
  return array('tipo' => 'success', 'mensaje' => 'Inscripcion registrada con éxito.');
}

function cancelarInscripcion($consultaId)
{
  if (is_numeric($consultaId)) {
    $legajo = $_SESSION['legajo'];
    cancelar($consultaId, $legajo);
  }
}
