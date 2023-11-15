<?php
    require_once('database/db_models.php');

    class task extends modelsCredentials{
        protected $cod;
        protected $titulo;
        protected $descripcion;
        protected $estado;
        protected $fecha_compromiso;
        protected $tipo_;
        protected $responsable;

        public function __construct()
        {
            parent::__construct();
        }
 
        public function consultar_task() {
            $instruccion = "Select * from Tareas";
            $consulta = $this->_db->query($instruccion);
            $res = $consulta->fetch_all(MYSQLI_ASSOC);
            
            $consulta->close();  // Cierra la consulta
            $this->_db->close();

            return $res;
        }

        public function traer_task($id) {
            $instruccion = "Select * from Tareas";
            $consulta = $this->_db->query($instruccion);
            $res = $consulta->fetch_all(MYSQLI_ASSOC);
            
            $consulta->close();  // Cierra la consulta
            $this->_db->close();

            return $res;
        }

        public function create_task($titulo,$descripcion,$estado,$fecha_compromiso,$tipo_,$responsable){
            // Preparar la consulta SQL para insertar la tarea
            $sql = "INSERT INTO tareas (Titulo, Descripcion, Estado, Fecha_Compromiso, Responsable, Tipo_)
            VALUES ('$titulo', '$descripcion', '$estado', '$fecha_compromiso', '$responsable', '$tipo_')";

            // Ejecutar la consulta
            if ($this->_db->query($sql) === TRUE) {
            echo "La tarea se agregó correctamente.";
            } else {
            echo "Error al agregar la tarea: " . $this->_db->error;
            }

            // Cerrar la conexión a la base de datos
            $this->_db->close();
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

            if ($this->_db->query($sql) === TRUE) {
            echo "La tarea se actualizó correctamente.";
            } else {
            echo "Error al actualizar la tarea: " . $this->_db->error;
            }
            // Cerrar la conexión a la base de datos
            $this->_db->close();
        }
        
        public function eliminar_task($id){
            $taskId = $this->_db->real_escape_string($id);
            $sql = "DELETE FROM Tareas WHERE cod = '$taskId'";
            if ($this->_db->query($sql) === TRUE) {
                echo "La tarea fue eliminada con éxito";
            } else {
                echo "Error al eliminar la tarea: " . $this->_db->error;
            }
            $this->_db->close();
        }
    }

?>