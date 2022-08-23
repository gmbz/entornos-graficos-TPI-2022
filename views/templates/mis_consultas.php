<?php
require_once "./controllers/consultaController.php";

if (empty($_SESSION["rol"]) or $_SESSION["rol"] == "Admin") {
  header("Location: $URL/listado_consultas/1");
  exit();
}

if ($_SESSION["rol"] == "Profesor") {
  $consultas = listadoConsultasProfesor();
} else {
  $consultas = listadoConsultasAlumno();
}

// PAGINACION
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

if ($_SESSION["rol"] == "Profesor") {
  $consultas = listadoConsultasProfesorPagina($pagina, $cantidadItemsPorPagina);
} else {
  $consultas = listadoConsultasAlumnoPagina($pagina, $cantidadItemsPorPagina);
}

?>

<section class="border-bottom title-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 class="pt-4 pb-3 m-0">
          MIS CONSULTAS
        </h2>
      </div>
      <div class="col d-flex justify-content-end pt-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
            <li class="breadcrumb-item active text-dark" aria-current="page">Mis Consultas</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<div class="container mt-4 mb-4">
  <div class="row">

    <section class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Materia</th>
                <th scope="col">Modalidad</th>
                <th scope="col">Fecha y hora incio</th>
                <th scope="col">Fecha y hora reprogramada</th>
                <th scope="col">Cupo disponible</th>
                <th scope="col">Duracion</th>
                <th scope="col">Link</th>
                <?php
                if ($_SESSION["rol"] == "Profesor") {
                ?>
                  <th scope="col">Bloqueada</th>
                <?php
                } else {
                ?>
                  <th scope="col">Estado</th>
                <?php
                }
                ?>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($consultas as $item) {
              ?>
                <?php
                if ($_SESSION["rol"] == "Profesor") {
                ?>
                  <tr>
                    <td><?= $item->getId() ?></td>
                    <td><?= $item->getMateria()->getNombre(); ?></td>
                    <td><?= $item->getModalidad() ?></td>
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
                    <td class="text-center"><?= $item->getCupoDisponible() ?></td>
                    <td><?= $item->getDuracion(); ?></td>
                    <td><?= $item->getLink() ?></td>
                    <td><?php if ($item->getEstado() == 1) {
                          echo "No";
                        } else {
                          echo "Si";
                        } ?></td>
                    <td>

                      <div class='btn-group'>
                        <?php if ($item->getEstado() == 1) {
                        ?>
                          <a href=<?= "$URL/motivo_bloqueo/" . $item->getId() ?> type='button' class='btn btn-warning' id='bloquear'>Bloquear</a>
                        <?php
                        } else {
                        ?>
                          <a type='button' class='btn btn-warning disabled' disabled>Bloquear</a>
                        <?php
                        }
                        ?>
                        <a href=<?= "$URL/ver_inscriptos/" . $item->getId() ?> type='button' class='btn btn-info' id='ver_inscriptos'>Ver inscriptos</a>
                      </div>

                    </td>
                  </tr>
                <?php
                } else {
                ?>
                  <tr>
                    <td><?= $item->getConsulta()->getId() ?></td>
                    <td><?= $item->getConsulta()->getMateria()->getNombre(); ?></td>
                    <td><?= $item->getConsulta()->getModalidad() ?></td>
                    <?php
                    if ($item->getConsulta()->getEstado() == 1) {
                    ?>
                      <td><?= $item->getConsulta()->getFechaHoraInicio() ?></td>
                    <?php
                    } else {
                    ?>
                      <td class="text-muted"><?= $item->getConsulta()->getFechaHoraInicio() ?> <span class="badge bg-danger">BLOQUEADA</span> </td>
                    <?php
                    }
                    ?>
                    <td><?= $item->getConsulta()->getFechaHoraReprogramada() ?></td>
                    <td class="text-center"><?= $item->getConsulta()->getCupoDisponible() ?></td>
                    <td><?= $item->getConsulta()->getDuracion() ?></td>
                    <td><?= $item->getConsulta()->getLink() ?></td>
                    <td><?php if ($item->getEstado() == 2) {
                          echo "Cancelada";
                        } else {
                          echo "Inscripto";
                        } ?></td>
                    <td>
                      <?php
                      if ($item->getEstado() != 2) {
                      ?>
                        <div class="btn-group ml-0">
                          <a href=<?= "$URL/cancelar_inscripcion/" . $item->getConsulta()->getId() ?> class='btn btn-danger' id='cancelar'>Cancelar</a>
                        </div>
                    </td>
                  <?php
                      }
                  ?>
                  </tr>

              <?php
                }
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
                <li class="page-item"><a class="page-link" href="<?= "$URL/mis_consultas/" . $pagina - 1 ?>">Anterior</a></li>
              <?php
              }
              ?>
              <?php
              for ($i = 1; $i <= $paginas; $i++) {
                if ($i == $pagina) {
              ?>
                  <li class="page-item active"><span class="page-link" href="<?= "$URL/mis_consultas/$i" ?>"><?= $i ?></span></li>
                <?php
                } else {
                ?>
                  <li class="page-item"><a class="page-link" href="<?= "$URL/mis_consultas/$i" ?>"><?= $i ?></a></li>
              <?php
                }
              }
              ?>
              <?php
              if ($pagina != $paginas) {
              ?>
                <li class="page-item"><a class="page-link" href="<?= "$URL/mis_consultas/" . $pagina + 1 ?>">Siguiente</a></li>
              <?php
              }
              ?>
            </ul>
          </nav>

        </div>
      </div>
    </section>

  </div>
</div>