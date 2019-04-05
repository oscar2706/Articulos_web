<?php
include ("classArticulo.php");
include ("classUsuario.php");

$servername = "localhost";
$usuario = "root";
$contrasena = "";
$dbname = "Article";

$titulo=$_POST['titulo'];
$subtitulo=$_POST['subtitulo'];
$contenido=$_POST['contenido'];
$idTema=$_POST['tema'];

session_start();

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $usuario, $contrasena);
    // set the PDO error mode to exception
	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 $conn->exec("SET NAMES 'utf8';");
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
$sql = "INSERT INTO Articulo (titulo, subtitulo, contenido, fecha, idAutor, idTema)
					VALUES(?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if($stmt->execute([$titulo, $subtitulo, $contenido, date("Y-m-d"), $_SESSION["usuario"]->getId(),$idTema]) === false){
	echo "Error al registrar el articulo";
}else{
	echo "El articulo: ".$titulo.", ha sido registrado";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
	<br>
	<a href="menuUsuario.php">Inicio</a>
	<br>
	<a href="crearArticulo.php">Regresar</a>
</body>
</html>