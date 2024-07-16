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
            <!--TODO: hacer un include php de su script (el script esta en la carpeta utils)-->
            <div id="piechart" style="width: 900px; height: 500px;"></div>
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
            <!--TODO: hacer un include php de su script (el script esta en la carpeta utils)-->
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
    </section>

</main>

<?php
    /**
     * Se esta agregando de manera dinamica el footer...
     */
    include './templates/footer.php';
?>