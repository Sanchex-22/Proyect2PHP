<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

include_once('../configuracion/conexion.php');
include_once('../objetos/todo.php');

$conex = new Conexion();
$db = $conex->getConexion();

$todo = new Todo($db);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->id) && !empty($data->titulo) && !empty($data->descripcion) && !empty($data->estado) && !empty($data->fecha) && !empty($data->responsable) && !empty($data->tipo_tarea)){
    $todo->id = $data->id;
    $todo->titulo = $data->titulo;
    $todo->descripcion = $data->descripcion;
    $todo->estado = $data->estado;
    $todo->fecha = $data->fecha;
    $todo->responsable = $data->responsable;
    $todo->tipo_tarea = $data->tipo_tarea;

    if($todo->edit()){
        http_response_code(201);
        echo json_encode(array("message"=>"La tarea ha sido editada"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=>"No se puede crear la tarea"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"No se puede editar la tarea, los datos estan incompletos"));
}