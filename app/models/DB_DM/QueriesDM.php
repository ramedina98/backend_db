<?php
    // Here we have all the required queries to get data from the data mart...

    class Queries_DM{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        /**
         * Los siguientes son los metodos que nos devolveran la información requerid
         * de la base de datos para el dashboard...
         * */

         // NOTE: adaptar este query para obtener los tos necesarios de la base de dato...
         // Hay que esperar a que este creada correctamente...
        public function getProducts(){
            $query = "";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>