<?php
function formatDate($fecha) {
    try {
        $dateTime = new DateTime($fecha, new DateTimeZone('America/Mexico_City'));
        return $dateTime->format('d-m-Y');
    } catch (Exception $e) {
        return 'Fecha inválida'; 
    }
}
?>