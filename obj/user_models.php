<?php
    class users{
        public $conn;
        protected $cod_user;
        protected $username;
        
        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function autenticar($username) {
            try {
                // Verificar si el User_Name ya existe
                var_dump($username);
                $check_query = "SELECT User_Name FROM Usuarios WHERE User_Name = :User_Name";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":User_Name", $username);
                $check_stmt->execute();
        
                if ($check_stmt->rowCount() > 0) {
                    http_response_code(404);
                    echo json_encode(array("message" => "Usuario logueado"));
                    return true;
                } else {
                    // El User_Name no existe, proceder con la creación del usuario
                    $create_query = "INSERT INTO Usuarios (User_Name) VALUES (:User_Name)";
                    $create_stmt = $this->conn->prepare($create_query);
        
                    // Limpiar y vincular el parámetro
                    $username = htmlspecialchars(strip_tags($username));
                    $create_stmt->bindParam(":User_Name", $username);
        
                    // Ejecutar la consulta de inserción
                    if ($create_stmt->execute()) {
                        http_response_code(404);
                        echo json_encode(array("message" => "Usuario creado"));
                        return true;
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Error al crear el usuario"));
                        return false;
                    }
                }
            } catch (PDOException $e) {
                // Manejar cualquier excepción de PDO
                return false;
            }
        }
    }

?>