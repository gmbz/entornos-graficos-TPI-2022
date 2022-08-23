<?php
session_start();
?>
<header class="">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <!-- LOGO -->
            <a class="navbar-brand" href=<?= "$URL/"; ?>>
                <!-- UTN -->
                <!-- <img src="./views/static/img/logo-utn-navbar.png" class="text-light" alt="Logo UTN" style="max-width: 80px;"> -->
                <img src=<?= "$URL/views/static/img/logo-utn-navbar.png" ?> class="text-light" alt="Logo UTN" title="Inicio" style="max-width: 80px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- ITEMS A LA IZQUIERDA DE LA BARRA DE NAVEGACION -->

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= "$URL/listado_consultas/1"; ?>">Consultas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= "$URL/mis_consultas/1"; ?>">Mis consultas</a>
                    </li>

                    <?php
                    if (isset($_SESSION["rol"]) and $_SESSION["rol"] == "Admin") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= "$URL/listado_profesores/1"; ?>">Profesores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= "$URL/listado_materias/1"; ?>">Materias</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>

                <!-- ITEMS A LA DERECHA DE LA BARRA DE NAVEGACION -->

                <ul class="navbar-nav ml-auto">
                    <?php
                    if (!isset($_SESSION["rol"])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href=<?= "$URL/login"; ?>>Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=<?= "$URL/register"; ?>>Registrarse</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION["nombre"] ?> <?= $_SESSION["apellido"] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href=<?= "$URL/profile" ?>>Ver perfil</a></li>
                                <li><a class="dropdown-item" href=<?= "$URL/logout/" ?>>Cerrar sesión</a></li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                </ul>


            </div>
        </div>
    </nav>
    <!-- FIN NAVBAR -->

</header>