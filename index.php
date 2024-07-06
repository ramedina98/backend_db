<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'config/config.php';
    require 'app/models/Connection_db.php';
    require 'app/models/Queries.php';
    require 'app/controllers/DashboardController.php';

    $controller = new DashboardController();
    $controller->index();
?>