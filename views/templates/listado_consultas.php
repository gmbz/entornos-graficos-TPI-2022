<!-- TABLA DE CONSULTAS -->
<?php
if (!empty($_SESSION["rol"]) and $_SESSION["rol"] == "Profesor") {
  header("Location: $URL/mis_consultas/1");
  exit();
}

require_once "./controllers/consultaController.php";
require_once "./controllers/inscripcion.php";

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Alumno") {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["accion"] == "asistir") {
      $alert = asistir();
      $consultas = listadoConsultasNoInscriptas();
    } else {
      $consultas = buscarConsultasNoInscriptas();
    }
  } else {
    $consultas = listadoConsultasNoInscriptas();
  }
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consultas = buscarConsulta();
  } else {
    $consultas = listadoConsultas();
  }
}

//PAGINACION
$cantidadItems = count($consultas);
if ($cantidadItems < $cantidadItemsPorPagina) {
  $paginas = 1;
} else {
  $paginas = ceil($cantidadItems / $cantidadItemsPorPagina);
}

$pagina = $vista[1];

if ($pagina < 1) {
  $pagina = 1;
} else if ($pagina > $paginas) {
  $pagina = $paginas;
}

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Alumno") {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["accion"] == "asistir") {
      $consultas = listadoConsultasNoInscriptasPagina($pagina, $cantidadItemsPorPagina);
    } else {
      $consultas = buscarConsultasNoInscriptasPagina($pagina, $cantidadItemsPorPagina);
    }
  } else {
    $consultas = listadoConsultasNoInscriptasPagina($pagina, $cantidadItemsPorPagina);
  }
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consultas = buscarConsulta();
  } else {
    $consultas = listadoConsultasPagina($pagina, $cantidadItemsPorPagina);
  }
}

?>

<section class="border-bottom title-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 class="pt-4 pb-3 m-0">
          CONSULTAS
        </h2>
      </div>
      <div class="col d-flex justify-content-end pt-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
            <li class="breadcrumb-item active text-dark" aria-current="page">Listado de Consultas</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<div class="container my-4">
  <div class="row">
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <?php require_once "alerts.php"; ?>
        <section class="my-3">
          <form action=<?= "$URL/listado_consultas" ?> method="POST" class="d-flex" id="formBuscarConsulta">
            <div class="input-group">
              <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar" name="search" id="inputBuscar">
              <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </div>
          </form>
        </section>
        <section class="table-responsive">
          <table class="table table-hover">
            <thead class="text-center">
              <tr>
                <th scope="col"></th>
                <th scope="col">Materia</th>
                <th scope="col">Profesor</th>
                <th scope="col">Modalidad</th>
                <th scope="col">Link</th>
                <th scope="col">Fecha y hora incio</th>
                <th scope="col">Fecha y hora reprogramada</th>
                <th scope="col">Duracion(hs)</th>
                <th scope="col">Cupo disponible</th>
                <th scope="col" style="width: 100px;"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($consultas as $item) {
                $motivoBloqueo = $item->getMotivoBloqueo();
              ?>
                <tr>
                  <td><?= $item->getId() ?></td>
                  <td><?= $item->getMateria()->getNombre(); ?></td>
                  <td><?= $item->getProfesor()->getNombre() . " " . $item->getProfesor()->getApellido() ?></td>
                  <td><?= $item->getModalidad() ?></td>
                  <td><?= $item->getLink() ?></td>
                  <?php
                  if ($item->getEstado() == 1) {
                  ?>
                    <td><?= $item->getFechaHoraInicio() ?></td>
                  <?php
                  } else {
                  ?>
                    <td class="text-muted"><?= $item->getFechaHoraInicio() ?> <span class="badge bg-danger">BLOQUEADA</span> </td>
                  <?php
                  }
                  ?>
                  <td><?= $item->getFechaHoraReprogramada() ?></td>
                  <td><?= $item->getDuracion() ?></td>
                  <td class="text-center"><?= $item->getCupoDisponible() ?></td>
                  <td>
                    <?php
                    if (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Admin") {
                    ?>
                      <div class='text-center fs-5 '>
                        <a href=<?= "$URL/editar_consulta/" . $item->getId() ?> class='text-warning me-2' id='editar' title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href=<?= "$URL/borrar_consulta/" . $item->getId() ?> class='text-danger' id='eliminar' title="Eliminar"><i class="fa-solid fa-trash-can"></i></a>
                      </div>
                      <?php
                    } elseif (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Alumno") {
                      if ($item->getCupoDisponible() === 0) {
                      ?>
                        <a class="btn btn-primary disabled" type="button" disabled>Asistir</a>
                      <?php
                      } else {
                      ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asistirModal" data-bs-url=<?= $URL; ?> data-bs-id=<?= $item->getId() ?> data-bs-profesor=<?= $item->getProfesor()->getNombre() . " " . $item->getProfesor()->getApellido() ?>>Asistir</button>
                      <?php
                      }
                      ?>
                    <?php
                    }
                    ?>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>

          <!-- PAGINACION -->
          <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
              <?php
              if ($pagina != 1) {
              ?>
                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_consultas/" . $pagina - 1 ?>">Anterior</a></li>
              <?php
              }
              ?>
              <?php
              for ($i = 1; $i <= $paginas; $i++) {
                if ($i == $pagina) {
              ?>
                  <li class="page-item active"><span class="page-link" href="<?= "$URL/listado_consultas/$i" ?>"><?= $i ?></span></li>
                <?php
                } else {
                ?>
                  <li class="page-item"><a class="page-link" href="<?= "$URL/listado_consultas/$i" ?>"><?= $i ?></a></li>
              <?php
                }
              }
              ?>
              <?php
              if ($pagina != $paginas) {
              ?>
                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_consultas/" . $pagina + 1 ?>">Siguiente</a></li>
              <?php
              }
              ?>
            </ul>
          </nav>
        </section>
      </div>
    </div>

    <?php
    if (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Admin") {
    ?>
      <div class="row justify-content-center">
        <div class="col-2">
          <a href=<?= "$URL/nueva_consulta/" ?> class='btn btn-primary'>Agregar consulta</a>
        </div>
      </div>
    <?php
    }
    ?>
  </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="asistirModal" tabindex="-1" aria-labelledby="asistirModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asistirModalLabel">Asistir a</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action=<?= "$URL/listado_consultas/1" ?> method="POST">
          <input class="form-control" type="hidden" name="consultaId" id="consultaId">
          <input class="form-control" type="hidden" name="accion" id="accion" value="asistir">
          <div class="mb-3">
            <label for="asunto" class="col-form-label">Motivo asistencia (opcional)</label>
            <textarea class="form-control" id="asunto" name="asunto" maxlength="250" placeholder="Ingresar motivo por el cual querés ir a consulta (por ej.: Tengo dudas sobre el TP)"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Asistir</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  const formBuscarConsulta = document.getElementById("formBuscarConsulta");
  const inputBuscar = document.getElementById("inputBuscar");

  formBuscarConsulta.addEventListener("submit", function(e) {
    e.preventDefault();

    let inputFields = [{
      field: inputBuscar,
      message: "El campo de busqueda es requerido"
    }];

    removeError(inputFields);

    let valid = validateRequiredFields(inputFields);

    if (valid) {
      formBuscarConsulta.submit();
    }
  })

  const asistirModal = document.getElementById('asistirModal')
  asistirModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    let button = event.relatedTarget

    let profesor = button.getAttribute('data-bs-profesor')
    let id = button.getAttribute('data-bs-id')
    let url = button.getAttribute('data-bs-url')

    let modalTitle = asistirModal.querySelector('.modal-title')
    let modalInputId = asistirModal.querySelector('.modal-body #consultaId')

    modalTitle.textContent = "Asistir a consulta de " + profesor
    modalInputId.value = id;
  })
</script>