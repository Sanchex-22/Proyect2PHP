<?php
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json;charset=UTF-8");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Max-Age:3600");
    header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
    include_once('../database/db_models.php');
    include_once('../obj/user_models.php');   
    // yeah
    $conex = new ConexionDB();
    $db = $conex->getConexionDB();
    $user = new users($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->User_Name)) {
        // Llamar al método create_task() con los parámetros necesarios
        $User_Name = $data->User_Name;
    
        $result = $user->autenticar($User_Name);
    
        // Verificar el resultado de la operación
        if ($result) {
            http_response_code(201);
            echo json_encode(array("message" => "usuario creado"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se puede crear el usuario"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "No se puede loguear el usuario, es null"));
    }
?>