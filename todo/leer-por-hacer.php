<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once('../configuracion/conexion.php');
include_once('../objetos/todo.php');

$conex = new Conexion();
$db = $conex->getConexion();

$todo = new Todo($db);

$stmt = $todo->get_por_hacer();
$num  = $stmt->rowCount();

if ($num > 0) {
    $todo_arr = array();
    $todo_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = array(
            "id" => $id,
            "titulo" => $titulo,
            "descripcion" => $descripcion,
            "estado" => $estado,
            "fecha" => $fecha,
            "editado" => $editado,
            "responsable" => $responsable,
            "tipo_tarea" => $tipo_tarea
        );
        array_push($todo_arr["records"], $item);
    }
    http_response_code(200);
    echo json_encode($todo_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron productos."));
}
