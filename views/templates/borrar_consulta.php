<?php
require_once "./controllers/consultaController.php";

$id = $vista[1];

if (!empty($_SESSION["rol"]) and $_SESSION["rol"] == "Admin") {
  $alert = eliminarConsultaPorId($id);
}

header("Location: $URL/listado_consultas");
exit();