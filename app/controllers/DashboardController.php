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
            // this variable is used for product - user info
            $data = $this->queries_dm->getProductAndUser();
            include 'app/views/dashboard.php';
        }
    }
?>