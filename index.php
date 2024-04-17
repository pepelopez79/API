<?php

require 'controlador.php';

$conexionBD = conectar($bd);

$ruta = $_SERVER['REQUEST_URI'];
$metodo = $_SERVER['REQUEST_METHOD'];

$rutas = [
    'GET' => [
        '/listarTareas' => 'obtenerListadoTareas',
        '/detalleTarea' => 'obtenerTareaPorId',
        '/tareasPorUsuario' => 'obtenerListadoTareasPorUsuario',
        '/tareasPorDia' => 'obtenerListadoTareasPorDia',
        '/listadoPaginadoYOrdenado' => 'obtenerListadoTareasPaginadoYOrdenado',
        '/listadoPorUsuarioPaginadoYOrdenado' => 'obtenerListadoTareasPorUsuarioPaginadoYOrdenado',
        '/tareasCompletadas' => 'obtenerTareasCompletadas',
        '/tareasPendientes' => 'obtenerTareasPendientes',
        '/listarCategorias' => 'obtenerCategorias'
    ],
    'POST' => [
        '/agregarTarea' => 'crearNuevaTarea'
    ],
    'PUT' => [
        '/actualizarTarea' => 'actualizarTarea'
    ],
    'DELETE' => [
        '/eliminarTarea' => 'eliminarTarea'
    ]
];

$rutaEncontrada = null;
foreach ($rutas[$metodo] as $endpoint => $funcion) {
    if (strpos($ruta, $endpoint) !== false) {
        $rutaEncontrada = $funcion;
        break;
    }
}

if ($rutaEncontrada === null) {
    http_response_code(400);
    $respuesta = array("error" => "Ruta no encontrada");
} else {
    $respuesta = call_user_func($rutaEncontrada, $_GET);
    if (isset($respuesta['error'])) {
        http_response_code(400); 
    } else {
        http_response_code(200);
    }
}

header('Content-Type: application/json');
echo json_encode($respuesta);

?>