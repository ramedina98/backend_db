<?php
    /**
     * Se esta agregando de manera dinamica el header...
     */
    include './templates/header.php';
?>
<!--TODO: aqui es donde iria el contenido de la pagina, las graficas y demás-->
<section style="width: 100%; height: 100vh; border: 1px solid blue">
    <?php
    // Esta función esta tomando los datos de los productos mediante la variable $data
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    ?>
</section>
<?php
    /**
     * Se esta agregando de manera dinamica el footer...
     */
    include './templates/footer.php';
?>