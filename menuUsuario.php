<?php
include ("classUsuario.php");
session_start();
$usuario = $_SESSION["usuario"]->getName();
$edad = $_SESSION["usuario"]->getAge();
?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
	<div class="card text-center">
		<p class="card-text">Hola <?php  echo $usuario ?>, bienvenido al sistema c:</p>
		<h1 class="card-header bg-primary text-white">Menu Principal</h1>
	    <div class="card-body">
	    	<ul class="list-group">
				<a class="card-link" href="buscaArticulo.php">Ver</a><br>
				<a class="card-link" href="buscaParaEdicion.php">
					Editar
					<!--?php 
					if($edad >= 18)
						echo "Editar";
					?-->
				</a><br>
		    	<a class="card-link" href="crearArticulo.php">
					 Crear
					<!--?php 
						if($edad >= 18)
							echo "Crear";
					?-->
				</a><br>
		    	<div class="card-footer text-muted">
  				<a class="text-muted" href="cerrarSesion.php">Salir</a>
  				</div>
	    	</ul>
	    </div>
	</div>
</body>
</html>