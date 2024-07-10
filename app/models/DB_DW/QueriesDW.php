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

        // FIXME: Hay que rediseñar esta parte, ya que este query tiene que obtener
        // la info del dw y mandarla al dm, el cual es un espejo del primero...
         // Hay que esperar a que este creada correctamente...
        public function getProducts(){
            //TODO: Implementar la logica necesaria...
        }
    }
?>