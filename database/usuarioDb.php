<?php
require_once "./models/Usuario.php";
include_once "./database/connection.php";

function findUsuarioByLegajo($legajo)
{
    $usuario = null;
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM usuario INNER JOIN usuario_rol AS ur ON ur.usuario_legajo = usuario.legajo INNER JOIN rol ON rol.id = ur.rol_id WHERE legajo = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $legajo);
        mysqli_stmt_execute($stmt);

        $rs = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($rs) > 0) {
            $user = mysqli_fetch_assoc($rs);
            $usuario = new Usuario();
            $usuario->setLegajo($user['legajo']);
            $usuario->setNombre($user['nombre']);
            $usuario->setApellido($user['apellido']);
            $usuario->setEmail($user['email']);
            $usuario->setPassword($user['password']);
            $usuario->setRol($user['descripcion']);
        }

        return $usuario;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findAllProfesores()
{
    $listadoProfesores = array();
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM usuario AS u INNER JOIN usuario_rol AS ur ON u.legajo=ur.usuario_legajo INNER JOIN rol ON ur.rol_id=rol.id WHERE rol.descripcion = 'Profesor';";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $profesor = new Usuario();
                $profesor->setLegajo($item['legajo']);
                $profesor->setNombre($item['nombre']);
                $profesor->setApellido($item['apellido']);
                $profesor->setEmail($item['email']);

                array_push($listadoProfesores, $profesor);
            }
        }
        return $listadoProfesores;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}


function findAllProfesoresPagina($pagina, $cantidadItemsPorPagina)
{
    $listadoProfesores = array();
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM usuario AS u INNER JOIN usuario_rol AS ur ON u.legajo=ur.usuario_legajo INNER JOIN rol ON ur.rol_id=rol.id WHERE rol.descripcion = 'Profesor' LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $profesor = new Usuario();
                $profesor->setLegajo($item['legajo']);
                $profesor->setNombre($item['nombre']);
                $profesor->setApellido($item['apellido']);
                $profesor->setEmail($item['email']);

                array_push($listadoProfesores, $profesor);
            }
        }
        return $listadoProfesores;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchProfesor($busqueda)
{
    $listadoProfesores = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM usuario INNER JOIN usuario_rol AS ur ON ur.usuario_legajo = usuario.legajo WHERE usuario.nombre LIKE '%" . $busqueda . "%' OR usuario.apellido LIKE '%" . $busqueda . "%' AND ur.rol_id = 3";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $profesor = new Usuario();
                $profesor->setLegajo($item['legajo']);
                $profesor->setNombre($item['nombre']);
                $profesor->setApellido($item['apellido']);
                $profesor->setEmail($item['email']);

                array_push($listadoProfesores, $profesor);
            }
        }
        return $listadoProfesores;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchProfesorPagina($busqueda, $pagina, $cantidadItemsPorPagina)
{
    $listadoProfesores = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM usuario INNER JOIN usuario_rol AS ur ON ur.usuario_legajo = usuario.legajo WHERE usuario.nombre LIKE '%" . $busqueda . "%' OR usuario.apellido LIKE '%" . $busqueda . "%' AND ur.rol_id = 3 LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $profesor = new Usuario();
                $profesor->setLegajo($item['legajo']);
                $profesor->setNombre($item['nombre']);
                $profesor->setApellido($item['apellido']);
                $profesor->setEmail($item['email']);

                array_push($listadoProfesores, $profesor);
            }
        }
        return $listadoProfesores;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}