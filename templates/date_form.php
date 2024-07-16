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