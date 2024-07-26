<?php
//This element helps us to print the information obtained from the database in the pie chart...

// Check if $data is an array
if (is_array($data)) {
    //TODO: corregir esto, hay que hacer una funcion que me saque la quincena de la que saca los datos...
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