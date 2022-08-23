<?php

require_once "./models/Materia.php";
require_once "./database/materiaDb.php";


function nuevaMateria()
{
    $nombre = $_POST['nombre'];

    saveMateria($nombre);

    return array('tipo' => 'success', 'mensaje' => 'Materia agregada con éxito.');
}

function listadoMaterias()
{
    return findAllMaterias();
}

function listadoMateriasPagina($pagina, $cantidadItemsPorPagina)
{
    return findAllMateriasPagina($pagina, $cantidadItemsPorPagina);
}

function editarMateria()
{
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    updateMateria($id, $nombre);

    return array('tipo' => 'success', 'mensaje' => 'Materia editada con éxito.');
}

function obtenerMateriaPorId($id)
{
    if (is_numeric($id)) {
        return findMateriaById($id);
    }
}

function buscarMateria()
{
    $busqueda = $_POST['search'];
    return searchMateria($busqueda);
}

function buscarMateriaPagina($pagina, $cantidadItemsPorPagina)
{
    $busqueda = $_POST['search'];
    return searchMateriaPagina($busqueda, $pagina, $cantidadItemsPorPagina);
}

function eliminarMateriaPorId($id)
{
    if (is_numeric($id)) {
        $response = deleteMateriaById($id);
        if ($response === 1) {
            return array('tipo' => 'success', 'mensaje' => 'Materia eliminada.');
        }
        return array('tipo' => 'danger', 'mensaje' => 'No se pudo eliminar la materia.');
    }
}
