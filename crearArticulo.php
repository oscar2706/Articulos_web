<?php 
include("classArticulo.php");
include("classUsuario.php");
session_start();
$db_servername = "localhost";
$db_usuario = "root";
$db_contrasena = "";
$dbname = "Article";
try {
	$conn = new PDO("mysql:host=$db_servername;dbname=$dbname", $db_usuario, $db_contrasena);
	    // set the PDO error mode to exception
	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 $conn->exec("SET NAMES 'utf8';");
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
$sql = "SELECT nombre FROM Tema";
$stmt = $conn->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$tema = $row->nombre;
	$temas[] = $tema;
}

?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
	<title>Nuevo articulo</title>
	<meta charset="utf-8">
	<!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
	<div class="m-2">
		<h1 class="p-3 mb-2 bg-light text-dark">Crear articulo</h1>
		<form class="form-group" action="registraArticulo.php" method="POST">
			<label>
				<span>Titulo</span>
				<input class="form-control" type="text" name="titulo">
			</label>
			<br>
			<label>
				<span>Subtitulo</span>
				<input class="form-control" type="text" name="subtitulo">
			</label>
			<br>
			<label>
				<span>Contenido</span>
				<input class="form-control" type="text" name="contenido">
			</label>
			<br>
			<label>
					<span>Tema</span>
					<select name="tema" class="form-control">
					<?php 
						for ($x = 0; $x < sizeof($temas); $x++) {
					?>
						<option value="<?php echo $x+1; ?>"> <?php echo $temas[$x]; ?> </option>
					<?php 
						}
					?>
					</select>
				</label>
				<br>
			<input class="btn btn-primary" type="submit" value="Registrar articulo">
		</form>
		<a class="text-secondary" href="menuUsuario.php?">Regresar</a>
	</div>
</body>
</html>