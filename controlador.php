<?php

require 'modelo.php';

function obtenerListadoTareas()
{
    $conexionBD = conectar($GLOBALS['bd']);
    $sql = "SELECT * FROM tareas";
    $stmt = $conexionBD->query($sql);
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareas) {
        return $tareas;
    } else {
        return array("message" => "No se encontraron tareas");
    }
}

function obtenerListadoTareasPorUsuario($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $idUsuario = isset($parametros['idUsuario']) ? $parametros['idUsuario'] : null;
    if ($idUsuario !== null) {
        $sql = "SELECT * FROM tareas WHERE IDUSUARIO = :idUsuario";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);
        $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tareas) {
            return $tareas;
        } else {
            return array("message" => "No se encontraron tareas para el usuario proporcionado");
        }
    } else {
        return array("error" => "ID de usuario no proporcionado");
    }
}

function obtenerListadoTareasPorDia($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $dia = isset($parametros['dia']) ? $parametros['dia'] : null;
    if ($dia !== null) {
        $sql = "SELECT * FROM tareas WHERE DATE(fecha) = :dia";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute(['dia' => $dia]);
        $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tareas) {
            return $tareas;
        } else {
            return array("message" => "No se encontraron tareas para la fecha proporcionada");
        }
    } else {
        return array("error" => "Fecha no proporcionada");
    }
}

function obtenerTareaPorId($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $id = isset($parametros['id']) ? $parametros['id'] : null;
    if ($id !== null) {
        $sql = "SELECT * FROM tareas WHERE IDTAREA = :id";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute(['id' => $id]);
        $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tarea) {
            return $tarea;
        } else {
            return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
        }
    } else {
        return array("error" => "ID de tarea no proporcionado");
    }
}

function obtenerListadoTareasPaginadoYOrdenado($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $pagina = isset($parametros['pagina']) ? intval($parametros['pagina']) : 1;
    $tareasPorPagina = isset($parametros['tareasPorPag']) ? intval($parametros['tareasPorPag']) : 5;
    $offset = ($pagina - 1) * $tareasPorPagina;

    $orden = isset($parametros['orden']) ? strtoupper($parametros['orden']) : 'desc';

    $sql = "SELECT * FROM tareas ORDER BY fecha $orden LIMIT :offset, :tareasPorPag";
    $stmt = $conexionBD->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':tareasPorPag', $tareasPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT COUNT(*) AS total FROM tareas";
    $stmtTotal = $conexionBD->query($sqlTotal);
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    return array(
        "tareas" => $tareas,
        "total_registros" => $totalRegistros
    );
}

function obtenerListadoTareasPorUsuarioPaginadoYOrdenado($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $pagina = isset($parametros['pagina']) ? intval($parametros['pagina']) : 1;
    $tareasPorPagina = isset($parametros['tareasPorPag']) ? intval($parametros['tareasPorPag']) : 5;
    $offset = ($pagina - 1) * $tareasPorPagina;

    $orden = isset($parametros['orden']) ? strtoupper($parametros['orden']) : 'desc';

    $idUsuario = isset($parametros['idUsuario']) ? $parametros['idUsuario'] : null;

    $sql = "SELECT * FROM tareas WHERE IDUSUARIO = :idUsuario ORDER BY fecha $orden LIMIT :offset, :tareasPorPag";
    $stmt = $conexionBD->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':tareasPorPag', $tareasPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT COUNT(*) AS total FROM tareas WHERE IDUSUARIO = :idUsuario";
    $stmtTotal = $conexionBD->prepare($sqlTotal);
    $stmtTotal->execute(['idUsuario' => $idUsuario]);
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    return array(
        "tareas" => $tareas,
        "total_registros" => $totalRegistros
    );
}

function obtenerTareasCompletadas()
{
    $conexionBD = conectar($GLOBALS['bd']);
    $sql = "SELECT * FROM tareas WHERE ESTADO = 'Completada'";
    $stmt = $conexionBD->query($sql);
    $tareasCompletadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareasCompletadas) {
        return $tareasCompletadas;
    } else {
        return array("message" => "No se encontraron tareas completadas");
    }
}

function obtenerTareasPendientes()
{
    $conexionBD = conectar($GLOBALS['bd']);
    $sql = "SELECT * FROM tareas WHERE ESTADO = 'Pendiente'";
    $stmt = $conexionBD->query($sql);
    $tareasPendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareasPendientes) {
        return $tareasPendientes;
    } else {
        return array("message" => "No se encontraron tareas pendientes");
    }
}

function crearNuevaTarea()
{
    $conexionBD = conectar($GLOBALS['bd']);
    $data = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO tareas (IDUSUARIO, IDCATEGORIA, TITULO, IMAGEN, DESCRIPCION, LUGAR, ESTADO) 
            VALUES (:idusuario, :idcategoria, :titulo, :imagen, :descripcion, :lugar, :estado)";
    $stmt = $conexionBD->prepare($sql);
    $stmt->execute([
        'idusuario' => $data['idusuario'],
        'idcategoria' => $data['idcategoria'],
        'titulo' => $data['titulo'],
        'imagen' => $data['imagen'],
        'descripcion' => $data['descripcion'],
        'lugar' => $data['lugar'],
        'estado' => $data['estado']
    ]);

    if ($stmt->rowCount() > 0) {
        return array("message" => "Tarea creada correctamente");
    } else {
        return array("error" => "No se pudo crear la tarea");
    }
}

function actualizarTarea($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $data = json_decode(file_get_contents('php://input'), true);
    $id = isset($parametros['id']) ? $parametros['id'] : null;
    if ($id !== null) {
        $sql = "UPDATE tareas 
                SET TITULO = :titulo, IMAGEN = :imagen, DESCRIPCION = :descripcion, IDCATEGORIA = :idcategoria, 
                    LUGAR = :lugar, ESTADO = :estado 
                WHERE IDTAREA = :id";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'titulo' => $data['titulo'],
            'imagen' => $data['imagen'],
            'descripcion' => $data['descripcion'],
            'idcategoria' => $data['idcategoria'],
            'lugar' => $data['lugar'],
            'estado' => $data['estado']
        ]);

        if ($stmt->rowCount() > 0) {
            return array("message" => "Tarea actualizada correctamente");
        } else {
            return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
        }
    } else {
        return array("error" => "ID de tarea no proporcionado");
    }
}

function eliminarTarea($parametros)
{
    $conexionBD = conectar($GLOBALS['bd']);
    $id = isset($parametros['id']) ? $parametros['id'] : null;
    if (!isset($id) || !is_numeric($id)) {
        return array("error" => "ID de tarea no válido");
    }
    $sql = "DELETE FROM tareas WHERE IDTAREA = :id";
    $stmt = $conexionBD->prepare($sql);
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() > 0) {
        return array("message" => "Tarea eliminada correctamente");
    } else {
        return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
    }
}

function obtenerCategorias()
{
    $conexionBD = conectar($GLOBALS['bd']);
    $sql = "SELECT IDCAT, NOMBRECAT FROM CATEGORIAS";
    $stmt = $conexionBD->query($sql);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($categorias) {
        return $categorias;
    } else {
        return array("message" => "No se encontraron categorías");
    }
}

?>
