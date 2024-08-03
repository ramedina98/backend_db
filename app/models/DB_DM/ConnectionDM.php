<?php
    /**
     * @author Ricardo Medina
     * 04/07/2024
     * @ this is the connection class to the data mart
     */

    //we use autload.php to be able to call our environment variables...
    require __DIR__ . '/../../../vendor/autoload.php';
    use Dotenv\Dotenv;

    // Load environment variables only if they are not already defined (i.e. when running locally)
    if(!getenv('RAILWAY_ENVIRONMENT')){
        //try catch for error handling....
        try {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
            $dotenv->load();
        } catch (Exception $e) {
            die("Error loading Dotenv: " . $e->getMessage());
        }
    }
    class Connection_DM{

        private $host;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function __construct(){
            $this->host = getenv('DB_HOST_DM') ?: $_ENV['DB_HOST_DM'];
            $this->dbname = getenv('DB_DATABASE_DM') ?: $_ENV['DB_DATABASE_DM'];
            $this->username = getenv('DB_USERNAME_DM') ?: $_ENV['DB_USERNAME_DM'];
            $this->password = getenv('DB_PASSWORD_DM') ?: $_ENV['DB_PASSWORD_DM'];
        }

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

                //verufy connection...
                if($this->conn->connect_errno){
                    throw new Exception("Connection error: " . $this->conn->connect_error);
                }

                return $this->conn;
            } catch(Exception $e){
                echo "Connection error: " . $e->getMessage();
                return null;
            }
        }
    }
?>