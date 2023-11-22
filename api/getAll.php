<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Max-Age:3600");
    header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
    include_once('../database/db_models.php');
    include_once('../obj/taskmodels.php');   
    // yeah
    $conex = new ConexionDB();
    $db = $conex->getConexionDB();
    $task = new task($db);

    $stmt = $task->consultar_task();
    $num  = $stmt->rowCount();

    if ($num > 0) {
        $tareas_arr = array();
        $tareas_arr["tareas"] = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $item = array(
                "cod" => $cod,
                "Titulo" => $Titulo,
                "Descripcion" => $Descripcion,
                "Estado" => $Estado,
                "Fecha_Compromiso" => $Fecha_Compromiso,
                "Tipo_" => $Tipo_,
                "Responsable" => $Responsable,
                "Etiqueta" => $Etiqueta,
            );
            array_push($tareas_arr["tareas"], $item);
        }
        http_response_code(200);
        echo json_encode($tareas_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No se encontraron tareas."));
    }

?>