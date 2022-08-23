<!-- FORMULARIO DE CONTACTO -->
<?php

require_once "./controllers/contactController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alert = sendContactForm();
}
?>

<section class="border-bottom title-section">
    <div class="container">
        <div class="row row-cols-md-2 row-cols-1">
            <div class="col">
                <h2 class="pt-4 pb-3 m-0">
                    CONTACTANOS
                </h2>
            </div>
            <div class="col d-flex justify-content-end pt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href=<?= "$URL/"; ?>>Inicio</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">Contacto</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container p-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php require_once "alerts.php"; ?>
                    <form action=<?= "$URL/contact"; ?> method="POST" class="col-12" id="formContacto">
                        <div class="form-group mb-3">
                            <label for="inputNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="inputNombre" aria-describedby="">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="inputEmail" aria-describedby="">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputAsunto" class="form-label">Asunto</label>
                            <input type="text" class="form-control" name="asunto" id="inputAsunto" aria-describedby="">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputConsulta" class="form-label">Consulta</label>
                            <textarea class="form-control" name="consulta" id="inputConsulta" rows="3"></textarea>
                            <small class="text-danger"></small>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const formContacto = document.getElementById("formContacto");
    const inputNombre = document.getElementById("inputNombre");
    const inputEmail = document.getElementById("inputEmail");
    const inputAsunto = document.getElementById("inputAsunto");
    const inputConsulta = document.getElementById("inputConsulta");

    formContacto.addEventListener("submit", function(e) {
        e.preventDefault();

        let inputFields = [{
            field: inputNombre,
            message: "El nombre es requerido"
        }, {
            field: inputEmail,
            message: "El email es requerido"
        }, {
            field: inputAsunto,
            message: "El asunto es requerido"
        }, {
            field: inputConsulta,
            message: "El consulta es requerida"
        }];

        removeError(inputFields);

        let valid = validateRequiredFields(inputFields);

        if (valid) {
            formContacto.submit();
        }
    })
</script>