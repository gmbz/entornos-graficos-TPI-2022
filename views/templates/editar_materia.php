<!-- FORMULARIO DE EDIT DE MATERIA -->
<?php
require_once "./controllers/materiaController.php";

if (empty($_SESSION["rol"]) or $_SESSION["rol"] !== "Admin") {
    header("Location: $URL/401");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alert = editarMateria();
}
$materia = obtenerMateriaPorId($vista[1]);
?>

<section class="border-bottom title-section">
    <div class="container">
        <div class="row row-cols-md-2 row-cols-1">
            <div class="col">
                <h2 class="pt-4 pb-3 m-0">
                    EDITAR MATERIA
                </h2>
            </div>
            <div class="col d-flex justify-content-end pt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
                        <li class="breadcrumb-item "><a href=<?= "$URL/listado_materias"; ?>>Listado de Materias</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">Editar Materia</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container p-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php require_once "alerts.php"; ?>
                    <form action=<?= "$URL/editar_materia/" . $materia->getId() ?> method="POST" class="col-12" id="formEditarMateria">
                        <input type="hidden" name="id" value="<?= $materia->getId() ?>">
                        <div class="form-group mb-3">
                            <label for="inputNombre" class="form-label">Nombre de la materia</label>
                            <input type="text" class="form-control" id="inputNombre" name="nombre" aria-describedby="nombreHelp" value="<?= $materia->getNombre() ?>">
                            <small class="text-danger"></small>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary" id="inputGuardarCambios">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const formEditarMateria = document.getElementById("formEditarMateria");
    const inputNombre = document.getElementById("inputNombre");

    formEditarMateria.addEventListener("submit", function(e) {
        e.preventDefault();

        let inputFields = [{
            field: inputNombre,
            message: "El nombre de la materia es requerido"
        }];

        removeError(inputFields);

        let valid = validateRequiredFields(inputFields);

        if (valid) {
            formEditarMateria.submit();
        }
    })
</script>