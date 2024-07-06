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

    // Load environment variables only if they are not already defined (i.e. when running locally)
    if(!getenv('RAILWAY_ENVIRONMENT')){
        //try catch for error handling....
        try {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->load();
        } catch (Exception $e) {
            die("Error loading Dotenv: " . $e->getMessage());
        }
    }

    class Connection {
        // TODO: Llamar a las variables de entorno...
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function __construct(){
            $this->host = getenv('DB_HOST') ?: $_ENV['DB_HOST'];
            $this->dbname = getenv('DB_DATABASE') ?: $_ENV['DB_DATABASE'];
            $this->username = getenv('DB_USERNAME') ?: $_ENV['DB_USERNAME'];
            $this->password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'];
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