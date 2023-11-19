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


if(!empty($data->id)){
    $todo->id = $data->id;

    if($todo->delete()){
        http_response_code(201);
        echo json_encode(array("message"=>"La tarea ha sido eliminada"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=>"No se puede eliminar la tarea"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"No se puede eliminar la tarea, los datos estan incompletos"));
}