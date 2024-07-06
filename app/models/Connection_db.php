<?php
    // cargamos las variables de entorno...
    $dotenv = parse_ini_file('.env');

    class Connection {
        // TODO: Llamar a las variables de entorno...
        private $host = $dotenv['DB_HOST'];
        private $dbname = $dotenv['DB_DATABASE'];
        private $username = $dotenv['DB_USERNAME'];
        private $password = $dotenv['DB_PASSWORD'];
        private $conn;

        // TODO: Descomentar cuando la base de datos este creada y tenga acceso a todo...
        /*public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo "Connection error: " . $e->getMessage();
            }
        } */
    }
?>