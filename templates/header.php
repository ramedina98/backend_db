<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNEDL Products Dashboard</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/components.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>public/icons/favicon.ico" type="image/x-icon">
    <!--cdn de bootstrap, stilos-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Required script to use google charts-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function() {
        // Trigger each client's chart draw function
        <?php
        if (is_array($data)) {
            foreach($data as $client => $products) {
                echo "drawChartForClient_$client();\n";
            }
        }
        ?>
    });
    </script>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="a_color_nav_label" href="#">Dashboard Ventas BD</a>
            <button id="btn_navbar_toggler" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span id="icon_navbar_toggle" class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Base de Datos II</h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Probedores</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tiendas
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Unedl 90</a></li>
                                <li><a class="dropdown-item" href="#">Centro Universitario</a></li>
                                <li><a class="dropdown-item" href="#">Casa unedl</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input id="input_search" class="form-control me-2" type="search" placeholder="Busqueda de clientes leales" aria-label="Search">
                        <button id="btn_search" class="btn">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>
