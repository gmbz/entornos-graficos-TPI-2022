<?php
include_once "./database/connection.php";
require_once "./models/Consulta.php";
require_once "./models/Inscripcion.php";
require_once "./database/materiaDb.php";
require_once "./database/usuarioDb.php";


function findAllConsultas()
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM consulta WHERE fecha_hora_inicio > CURRENT_TIMESTAMP";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findAllConsultasPagina($pagina, $cantidadItemsPorPagina)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM consulta WHERE fecha_hora_inicio > CURRENT_TIMESTAMP LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function ConsultasNoInscriptas($legajo)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM consulta WHERE fecha_hora_inicio > CURRENT_TIMESTAMP AND id NOT IN(SELECT id FROM consulta c INNER JOIN inscripcion i ON id = consulta_id WHERE i.alumno_id = $legajo AND i.estado_id = 1)";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);
                $consulta->setMotivoBloqueo($item['motivo_bloqueo']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultasNoInscriptasPagina($legajo, $pagina, $cantidadItemsPorPagina)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM consulta WHERE fecha_hora_inicio > CURRENT_TIMESTAMP AND id NOT IN(SELECT id FROM consulta c INNER JOIN inscripcion i ON id = consulta_id WHERE i.alumno_id = $legajo AND i.estado_id = 1) LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);
                $consulta->setMotivoBloqueo($item['motivo_bloqueo']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultasProfesor($profesor_legajo)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM consulta WHERE profesor_legajo = $profesor_legajo";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setMateria(findMateriaById($item['materia_id']));
                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultasProfesorPagina($profesor_legajo, $pagina, $cantidadItemsPorPagina)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM consulta WHERE profesor_legajo = $profesor_legajo LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setMateria(findMateriaById($item['materia_id']));
                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultasAlumno($legajo_alumno)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM inscripcion i INNER JOIN consulta c ON i.consulta_id = c.id WHERE alumno_id = $legajo_alumno";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $inscripcion = new Inscripcion();
                $consulta = new Consulta();

                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $inscripcion->setEstado($item['estado_id']);
                $inscripcion->setConsulta($consulta);

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $inscripcion);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultasAlumnoPagina($legajo_alumno, $pagina, $cantidadItemsPorPagina)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT * FROM inscripcion i INNER JOIN consulta c ON i.consulta_id = c.id WHERE alumno_id = $legajo_alumno LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $inscripcion = new Inscripcion();
                $consulta = new Consulta();

                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);
                $consulta->setMateria(findMateriaById($item['materia_id']));

                $inscripcion->setEstado($item['estado_id']);
                $inscripcion->setConsulta($consulta);

                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $inscripcion);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function saveConsulta($fechaHoraInicio, $duracion, $modalidad, $link, $materia_id, $profesor_legajo, $cupo)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "INSERT INTO consulta (fecha_hora_inicio, duracion, modalidad, link, cupo, profesor_legajo, materia_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssiii", $fechaHoraInicio, $duracion, $modalidad, $link, $cupo, $profesor_legajo, $materia_id);
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function updateConsulta($id, $fechaHoraInicio, $duracion, $modalidad, $link, $materia_id, $profesor_legajo, $cupo)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "UPDATE consulta SET fecha_hora_inicio = ?, duracion = ?, modalidad = ?, link = ?, cupo = ?, profesor_legajo = ?, materia_id = ? WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssiiii", $fechaHoraInicio, $duracion, $modalidad, $link, $cupo, $profesor_legajo, $materia_id, $id);
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function findConsultaById($id)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM consulta WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        $rs = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($rs) > 0) {
            $c = mysqli_fetch_assoc($rs);
            $consulta = new Consulta();
            $consulta->setId($c['id']);
            $consulta->setFechaHoraInicio($c['fecha_hora_inicio']);
            $consulta->setFechaHoraReprogramada($c['fecha_hora_reprogramada']);
            $consulta->setDuracion($c['duracion']);
            $consulta->setModalidad($c['modalidad']);
            $consulta->setLink($c['link']);
            $consulta->setCupo($c['cupo']);
            $consulta->setEstado($c['estado']);

            $consulta->setProfesor(findUsuarioByLegajo($c['profesor_legajo']));
            $consulta->setMateria(findMateriaById($c['materia_id']));
            $consulta->setCupoDisponible(verInscriptos($c['id']));
        }

        return $consulta;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function deleteConsultaById($id)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "DELETE FROM consulta WHERE id = ?";

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

function bloquearConsultaId($motivo, $fechaHoraInicio, $id)
{
    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "UPDATE consulta SET estado = 0, motivo_bloqueo = ?,  fecha_hora_reprogramada = ? WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $motivo, $fechaHoraInicio, $id);
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function verInscriptos($id)
{
    $listadoInscriptos = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT legajo, nombre, apellido, email, fecha_inscripcion, asunto FROM consulta c INNER JOIN inscripcion i ON c.id = i.consulta_id INNER JOIN usuario u ON i.alumno_id = u.legajo WHERE c.id = $id AND estado_id != 2";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $inscripto = new Inscripcion();
                $usuario = new Usuario();

                $usuario->setLegajo($item['legajo']);
                $usuario->setNombre($item['nombre']);
                $usuario->setApellido($item['apellido']);
                $usuario->setEmail($item['email']);
                $inscripto->setUsuario($usuario);
                $inscripto->setFechaInscripcion($item['fecha_inscripcion']);
                $inscripto->setAsunto($item['asunto']);

                array_push($listadoInscriptos, $inscripto);
            }
        }
        return $listadoInscriptos;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchConsulta($busqueda)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT * FROM consulta INNER JOIN materia ON consulta.materia_id=materia.id INNER JOIN usuario ON consulta.profesor_legajo=usuario.legajo WHERE materia.nombre LIKE '%" . $busqueda . "%' OR usuario.nombre LIKE '%" . $busqueda . "%' OR usuario.apellido LIKE '%" . $busqueda . "%'";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));
                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchConsultaNoInscriptas($busqueda, $legajo)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $query = "SELECT c.id, c.fecha_hora_inicio, c.duracion, c.modalidad, c.link, c.cupo, c.estado, c.profesor_legajo, c.materia_id FROM consulta AS c INNER JOIN materia AS m ON c.materia_id=m.id INNER JOIN usuario AS u ON c.profesor_legajo=u.legajo WHERE fecha_hora_inicio > CURRENT_TIMESTAMP AND (m.nombre LIKE '%" . $busqueda . "%' OR u.nombre LIKE '%" . $busqueda . "%' OR u.apellido LIKE '%" . $busqueda . "%') AND c.id NOT IN(SELECT id FROM consulta c INNER JOIN inscripcion i ON id = consulta_id WHERE i.alumno_id = $legajo)";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));
                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}

function searchConsultaNoInscriptasPagina($busqueda, $legajo, $pagina, $cantidadItemsPorPagina)
{
    $listadoConsultas = array();

    try {
        if (!isset($conn)) $conn = databaseConnection();

        $pagina = ($pagina - 1) * $cantidadItemsPorPagina;
        $query = "SELECT c.id, c.fecha_hora_inicio, c.duracion, c.modalidad, c.link, c.cupo, c.estado, c.profesor_legajo, c.materia_id FROM consulta AS c INNER JOIN materia AS m ON c.materia_id=m.id INNER JOIN usuario AS u ON c.profesor_legajo=u.legajo WHERE fecha_hora_inicio > CURRENT_TIMESTAMP AND (m.nombre LIKE '%" . $busqueda . "%' OR u.nombre LIKE '%" . $busqueda . "%' OR u.apellido LIKE '%" . $busqueda . "%') AND c.id NOT IN(SELECT id FROM consulta c INNER JOIN inscripcion i ON id = consulta_id WHERE i.alumno_id = $legajo) LIMIT $pagina, $cantidadItemsPorPagina";

        $rs = mysqli_query($conn, $query);

        if (mysqli_num_rows($rs) > 0) {
            foreach ($rs as $item) {
                $consulta = new Consulta();
                $consulta->setId($item['id']);
                $consulta->setFechaHoraInicio($item['fecha_hora_inicio']);
                $consulta->setFechaHoraReprogramada($item['fecha_hora_reprogramada']);
                $consulta->setDuracion($item['duracion']);
                $consulta->setModalidad($item['modalidad']);
                $consulta->setLink($item['link']);
                $consulta->setCupo($item['cupo']);
                $consulta->setEstado($item['estado']);

                $consulta->setProfesor(findUsuarioByLegajo($item['profesor_legajo']));
                $consulta->setMateria(findMateriaById($item['materia_id']));
                $consulta->setCupoDisponible(verInscriptos($item['id']));

                array_push($listadoConsultas, $consulta);
            }
        }
        return $listadoConsultas;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($rs)) mysqli_free_result($rs);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);
    }
}
