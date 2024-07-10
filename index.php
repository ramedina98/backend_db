<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'config/config.php';
    require 'app/models/DB_DW/Connection_DW.php';
    require 'app/models/DB_DW/QueriesDW.php';
    require 'app/models/DB_DM/ConnectionDM.php';
    require 'app/models/DB_DM/QueriesDM.php';
    require 'app/controllers/DashboardController.php';

    $controller = new DashboardController();
    $controller->index();
?>