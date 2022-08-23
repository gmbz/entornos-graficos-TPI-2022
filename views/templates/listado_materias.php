<!-- TABLA DE MATERIAS -->
<?php
if (empty($_SESSION["rol"]) or $_SESSION["rol"] !== "Admin") {
    header("Location: $URL/401");
    exit();
}
require_once "./controllers/materiaController.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listadoMaterias = buscarMateria();
} else {
    $listadoMaterias = listadoMaterias();
}

//PAGINACION
$cantidadItems = count($listadoMaterias);
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
    $listadoMaterias = buscarMateriaPagina($pagina, $cantidadItemsPorPagina);
} else {
    $listadoMaterias = listadoMateriasPagina($pagina, $cantidadItemsPorPagina);
}

?>

<section class="border-bottom title-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="pt-4 pb-3 m-0">
                    MATERIAS
                </h2>
            </div>
            <div class="col d-flex justify-content-end pt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">Listado de Materias</li>
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
                    <form action=<?= "$URL/listado_materias" ?> method="POST" class="d-flex" id="formBuscarMateria">
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
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listadoMaterias as $item) {
                            ?>
                                <tr>
                                    <td><?= $item->getId() ?></td>
                                    <td><?= $item->getNombre() ?></td>
                                    <td>
                                        <div class='text-center fs-5 '>
                                            <a href=<?= "$URL/editar_materia/" . $item->getId() ?> class='text-warning me-2' title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href=<?= "$URL/borrar_materia/" . $item->getId() ?> class='text-danger' title="Eliminar"><i class="fa-solid fa-trash-can"></i></a>
                                        </div>
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
                                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_materias/" . $pagina - 1 ?>">Anterior</a></li>
                            <?php
                            }
                            ?>
                            <?php
                            for ($i = 1; $i <= $paginas; $i++) {
                                if ($i == $pagina) {
                            ?>
                                    <li class="page-item active"><span class="page-link" href="<?= "$URL/listado_materias/$i" ?>"><?= $i ?></span></li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item"><a class="page-link" href="<?= "$URL/listado_materias/$i" ?>"><?= $i ?></a></li>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            if ($pagina != $paginas) {
                            ?>
                                <li class="page-item"><a class="page-link" href="<?= "$URL/listado_materias/" . $pagina + 1 ?>">Siguiente</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </section>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-2">
            <a href=<?= "$URL/nueva_materia/" ?> class='btn btn-primary'>Agregar materia</a>
        </div>
    </div>

</div>

</div>

<script>
    const formBuscarMateria = document.getElementById("formBuscarMateria");
    const inputBuscar = document.getElementById("inputBuscar");

    formBuscarMateria.addEventListener("submit", function(e) {
        e.preventDefault();

        let inputFields = [{
            field: inputBuscar,
            message: "El campo de busqueda es requerido"
        }];

        removeError(inputFields);

        let valid = validateRequiredFields(inputFields);

        if (valid) {
            formBuscarMateria.submit();
        }
    })
</script>