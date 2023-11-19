<?php
    require_once('database/db_models.php');

    class users extends modelsCredentials{
        protected $cod_user;
        protected $username;
        
        public function __construct()
        {
            parent::__construct();
        }

        public function autenticar($username, ) {
            $username = $this->_db->real_escape_string($username); // Para prevenir inyección de SQL
            
    
            $sql = "SELECT * FROM usuarios WHERE user_name='$username'";
            $result = $this->_db->query($sql);
    
            if ($this->_db->error) {
                die("Error en la consulta: " . $this->_db->error);
            }
    
            if ($result->num_rows == 1) {
                return true;
            } else {
                $sql = "INSERT INTO Usuarios (User_Name) VALUES ('$username')";
                $result = $this->_db->query($sql);

                if ($this->_db->error) {
                    die("Error en la consulta: " . $this->_db->error);
                }
                else return true;
            }
        }
    }

?>