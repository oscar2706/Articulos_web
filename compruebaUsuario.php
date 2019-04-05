<?php
include ("classUsuario.php");
$db_servername = "localhost";
$db_usuario = "root";
$db_contrasena = "";
$dbname = "Article";

$usr_nombre=$_POST['nombre'];
$usr_password=$_POST['contraseña'];
try {
	$conn = new PDO("mysql:host=$db_servername;dbname=$dbname", $db_usuario, $db_contrasena);
	    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
$sql = "SELECT * FROM Autor WHERE nombre = ? AND contrasena = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$usr_nombre, $usr_password]);

if ($row = $stmt->fetch(PDO::FETCH_OBJ)){
	$user_id = $row->idAutor;
	$user_name = $row->nombre;
	$user_contrasena = $row->contrasena;
	$user_fechaNacimiento = $row->fechaNacimiento;
	$activeUser = new Usuario($user_id, $user_name, $user_contrasena, $user_fechaNacimiento);
	//$activeUser->printData();
	session_start();
	$_SESSION["usuario"] = $activeUser;
	$_SESSION["usuario"]->printData();
	header('Location: menuUsuario.php');
}
else{
	header('Location: index.html');
}
?>