<?php

    class task{
        public $conn;
        protected $cod;
        protected $titulo;
        protected $descripcion;
        protected $estado;
        protected $fecha_compromiso;
        protected $tipo_;
        protected $responsable;
        protected $etiqueta;

        public function __construct($db)
        {
            $this->conn = $db;
        }
 
        public function consultar_task() {
            $instruccion = "Select * from Tareas";
            $stmt = $this->conn->prepare($instruccion);
            $stmt->execute();
            return $stmt;
        }

        public function traer_task($id) {
            $sql = "SELECT * FROM Tareas WHERE cod = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public function create_task($titulo, $descripcion, $estado, $fecha_compromiso, $responsable, $tipo_, $etiqueta) {            try {
                // Preparar la consulta SQL para insertar la tarea
                $sql = "INSERT INTO tareas (Titulo, Descripcion, Estado, Fecha_Compromiso, Responsable, Tipo_, Etiqueta) VALUES (:titulo, :descripcion, :estado, :fecha_compromiso, :responsable, :tipo, :etiqueta)";
                
                // Preparar la declaración
                $stmt = $this->conn->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':fecha_compromiso', $fecha_compromiso);
                $stmt->bindParam(':responsable', $responsable);
                $stmt->bindParam(':tipo', $tipo_);
                $stmt->bindParam(':etiqueta', $etiqueta);
                
                // Ejecutar la consulta
                $stmt->execute();
                
                http_response_code(201);
                echo json_encode(array("message" => "La tarea se agregó correctamente"));
                
                return true; // Indicar éxito
            } catch (PDOException $e) {
                http_response_code(503);
                echo json_encode(array("message" => "Error al agregar la tarea: " . $e->getMessage()));
                
                return false; // Indicar error
            }
        }
        
        public function edit_task($cod, $titulo, $descripcion, $estado, $fecha_compromiso, $tipo_, $responsable,$etiqueta) {
            try {
                // Verificar si la tarea existe
                $check_query = "SELECT cod FROM tareas WHERE cod = :cod";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":cod", $cod);
                $check_stmt->execute();
        
                if ($check_stmt->rowCount() > 0) {
                    // La tarea existe, proceder con la actualización
                    $update_query = "UPDATE tareas SET 
                        Titulo=:Titulo, 
                        Descripcion=:Descripcion, 
                        Estado=:Estado, 
                        Fecha_Compromiso=:Fecha_Compromiso,
                        Responsable=:Responsable,
                        Tipo_=:Tipo_,
                        Etiqueta='(Editado)'
                        WHERE cod=:cod";
        
                    $update_stmt = $this->conn->prepare($update_query);
        
                    // Limpiar y vincular los parámetros
                    $titulo = htmlspecialchars(strip_tags($titulo));
                    $descripcion = htmlspecialchars(strip_tags($descripcion));
                    $estado = htmlspecialchars(strip_tags($estado));
                    $fecha_compromiso = htmlspecialchars(strip_tags($fecha_compromiso));
                    $responsable = htmlspecialchars(strip_tags($responsable));
                    $tipo_ = htmlspecialchars(strip_tags($tipo_));
                    $cod = htmlspecialchars(strip_tags($cod));
        
                    $update_stmt->bindParam(":cod", $cod);
                    $update_stmt->bindParam(":Titulo", $titulo);
                    $update_stmt->bindParam(":Descripcion", $descripcion);
                    $update_stmt->bindParam(":Estado", $estado);
                    $update_stmt->bindParam(":Fecha_Compromiso", $fecha_compromiso);
                    $update_stmt->bindParam(":Responsable", $responsable);
                    $update_stmt->bindParam(":Tipo_", $tipo_);
                    $$update_stmt->bindParam(':etiqueta', $etiqueta);
        
                    // Ejecutar la consulta de actualización
                    if ($update_stmt->execute()) {
                        http_response_code(200);
                        echo json_encode(array("message" => "La tarea se actualizó correctamente"));
                        return true;
                    } else {
                        http_response_code(503);
                        echo json_encode(array("message" => "Error al actualizar la tarea"));
                        return false; 
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "La tarea no existe"));
                    return false;
                }
            } catch (PDOException $e) {
                http_response_code(503);
                echo json_encode(array("message" => "Error al actualizar la tarea: " . $e->getMessage()));
                return false;
            }
        }
        
        
        
        public function eliminar_task($id) {
            try {
                $check_query = "SELECT cod FROM Tareas WHERE cod = :id";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":id", $id);
                $check_stmt->execute();
        
                if ($check_stmt->rowCount() > 0) {
                    // La tarea existe, proceder con la eliminación
                    $delete_query = "DELETE FROM Tareas WHERE cod = :id";
                    $delete_stmt = $this->conn->prepare($delete_query);
        
                    // Limpiar y vincular el parámetro
                    $taskId = htmlspecialchars(strip_tags($id));
                    $delete_stmt->bindParam(":id", $taskId);

                    if ($delete_stmt->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "La tarea no existe"));
                    return false;
                }
            } catch (PDOException $e) {
                return false;
            }
        }
        
        
    }

?>