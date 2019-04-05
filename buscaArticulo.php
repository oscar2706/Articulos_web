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
	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 $conn->exec("SET NAMES 'utf8';");
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
$sql = "SELECT * FROM Articulo WHERE idAutor = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION["usuario"]->getId()]);

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$art_id = $row->idArticulo;
	$art_titulo = $row->titulo;
	$art_subt = $row->subtitulo;
	$art_cont = $row->contenido;
    $art_fecha = $row->fecha;
    $art_idTema = $row->idTema;
    $art_gusta = -1; //TODO: Realizar la consulta para saber el estado de me gusta respecto al usuario
	$articulo = new Articulo($art_id, $art_titulo, $art_subt, $art_cont, $art_fecha, $art_idTema, $art_gusta);
	$ListOfArticulos[] = $articulo;
}
$_SESSION["articulos"] = $ListOfArticulos;
$arregloArticulos = $_SESSION["articulos"];

$sqlTodos = "SELECT * FROM Articulo";
$stmtTodos = $conn->prepare($sqlTodos);
$stmtTodos->execute();

while ($_row = $stmtTodos->fetch(PDO::FETCH_OBJ)) {
	$art_id = $_row->idArticulo;
	$art_titulo = $_row->titulo;
	$art_subt = $_row->subtitulo;
	$art_cont = $_row->contenido;
    $art_fecha = $_row->fecha;
    $art_idTema = $_row->idTema;
    $art_gusta = -1;
	$articulo = new Articulo($art_id, $art_titulo, $art_subt, $art_cont, $art_fecha, $art_idTema, $art_gusta);
	$allArticles[] = $articulo;
}
$allArticles[0]->saveInXmlFile($allArticles);
?>

<!DOCTYPE html>
<html lang="es_MX">

<head>
    <title>Articulos del autor</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>

<body class="m-4">
    <a href="recomendaciones.php">
        <button class="btn btn-primary"> Recomendaciones </button>
    </a>
    <br>
    <form class="form-group m-2" action="verArticulo.php" method="GET">
        <label>
            <span>Introduce el id:</span>
            <input class="form-control" type="text" name="id_articulo">
        </label>
        <br>
        <input class="btn btn-primary" type="submit" value="Ver articulo">
        <br>
    </form>
    <table class="table col-4">
        <thead class="thead-light">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Titulo</th>
                <th scope="col">Subtitulo</th>
            </tr>
        </thead>
        <tbody>
            <?php 
				for ($x = 0; $x < sizeof($arregloArticulos); $x++) {
					?>
            <tr>
                <th scope="row"><?php echo $ListOfArticulos[$x]->getId(); ?></th>
                <td><?php echo $ListOfArticulos[$x]->getTitulo(); ?></td>
                <td><?php echo $ListOfArticulos[$x]->getSubtitulo(); ?></td>
            </tr>
            <?php 
			}
			?>
        </tbody>
    </table>
    <a href="articulosUsuario.php">
        <button class="btn btn-primary"> Ver todos </button>
    </a>
    <a class="text-secondary" href="menuUsuario.php?">Regresar</a>
</body>
</html> 