<!-- TABLA DE PROFESORES -->
<?php

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] !== "Admin") {
    header("Location: $URL/401");
    exit();
}
require_once "./controllers/userController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listadoProfesores = buscarProfesores();
} else {
    $listadoProfesores = listadoProfesores();
}

//PAGINACION
$cantidadItems = count($listadoProfesores);
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listadoProfesores = buscarProfesoresPagina($pagina, $cantidadItemsPorPagina);
} else {
    $listadoProfesores = listadoProfesoresPagina($pagina, $cantidadItemsPorPagina);
}


?>

<section class="border-bottom title-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="pt-4 pb-3 m-0">
                    PROFESORES
                </h2>
            </div>
            <div class="col d-flex justify-content-end pt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">Listado de Profesores</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container my-4">
    <div class="row">
        <div class="card mb-3">
            <div class="card-body">
                <?php require_once "alerts.php"; ?>
                <section class="my-3">
                    <form action=<?= "$URL/listado_profesores" ?> method="POST" class="d-flex" id="formBuscarProfesor">
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
                                <th scope="col">Profesor</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listadoProfesores as $item) {
                            ?>
                                <tr>
                                    <td><?= $item->getLegajo() ?></td>
                                    <td><?= $item->getNombre() . " " . $item->getApellido() ?></td>
                                    <td><?= $item->getEmail() ?></td>
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
                                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_profesores/" . $pagina - 1 ?>">Anterior</a></li>
                            <?php
                            }
                            ?>
                            <?php
                            for ($i = 1; $i <= $paginas; $i++) {
                                if ($i == $pagina) {
                            ?>
                                    <li class="page-item active"><span class="page-link" href="<?= "$URL/listado_profesores/$i" ?>"><?= $i ?></span></li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item"><a class="page-link" href="<?= "$URL/listado_profesores/$i" ?>"><?= $i ?></a></li>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            if ($pagina != $paginas) {
                            ?>
                                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_profesores/" . $pagina + 1 ?>">Siguiente</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </section>
                </section>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-2">
            <a href=<?= "$URL/registrar_profesor/" ?> class='btn btn-primary'>Agregar profesor</a>
        </div>
    </div>

</div>

</div>

<script>
    const formBuscarProfesor = document.getElementById("formBuscarProfesor");
    const inputBuscar = document.getElementById("inputBuscar");

    formBuscarProfesor.addEventListener("submit", function(e) {
        e.preventDefault();

        let inputFields = [{
            field: inputBuscar,
            message: "El campo de busqueda es requerido"
        }];

        removeError(inputFields);

        let valid = validateRequiredFields(inputFields);

        if (valid) {
            formBuscarProfesor.submit();
        }
    })
</script>