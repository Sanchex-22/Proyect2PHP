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

    if (!empty($data->cod) && !empty($data->Titulo) && !empty($data->Descripcion) && !empty($data->Estado) && !empty($data->Fecha_Compromiso)  && !empty($data->tipo_) && !empty($data->Responsable) && !empty($data->Etiqueta)) {
        // Llamar al método create_task() con los parámetros necesarios
        $cod = $data->cod;
        $Titulo = $data->Titulo;
        $Descripcion = $data->Descripcion;
        $Estado = $data->Estado;
        $Fecha_Compromiso = $data->Fecha_Compromiso;
        $Responsable = $data->Responsable;
        $tipo_ = $data->tipo_;
        $Etiqueta = $data->Etiqueta;
    
        $result = $task->edit_task(
            $cod,
            $Titulo,
            $Descripcion,
            $Estado,
            $Fecha_Compromiso,
            $Responsable,
            $tipo_,
            $Etiqueta
        );
    
        // Verificar el resultado de la operación
        if ($result) {
            http_response_code(201);
            echo json_encode(array("message" => "La tarea fue editada"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se puede editar la tarea"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "faltan datos para editar la tarea"));
    }

?>