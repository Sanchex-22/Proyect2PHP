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
    if(!empty($data->cod)){
        $cod = $data->cod;
        $stmt = $task->traer_task($cod);
        $num  = $stmt->rowCount();

        if ($num > 0) {
            $todo_arr = array();
            $todo_arr["tareas"] = array();
        
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
                );
                array_push($todo_arr["tareas"], $item);
            }
            http_response_code(200);
            echo json_encode($todo_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No se encontraron productos."));
        }

    } else {
        http_response_code(400);
        echo json_encode(array("message" => "No se puede crear la tarea, los datos están incompletos"));
    }


?>