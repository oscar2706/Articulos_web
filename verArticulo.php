<?php
include("classArticulo.php");
session_start();
$currentId = $_GET['id_articulo'];
$arregloArticulos = $_SESSION["articulos"];
//$articuloSeleccionado =	$arregloArticulos[$currentId];
for ($x = 0; $x < sizeof($arregloArticulos); $x++) {
    $currentId = intval($arregloArticulos[$x]->getId());
    if ($currentId == $_GET['id_articulo']) {
        $articuloSeleccionado =  $arregloArticulos[$x];
        //$articuloSeleccionado->printData();
        //$articuloSeleccionado->saveInArticuloJSON();
    }
}
?>
<!DOCTYPE html>
<html lang="es_MX">

<head>
    <title>Ver articulo</title>
    <meta charset="utf-8">
    <!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>

<body>
    <div class="m-2">
        <p id="idArticulo">
            <?php echo $articuloSeleccionado->getFecha(); ?>
        </p>
        <h1 class="text-primary" id="titulo">
            <?php echo $articuloSeleccionado->getTitulo(); ?>
        </h1>
        <h2 id="subtitulo">
            <?php echo $articuloSeleccionado->getSubtitulo(); ?>
        </h2>
        <p id="contenido">
            <?php echo $articuloSeleccionado->getContenido(); ?>
        </p>
        <a class="text-primary" href="menuUsuario.php">Inicio</a><br>
        <a class="text-secondary" href="buscaArticulo.php">Regresar</a>
    </div>

    <script>
        var myObj;
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //window.alert(this.responseText);
                myObj = JSON.parse(this.responseText);
                //document.getElementById("demo").innerHTML = myObj.nombre;
                //document.getElementById("demo").innerHTML = myObj.peliculas[3].nombre + "," + myObj.peliculas[3].valoracion;
            }
        };
        xmlhttp.open("GET", "articuloSeleccionado.txt", true);
        xmlhttp.send();

        function muestraArticulo() {
            document.getElementById("idArticulo").innerHTML = myObj.id;
            document.getElementById("titulo").innerHTML = myObj.titulo;
            document.getElementById("subtitulo").innerHTML = myObj.subtitulo;
            document.getElementById("contenido").innerHTML = myObj.contenido;
            document.getElementById("pie").innerHTML = myObj.piePagina;
        }

        function ocultaArticulo() {
            document.getElementById("idArticulo").innerHTML = "";
            document.getElementById("titulo").innerHTML = "";
            document.getElementById("subtitulo").innerHTML = "";
            document.getElementById("contenido").innerHTML = "";
            document.getElementById("pie").innerHTML = "";
        }
    </script>
</body>

</html>