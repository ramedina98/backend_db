<?php
// Include the function
include_once './app/utils/currentDate.php';
// Establecer la zona horaria a México
date_default_timezone_set('America/Mexico_City');

// Get the current date
$currentDate = date('Y-m-d');
$formattedDate = formatDate($currentDate);

// If the form is submitted, use the selected date
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['dateInput'])) {
    $selectedDate = $_POST['dateInput'];
    $formattedDate = formatDate($selectedDate);
}
?>
<!--This is the form that retains the date to send it to the function (currentDate)-->
<form method="POST">
    <label for="dateInput">Fecha de los datos</label>
    <input type="date" name="dateInput" id="dateInput" value="<?php echo $formattedDate ?>">
    <button type="submit">Update</button>
</form>