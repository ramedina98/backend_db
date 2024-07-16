<?php
    /**
     * Se esta agregando de manera dinamica el header...
     */
    include './templates/header.php';
?>

<!--TODO: acomodar esta parte-->
<main>
    <!--TODO: aqui es donde iria el contenido de la pagina, las graficas y demás-->
    <section class="main_graph_container">
        <div class="title_form">
            <div class="graph_title_container">
                <h3>Grafica de Usuario Producto</h3>
            </div>
            <?php include './templates/date_form.php'?>
        </div>
        <!--Here we have the graph-->
        <div class="graph_container">
            <!--TODO: pegar lo demas del escript-->
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
            <!--TODO: pegar lo demas del escript-->
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
    </section>

    <!--TODO: aquí debe de ir el escript-->
</main>

<?php
    /**
     * Se esta agregando de manera dinamica el footer...
     */
    include './templates/footer.php';
?>