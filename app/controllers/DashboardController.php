<?php
    /**
     * 
     */

    class DashboardController {
        // Declare properties to hold query instances for data warehouse and data mart
        private $queries_dw;
        private $queries_dm;

        // Constructor method to initialize database connections and queries
        public function __construct(){
            // Create a new connection instance for the data warehouse (DW) and data mart (DM)
            $connection_dw = new Connection_DW();
            $connection_dm = new Connection_DM();

            //queries of the dw database...
            $db_dw = $connection_dw->getConnection();
            $this->queries_dw = new Queries_DW($db_dw);

            // queries of the  dm database...
            $db_dm = $connection_dm->getConnection();
            $this->queries_dm = new Queries_DM($db_dm);
        }

        // method to handle the main logic for the dashboard...
        public function index() {
            /**
             * TODO: Aqui hay que generar las variables para ser usadas en el dashboard.php
             * NOTE: Esto es un ejemplo...
             * $data_dm = $this->queries_dm->getProducts();
             * $data_dw = $this->queries_dw->getProducts();
             */
            include 'app/views/dashboard.php';
        }
    }
?>