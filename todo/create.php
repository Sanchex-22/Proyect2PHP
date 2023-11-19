<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

include_once('../database/db_models.php.php');
include_once('../models/taskmodels.php');   
// yeah
$conex = new Conexion();
$db = $conex->getConexion();

$task = new task($db);

// endpoint 
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->titulo) && !empty($data->descripcion) && !empty($data->estado) && !empty($data->fecha) && !empty($data->responsable) && !empty($data->tipo_tarea)){
    $task->titulo = $data->titulo;
    $task->descripcion = $data->descripcion;
    $task->estado = $data->estado;
    $task->fecha = $data->fecha;
    $task->responsable = $data->responsable;
    $task->tipo_tarea = $data->tipo_tarea;

    if($task->insert_new()){
        http_response_code(201);
        echo json_encode(array("message"=>"La tarea ha sido creada"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=>"No se puede crear la tarea"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"No se puede crear la tarea, los datos estan incompletos"));
}