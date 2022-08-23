<?php

require_once "./models/Materia.php";
include_once "./database/connection.php";

function findMateriaById($id)
{
    $materia = null;
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM materia WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $rs = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($rs) > 0) {
            $mat = mysqli_fetch_assoc($rs);
            $materia = new Materia();
            $materia->setId($mat['id']);
            $materia->setNombre($mat['nombre']);
        }

        return $materia;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findAllMaterias()
{
    $listadoMaterias = array();
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM materia";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $materia = new Materia();
                $materia->setId($item['id']);
                $materia->setNombre($item['nombre']);

                array_push($listadoMaterias, $materia);
            }
        }
        return $listadoMaterias;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findAllMateriasPagina($pagina, $cantidadItemsPorPagina)
{
    $listadoMaterias = array();
    try {
        if (!isset($conn)) $conn = databaseConnection();
        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM materia LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $materia = new Materia();
                $materia->setId($item['id']);
                $materia->setNombre($item['nombre']);

                array_push($listadoMaterias, $materia);
            }
        }
        return $listadoMaterias;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function saveMateria($nombre)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "INSERT INTO materia (nombre) VALUES (?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $nombre);
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function updateMateria($id, $nombre)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "UPDATE materia SET nombre = ? WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $nombre, $id);
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function deleteMateriaById($id)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "DELETE FROM materia WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchMateria($busqueda)
{
    $listadoMaterias = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM materia WHERE materia.nombre LIKE '%" . $busqueda . "%' ";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $materia = new Materia();
                $materia->setId($item['id']);
                $materia->setNombre($item['nombre']);

                array_push($listadoMaterias, $materia);
            }
        }
        return $listadoMaterias;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchMateriaPagina($busqueda, $pagina, $cantidadItemsPorPagina)
{
    $listadoMaterias = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM materia WHERE materia.nombre LIKE '%" . $busqueda . "%' LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $materia = new Materia();
                $materia->setId($item['id']);
                $materia->setNombre($item['nombre']);

                array_push($listadoMaterias, $materia);
            }
        }
        return $listadoMaterias;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}
