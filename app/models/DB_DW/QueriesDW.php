<?php
    // Here we have all the required queries to get data from the data warehouse...

    class Queries_DW{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        // this method does the connection to the data warehouse...
        public function getProducts() {
            // TODO: implementar la logica para extrar los datos de DW y guardarlos en DM (hacer el proceso a una hora en especifico)
        }
    }
?>