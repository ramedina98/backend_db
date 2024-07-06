<?php
    /**
     * @author Ricardo Medina
     * 05/07/2024
     *
     * This is the connection to the DB, where ETL deposits all the data extracted from MongoDB...
     */

    //we use autload.php to be able to call our environment variables...
    require __DIR__ . '/../../vendor/autoload.php';
    use Dotenv\Dotenv;

    //try catch for error handling....
    try {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
    } catch (Exception $e) {
        die("Error loading Dotenv: " . $e->getMessage());
    }

    class Connection {
        // TODO: Llamar a las variables de entorno...
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function __construct(){
            $this->host = $_ENV['DB_HOST'];
            $this->dbname = $_ENV['DB_DATABASE'];
            $this->username = $_ENV['DB_USERNAME'];
            $this->password = $_ENV['DB_PASSWORD'];
        }

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