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