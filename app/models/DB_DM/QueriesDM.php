<?php
    // Here we have all the required queries to get data from the data mart...

    class Queries_DM{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        // this method does the connection to the data mart..
        public function getProducts() {
            //TODO: Logica para obtener requeridos
        }

        //NOTE: faltaria un methodo más para el manejo de esta base de datos (DATA MART)...
    }
?>