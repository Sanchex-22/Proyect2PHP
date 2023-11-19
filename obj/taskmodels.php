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
            $instruccion = "Select * from Tareas";
            $consulta = $this->conn->query($instruccion);
            $res = $consulta->fetch_all(MYSQLI_ASSOC);
            
            $consulta->close();  // Cierra la consulta
            $this->conn->close();

            return $res;
        }

        public function create_task($titulo, $descripcion, $estado, $fecha_compromiso, $tipo_, $responsable) {
            try {
                // Preparar la consulta SQL para insertar la tarea
                $sql = "INSERT INTO tareas (Titulo, Descripcion, Estado, Fecha_Compromiso, Responsable, Tipo_) VALUES (:titulo, :descripcion, :estado, :fecha_compromiso, :responsable, :tipo)";
                
                // Preparar la declaración
                $stmt = $this->conn->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':fecha_compromiso', $fecha_compromiso);
                $stmt->bindParam(':responsable', $responsable);
                $stmt->bindParam(':tipo', $tipo_);
                
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
        
        public function edit_task($id,$titulo,$descripcion,$estado,$fecha_compromiso,$tipo_,$responsable){
            $sql = "UPDATE tareas SET 
            Titulo='$titulo', 
            Descripcion='$descripcion', 
            Estado='$estado', 
            Fecha_Compromiso='$fecha_compromiso',
            Responsable='$responsable',
            Tipo_ = '$tipo_',
            Etiqueta = '(Editado)'
            WHERE cod='$id'";

            if ($this->conn->query($sql) === TRUE) {
            echo "La tarea se actualizó correctamente.";
            } else {
            echo "Error al actualizar la tarea: " . $this->conn->error;
            }
            // Cerrar la conexión a la base de datos
            $this->conn->close();
        }
        
        public function eliminar_task($id){
            $taskId = $this->conn->real_escape_string($id);
            $sql = "DELETE FROM Tareas WHERE cod = '$taskId'";
            if ($this->conn->query($sql) === TRUE) {
                echo "La tarea fue eliminada con éxito";
            } else {
                echo "Error al eliminar la tarea: " . $this->conn->error;
            }
            $this->conn->close();
        }
    }

?>