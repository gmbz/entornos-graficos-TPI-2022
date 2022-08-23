<?php
require_once "./controllers/consultaController.php";

if (empty($_SESSION["rol"]) or $_SESSION["rol"] != "Profesor") {
  header("Location: listado_consultas");
  exit();
}

$id = $vista[1];
$consulta = obtenerConsultaPorId($id);
$inscriptos = inscriptosConsulta($id);
$consulta->setCupoDisponible($inscriptos);
?>
<section class="border-bottom title-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 class="pt-4 pb-3 m-0">
          CONSULTA
        </h2>
      </div>
      <div class="col d-flex justify-content-end pt-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
            <li class="breadcrumb-item"><a href=<?= "$URL/listado_consultas"; ?>>Listado de Consultas</a></li>
            <li class="breadcrumb-item active text-dark" aria-current="page">Ver Inscriptos</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<div class="container mt-2 mb-4">
  <div class="row">
    <section class="card shadow-sm">
      <div class="card-body">
        <div class="row row-cols-md-2 row-cols-sm-1">
          <div class="col">
            <p>Profesor: <span><?= $consulta->getProfesor()->getNombre() . ' ' . $consulta->getProfesor()->getApellido() ?></span></p>
            <p>Fecha y hora inicio: <span><?= $consulta->getFechaHoraInicio() ?></span></p>
            <p>Cupo: <span><?= $consulta->getCupo() ?></span></p>
            <p>Modalidad: <span><?= $consulta->getModalidad() ?></span></p>

          </div>
          <div class="col">
            <p>Materia: <span><?= $consulta->getMateria()->getNombre() ?></span></p>
            <p>Duracion: <span><?= $consulta->getDuracion() ?></span></p>
            <p>Cupo Disponible: <span><?= $consulta->getCupoDisponible() ?></span></p>
            <?php
            if (strcmp($consulta->getModalidad(), "Virtual") === 0) {
            ?>
              <p>Link: <a href="<?= $consulta->getLink() ?>"><span><?= $consulta->getLink() ?></span></a></p>
            <?php
            }
            ?>
          </div>
        </div>
    </section>

    <section class="card mt-3 shadow-sm">
      <div class="card-body">
        <h3 class="text-center">Inscripciones</h3>
        <table class="table table-hover">
          <thead class="text-center">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Email</th>
              <th scope="col">Fecha y hora inscripcion</th>
              <th scope="col">Asunto</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr>
              <?php
              if (count($inscriptos) == 0) {
              ?>
                <td colspan="5">
                  <p>No hay inscriptos para esta consulta</p>
                </td>
              <?php
              }
              ?>
            </tr>
            <?php
            foreach ($inscriptos as $item) {
            ?>
              <tr>
                <td><?= $item->getUsuario()->getNombre() ?></td>
                <td><?= $item->getUsuario()->getApellido() ?></td>
                <td><?= $item->getUsuario()->getEmail() ?></td>
                <td><?= $item->getFechaInscripcion() ?></td>
                <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#asuntoModal" data-bs-asunto="<?= $item->getAsunto() ?>"><i class="fa-solid fa-circle-info"></i></button></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

    </section>
  </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="asuntoModal" tabindex="-1" aria-labelledby="asuntoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asuntoModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>

<script>
  const asuntoModal = document.getElementById('asuntoModal')
  asuntoModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    let button = event.relatedTarget
    // Extract info from data-bs-* attributes
    let asunto = button.getAttribute('data-bs-asunto')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    let modalTitle = asuntoModal.querySelector('.modal-title')
    // let modalBodyInput = asuntoModal.querySelector('.modal-body input')
    let modalP = asuntoModal.querySelector('.modal-body p')
    // let modalInputAccion = asuntoModal.querySelector('.modal-body #accion')

    modalTitle.textContent = "Asunto de inscripción";
    modalP.textContent = asunto;
  })
</script>