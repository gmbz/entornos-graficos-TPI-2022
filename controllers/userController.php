<?php
require_once "./models/Usuario.php";
require_once "./database/usuarioDb.php";
require_once('./vendor/autoload.php');


function obtenerDatosUsuario()
{
    $legajo = $_SESSION['legajo'];

    return findUsuarioByLegajo($legajo);
}

function listadoProfesores()
{
    return findAllProfesores();
}

function listadoProfesoresPagina($pagina, $cantidadItemsPorPagina)
{
    return findAllProfesoresPagina($pagina, $cantidadItemsPorPagina);
}


function buscarProfesores()
{
    $busqueda = $_POST['search'];
    return searchProfesor($busqueda);
}

function buscarProfesoresPagina($pagina, $cantidadItemsPorPagina)
{
    $busqueda = $_POST['search'];
    return searchProfesorPagina($busqueda, $pagina, $cantidadItemsPorPagina);
}