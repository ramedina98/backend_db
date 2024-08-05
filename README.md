# Dashboard for UNEDL backend equipment supplies
:information_source: :information_source:

This project implements a solution to visualize data using **Google** **Charts**. The data, initially captured in a **NoSQL** **database**, is transformed and loaded into a **SQL** **database** through an ETL (Extract, Transform, Load) process. This data is then queried from the SQL database and presented in charts through Google Charts.

This is the link where you can view the dashboard, hostinger was used to host the project --> https://backendproyect.abarrotesuniversidad.shop/

:information_source: :information_source:

## Dependencies

This project was developed using PHP. Although no specific dependencies were added, a vendor folder is included for managing potential dependencies in the future. The vendor folder is standard in PHP projects that use Composer, a tool for dependency management in PHP.

## Purpose.

The purpose of this Dashboard is to display valuable information for the decision-making department. It provides insights about our clients and which products they purchase the most, as well as which of our products are the best sellers. The information is collected biweekly.

## APP
It is in this folder where we find the operating logic of our web application **Dashboard**

### Controllers
**File** **Path:** backend_db/app/controllers/DashboardController.php
This file defines the DashboardController class, responsible for managing queries to two different databases: a Data Warehouse (DW) and a Data Mart (DM).

```PHP
<?php
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
            // this variable is used for product - user info..
            $data = $this->queries_dm->getProductAndUser();
            // this variable is used for product - price info...
            $data1 = $this->queries_dm->getProductAndPrice();
            include 'app/views/dashboard.php';
        }
    }
?>
```
### Index
The index method in the DashboardController class handles requests for the dashboard's main page. This method performs two database queries to obtain information about products and users, as well as products and prices, and then includes the dashboard view.

```PHP
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
```
### Models
**File** **path:** “backend_db/app/models/DB_DM/ConnectionDM.php”
The code provides a class Connection_DM that manages the connection to a Data Mart database using environment variables. If the environment variables are not defined, they are loaded from a .env file. The Dotenv library is used to handle these variables.

```PHP
    <?php
        //we use autload.php to be able to call our environment variables...
        require __DIR__ . '/../../../vendor/autoload.php';
        use Dotenv\Dotenv;

        // Load environment variables only if they are not already defined (i.e. when running locally)
        if(!getenv('RAILWAY_ENVIRONMENT')){
            //try catch for error handling....
            try {
                $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
                $dotenv->load();
            } catch (Exception $e) {
                die("Error loading Dotenv: " . $e->getMessage());
            }
        }
        class Connection_DM{

            private $host;
            private $dbname;
            private $username;
            private $password;
            private $conn;

            public function __construct(){
                $this->host = getenv('DB_HOST') ?: $_ENV['DB_HOST_DM'];
                $this->dbname = getenv('DB_DATABASE') ?: $_ENV['DB_DATABASE_DM'];
                $this->username = getenv('DB_USERNAME') ?: $_ENV['DB_USERNAME_DM'];
                $this->password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD_DM'];
            }

            public function getConnection(){
                $this->conn = null;
                try{
                    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

                    //verufy connection...
                    if($this->conn->connect_errno){
                        throw new Exception("Connection error: " . $this->conn->connect_error);
                    }

                    return $this->conn;
                } catch(Exception $e){
                    echo "Connection error: " . $e->getMessage();
                    return null;
                }
            }
        }
    ?>
```

**File** **path:** “backend_db/app/models/DB_DM/QueriesDM.php”
The code defines a class Queries_DM that is used to perform queries on the Data Mart database. The class has a constructor that receives a database connection and stores it in a private property for use in the queries.

```PHP
    <?php
        // Here we have all the required queries to get data from the data mart...

        class Queries_DM{
            private $conn;

            public function __construct($db){
                $this->conn = $db;
            }


            // private functions...

            // Method to map the product and user information
            private function mapProductUser($data){
                // This is the array that will return the mapped data
                $array = [];

                // Verify if the data is not empty
                if($data !== false){
                    // Iterate over each row of data
                    foreach($data as $row){
                        // Extract client name, product name, and quantity from the row
                        $client = $row['DM_user_name'];
                        $product = $row['DM_producto'];
                        $quantity = $row['DM_Cantidad'];

                        // Check if the client is already in the array
                        if(!isset($array[$client])){
                            // If the client is not present, initialize an empty array for that client
                            $array[$client] = [];
                        }

                        // Check if the product is already in the array for the client
                        if(isset($array[$client][$product])){
                            // If the product already exists, add the current quantity to the existing quantity
                            $array[$client][$product] += $quantity;
                        } else {
                            // If the product does not exist, initialize the quantity with the current value
                            $array[$client][$product] = $quantity;
                        }
                    }

                    // Sort products for each client in descending order by quantity
                    foreach($array as &$products){
                        arsort($products);
                    }
                }

                // Return the mapped array
                return $array;
            }

            // This is the method to map the product and price info...
            private function mapProductPrice($data) {
                // This array will store the mapped information...
                $array = [];

                // Checks if the variable $data is not empty...
                if ($data !== false) {
                    // Iterate over each row of data...
                    foreach ($data as $row) {
                        // Extract the necessary data into separate variables...
                        $product = $row['DM_producto'];
                        $price = $row['DM_Precio'];
                        $quantity = $row['DM_Cantidad'];

                        // check if the product already exist in the array...
                        if (!isset($array[$product])) {
                            // if the product is not in the array, initialize an array for this product...
                            $array[$product] = [
                                'unit_prices' => [],
                                'total_price' => 0,
                                'total_quantity' => 0
                            ];
                        }

                        // update the current unit price in the array if is not present...
                        if (!isset($array[$product]['unit_prices'][$price])) {
                            $array[$product]['unit_prices'][$price] = $price;
                        }

                        // calculate the total price for the product and update the current total price...
                        $array[$product]['total_price'] += $price * $quantity;

                        // Update the total quantity for the product...
                        $array[$product]['total_quantity'] += $quantity;
                    }
                }

                // return the require array...
                return $array;
            }


            // public functions...

            // This method helps us to get the products and the user that bought that product...
            public function getProductAndUser() {
                // this is the require query...
                $query = "SELECT DM_user_name, DM_producto, DM_Cantidad, DM_Fecha
                FROM `dm_ventas`
                WHERE `DM_Fecha` BETWEEN '2024-07-22' AND '2024-08-02';";

                // Check if the statement was prepared successfully
                try{
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);

                    // mapped data...
                    $mappedData = $this->mapProductUser($data);

                    return $mappedData; // Retorna el array directamente
                } catch(Exception $e){// If there was an error preparing the statement, output the error message
                    echo "Error al obtener los datos: " . $e->getMessage();
                    return false;
                }
            }

            // This method helps us define which product is the best seller, its total revenue, and who buys it the most...
            public function getProductAndPrice(){
                // this is the require query...
                $query = "SELECT DM_producto, DM_Precio, DM_Cantidad
                FROM `dm_ventas`
                WHERE `DM_Fecha` BETWEEN '2024-07-22' AND '2024-08-02';";

                //checkif the statement was prepared successfully...
                try{
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);

                    // mapped data...
                    $mappedData = $this->mapProductPrice($data);

                    return $mappedData; // return the data in the required format...
                } catch(Exception $e){
                    echo "Error al obtener los datos: " . $e->getMessage();
                    return false;
                }
            }
        }
    ?>
```

### Views
**File** **path:** “backend_db/app/views/dashboard.php”
This code dynamically includes the necessary files to build a web page that displays two charts and the total sales. The site's header and footer are included at the beginning and end of the file, respectively. Within the main content, forms for selecting dates and scripts for generating pie and bar charts are included. Additionally, the total sales amount is calculated and displayed in a specific section.

```PHP
<?php
    /**
     * Se esta agregando de manera dinamica el header...
     */
    include './templates/header.php';
?>

<main>
    <section class="main_graph_container">
        <div class="title_form">
            <div class="graph_title_container">
                <h3>Grafica de Usuario Producto</h3>
            </div>
            <?php include './templates/date_form.php'?>
        </div>
        <!--Here we have the graph-->
        <div class="graph_container">
            <?php include './app/utils/scriptPieChart.php'; ?>
        </div>
    </section>

    <section class="main_graph_container">
        <div class="title_form">
            <div class="graph_title_container">
                <h3>Grafica de Producto Precio</h3>
            </div>
            <?php include './templates/date_form.php'?>
        </div>
        <!--Here we have the graph-->
        <div class="graph_container">
            <?php include './app/utils/scriptBarChart.php'; ?>
        </div>
        <!--section where is the total amount of sales-->
        <div id="total_amount_div">
            <h4>Total vendido:
                <span>
                    <?php include './app/utils/totalAmountOfSales.php' ?>
                </span>
            </h4>
        </div>
    </section>

</main>

<?php
    /**
     * Se esta agregando de manera dinamica el footer...
     */
    include './templates/footer.php';
?>
```

### Utils
**File** **path:** “backend_db/app/utils/scriptPieChart.php”
This PHP code dynamically generates pie charts to visualize information about products purchased by different clients. If $data is an array, the code creates a container for the charts and, for each client, creates a pie chart using Google Charts. The data for each chart is prepared in JSON format and passed to a JavaScript script that draws the chart in the browser. If no data is available, a corresponding message is displayed.

```PHP
<?php
//This element helps us to print the information obtained from the database in the pie chart...

// Check if $data is an array
if (is_array($data)) {
    //NOTA: corregir esto, hay que hacer una funcion que me saque la quincena de la que saca los datos...
    $date = '22 de Julio al 02 de Agosto';

    echo '<div id="charts-container">';
    // Iterate over clients
    foreach($data as $client => $products) {
        echo "<h2 style='text-transform: uppercase; color: #294D58; font-size: 1.4em; margin: 1em 0;'>$client</h2>";
        echo "<div id='chart_$client' style='width: 55vw; height: 450px;'></div>";

        // Prepare data for chart
        $chartData = [];
        foreach ($products as $product => $quantity) {
            $chartData[] = [$product, $quantity];
        }
        $chartDataJson = json_encode($chartData);

        // Add JavaScript to draw the chart for this client
        echo "<script type='text/javascript'>
            function drawChartForClient_$client() {
                var data = google.visualization.arrayToDataTable([
                    ['Product', 'Quantity'],
                    " . implode(", ", array_map(function($item) {
                        return "['" . addslashes($item[0]) . "', " . $item[1] . "]";
                    }, $chartData)) . "
                ]);

                var biweekly = {
                    title: 'Quincena del $date'
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_$client'));
                chart.draw(data, biweekly);
            }
            google.charts.setOnLoadCallback(drawChartForClient_$client);
        </script>";
    }
    echo '</div>';
} else {
    echo "No data available.";
}
?>
```

**File** **path:** “backend_db/app/utils/currentDate.php”
This PHP code defines a function formatDate that converts a date into a readable format in Spanish. The function takes a date as input, converts it to a DateTime object in the Mexico City time zone, and then formats it in the "day of month of year" format using month names in Spanish. If an error occurs while processing the date, the function returns an error message.

```PHP
<?php
function formatDate($date) {
    try {
        $dateTime = new DateTime($date, new DateTimeZone('America/Mexico_City'));

        // array with all the names of the months in spanish...
        $months = [
            1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];

        //format the date in the desired format "dia de mes de año"...
        // dia = day - mes = month - año = year...
        $day = $dateTime->format('j');
        $month = $months[intval($dateTime->format('n'))];
        $year = $dateTime->format('Y');

        // return the require format...
        return "$day de $month de $year";
    } catch (Exception $e) {
        return 'Fecha inválida';
    }
}
?>
```

**File** **path:** “backend_db/app/utils/scriptBarChart.php”
This PHP code generates a column chart using Google Charts based on the data provided in $data1. If $data1 is an array, the necessary data and colors for the chart are prepared, with a title indicating the specific time period. The data is converted to JSON format and included in a JavaScript script that draws the chart in an HTML container. If no data is available, an error message is displayed.

```PHP
<?php
// Check if $data1 is an array
if (is_array($data1)) {
    // Array of colors
    $colors = ['#294D58', '#DBE5B9', '#FF8656', '#990099', '#0099C6', '#DD4477', '#66AA00', '#B82E2E', '#316395', '#994499'];

    // N0TA: corregir esto, estaria bien que fuera una funcion que actualiza esto automatico...
    // date...
    $date = '22 de Julio al 02 de Agosto';

    // Prepare data for chart
    $chartData = [["Product", "Total $", "Vendidas ", ["role" => "style"], ["role" => "annotation"]]];

    // Initialize an empty array to store colors
    $productColors = [];
    $colorIndex = 0;

    foreach ($data1 as $product => $details) {
        // Extract product details
        $productName = $product;
        $totalPrice = floatval($details['total_price']); // Ensure totalPrice is a float
        $totalQuantity = floatval($details['total_quantity']); // Ensure totalQuantity is an integer

        $color = isset($colors[$colorIndex]) ? $colors[$colorIndex] : 'red'; // Assign color based on index
        $style = 'color: ' . $color;
        $annotation = $totalQuantity;

        // Add product data to chartData
        $chartData[] = [$productName, $totalPrice, $totalQuantity, $style, $annotation];

        // Collect colors for use in the JavaScript
        $productColors[] = $color;

        // Increment color index and wrap around if needed
        $colorIndex = ($colorIndex + 1) % count($colors);
    }

    // Convert chartData to JSON
    $chartDataJson = json_encode($chartData, JSON_UNESCAPED_SLASHES);
    $productColorsJson = json_encode($productColors, JSON_UNESCAPED_SLASHES);

    echo '<div id="columnchart_values" style="width: 55vw; height: 500px; margin-bottom: 0.2em; border-radius: 0.3em;"></div>';
    echo "<script type='text/javascript'>
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable($chartDataJson);

                // Convert JSON color array to JavaScript array
                var productColors = $productColorsJson;

                var options = {
                    title: 'Productos y sus ventas: quincena del ' + '$date',
                    width: '100%',
                    height: 500,
                    bar: {groupWidth: '95%'},
                    legend: { position: 'none' },
                    annotations: {
                        alwaysOutside: true,
                        textStyle: {
                            fontSize: 12,
                            auraColor: 'none',
                            color: '#FF8656'
                        }
                    },
                    colors: productColors,
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
                chart.draw(data, options);
            }
        </script>";
} else {
    echo "No data available.";
}
?>
```

## Templates

### Date formate
**File** **path:** “backend_db/templates/date_form.php”
This PHP code includes a function from an external file to format the current date. It sets the time zone to 'America/Mexico_City' and retrieves the current date in 'Y-m-d' format. It then uses the formatDate function to format this date and display it within an HTML container. The formatted date is shown in an element inside a container with the identifier “date_container.”

```PHP
<?php
// Include the function
include_once './app/utils/currentDate.php';
// set the time zone...
date_default_timezone_set('America/Mexico_City');

// Get the current date
$currentDate = date('Y-m-d');
$formattedDate = formatDate($currentDate);
?>
<!--This is the form that retains the date to send it to the function (currentDate)-->
<div id="date_container">
    <h3><?php echo $formattedDate; ?></h3>
</div>
```

### header

```PHP
<!DOCTYPE html>
<html lang="en">
<head>
    <!--TODO: poner el SEO-->
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
```

### Footer

```PHP
    <footer class="navbar">
        <div id="copy_brand_container" class="container-fluid">
            <a id="a_brand" class="navbar-brand" href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/3161/3161158.png" alt="Logo" width="80" height="74" class="d-inline-block align-text-top">
                Ventas DB
            </a>
            <div id="copy_conteiner">
                <span>
                    © 2024-07-10 Copyright Backend Team
                </span>
            </div>
        </div>
    </footer>

    <!--This is our script-->
    <script src="<?php echo BASE_URL; ?>public/js/script.js"></script>
    <!--cdn de boostrap, scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
```

## Deployment Process of the Dashboard on a Host
The deployment process for a web application like this (Dashboard) should not present any challenges; it is similar to any other web application. The steps and the number of steps will depend greatly on the type of host being used, but generally, the process will be straightforward.
In our case, the Dashboard was deployed on Hostinger, due to the simplicity of our project, its development in PHP, and because Hostinger is one of the easiest services to use for deploying projects such as websites or static applications.
First, a subdomain named backend_proyect was created, which creates a new folder with the same name in the root of the public_html folder. The main domain from which this subdomain derives is called abarrotes_universidad.
The second step was to upload all the files to the backend_proyect folder, add the necessary environment variables, and everything was ready. The project is now deployed on the host.

## DataBase and desing pattern

The database we are working with is small, and was created with **Mysql**. It is hosted at hostinger.

The **MVC** desing pattern was used in this project.

## Development team

[![Ricardo Medina's Profile Picture](https://github.com/ramedina98.png?size=100)](https://github.com/ramedina98) [Ricardo Medina](https://github.com/ramedina98)

[![Cynthia's Profile Picture](https://github.com/ferpipipi.png?size=100)](https://github.com/ferpipipi) [Cynthia](https://github.com/ferpipipi)

[![Jennifer Hernández's Profile Picture](https://github.com/jenn8199.png?size=100)](https://github.com/jenn8199) [Jennifer Hernández](https://github.com/jenn8199)

[![Joel Macias's Profile Picture](https://github.com/CuentaEscuela.png?size=10)](https://github.com/CuentaEscuela) [Joel Macias](https://github.com/CuentaEscuela)

## Contacto

- **Email:** rmedinamartindelcampo@gmail.com