<?php
    class Queries {
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        /**
         * Los siguientes son los metodos que nos devolveran la información requerid
         * de la base de datos para el dashboard...
         * */

         // TODO: obvio hay que adaptar esto a lo que de verdad tiene la base de datos...
         // Hay que esperar a que este creada correctamente...
        public function getProducts(){
            $query = "";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>