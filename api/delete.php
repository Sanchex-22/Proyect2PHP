<?php
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json;charset=UTF-8");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Max-Age:3600");
    header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
    include_once('../database/db_models.php');
    include_once('../obj/taskmodels.php');   
    // yeah
    $conex = new ConexionDB();
    $db = $conex->getConexionDB();
    $task = new task($db);

    $data = json_decode(file_get_contents("php://input"));
    var_dump($data);
    if(!empty($data->cod)){
        $cod = $data->cod;

        if($task->eliminar_task($cod)){
            http_response_code(201);
            echo json_encode(array("message"=>"La tarea ha sido eliminada"));
        }
        else{
            http_response_code(503);
            echo json_encode(array("message"=>"Error al eliminar la tarea"));
        }
    }else{
        http_response_code(400);
        echo json_encode(array("message"=>"No se puede eliminar la tarea, faltan datos"));
    }
?>