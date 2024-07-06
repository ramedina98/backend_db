<?php
    class DashboardController {
        private $queries;

        /*public function __construct(){
            $connection = new Connection();
            $db = $connection->getConnection();
            $this->queries = new Queries($db);
        }*/

        public function index() {
            // TODO: descomentar cuando la conexion a la base de datos este hecha correctamente...
            // $data = $this->queries->getProducts();
            $data = "Hola, soy la variable data que esta en el file: DashboardController.php jajaja";
            include 'app/views/dashboard.php';
        }
    }
?>