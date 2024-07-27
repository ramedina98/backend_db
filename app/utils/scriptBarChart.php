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