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
//se seleccionan todos los artículos
$sql = "SELECT * FROM Articulo";
$stmt = $conn->prepare($sql);
$stmt->execute();

//no se necesita porque siempre checas con la primera posición del arreglo
//$indice = 0;
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$art_id = $row->idArticulo;
	$art_titulo = $row->titulo;
	$art_subt = $row->subtitulo;
	$art_cont = $row->contenido;
    $art_fecha = $row->fecha;
    $art_idTema = $row->idTema;
    $art_gusta = -1;

    $gustaSql = "SELECT gusta FROM gusta_Articulo WHERE idArticulo = ? and idAutor = ?";
    $gustaStmt = $conn->prepare($gustaSql);
    if($gustaStmt->execute([$art_id, $_SESSION["usuario"]->getId()]) == true && $gustaStmt->rowCount() == 1){
        $rowGusta = $gustaStmt->fetch();
        if( $rowGusta[0] == 1)
            $art_gusta = 1;
        else
            $art_gusta = 0;
    }
	$articulo = new Articulo($art_id, $art_titulo, $art_subt, $art_cont, $art_fecha, $art_idTema, $art_gusta);
    $ListOfArticulos[] = $articulo;
    //$indice++;
}
$_SESSION["articulos"] = $ListOfArticulos;
$arregloArticulos = $_SESSION["articulos"];
//$arregloArticulos[0]->saveInXmlFile($ListOfArticulos);
?>


<!DOCTYPE html>
<html lang="es_MX">

<head>
    <title>Articulos del autor</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstarp -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="controlRecomendaciones.js"></script>
</head>

<body class="m-4">
    <table class="table col-10 table-striped">
        <thead class="thead-light">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Titulo</th>
                <th scope="col">Subtitulo</th>
                <th scope="col">Contenido</th>
                <th scope="col">Gusta</th>
            </tr>
        </thead>
        <tbody id="tablaArticulos">
            <?php 
				for ($x = 0; $x < sizeof($arregloArticulos)-(sizeof($arregloArticulos)*.3); $x++) {
					?>
            <tr>
                <th scope="row" id="<?php echo $ListOfArticulos[$x]->getId(); ?>">
                    <?php echo $ListOfArticulos[$x]->getId(); ?>
                </th>
                <td><?php echo $ListOfArticulos[$x]->getTitulo(); ?></td>
                <td><?php echo $ListOfArticulos[$x]->getSubtitulo(); ?></td>
                <td><?php echo $ListOfArticulos[$x]->getContenido(); ?></td>
                <td>
                   <button 
                    class="btn <?php if($ListOfArticulos[$x]->getGusta() == 1) 
                                    echo 'btn-primary';
                                else 
                                    echo 'btn-secondary';
                                ?>" 
                    id="<?php echo $x;?>"
                    onclick="modificaMeGusta(<?php echo $_SESSION["usuario"]->getId(); ?>, <?php echo $ListOfArticulos[$x]->getId(); ?>, 'gusta', '<?php echo $x?>')">
                    👍🏻
                    </button>
                    <button 
                    class="btn <?php if($ListOfArticulos[$x]->getGusta() == 0) 
                                    echo 'btn-primary';
                                else 
                                    echo 'btn-secondary';
                                ?>" 
                    id="<?php echo $x;?>" 
                    onclick="modificaMeGusta(<?php echo $_SESSION["usuario"]->getId(); ?>, <?php echo $ListOfArticulos[$x]->getId(); ?>, 'noGusta', '<?php echo $x?>')">
                    👎🏻
                    </button>
                </td>
            </tr>
            <?php 
			}
			?>
        </tbody>
    </table>
    <button id="btnNuevosArticulos">Nuevos Artículos</button><br>
    <a class="text-secondary" href="buscaArticulo.php?">Regresar</a>
    
    <script>
        $(document).ready(function(){
            $("#btnNuevosArticulos").click(function(){
                var noCategoria = 0;
                var registro;

                <?php 
				    for ($x = 1+intval(sizeof($arregloArticulos)-(sizeof($arregloArticulos)*.3)); $x < sizeof($arregloArticulos); $x++) {
                        $bandera = 0;
                        $categoriasFavoritasSql = "SELECT idTema FROM tema GROUP BY idTema ORDER BY cantidadGusta desc LIMIT 3";
                        $categoriasFavoritasStmt = $conn->prepare($categoriasFavoritasSql);
                        $categoriasFavoritasStmt->execute();

                        while ($nombresCategorias = $categoriasFavoritasStmt->fetch(PDO::FETCH_OBJ)) {
                            if($ListOfArticulos[$x]->getIdTema() == $nombresCategorias->idTema)
                            {
                                $bandera = 1;
                                break;
                            }
                        }

                        if($bandera == 1)
                        {
                ?>
                registro = " \
                <tr> \
                    <th scope=\"row\" id=\"<?php echo $ListOfArticulos[$x]->getId(); ?>\">\
                        <?php echo $ListOfArticulos[$x]->getId(); ?> \
                    </th> \
                    <td><?php echo $ListOfArticulos[$x]->getTitulo(); ?></td> \
                    <td><?php echo $ListOfArticulos[$x]->getSubtitulo(); ?></td> \
                    <td><?php echo $ListOfArticulos[$x]->getContenido(); ?></td> \
                    <td> \
                    <button \
                    class=\"btn <?php if($ListOfArticulos[$x]->getGusta() == 1) 
                                    echo 'btn-primary'; 
                                else 
                                    echo 'btn-secondary'; 
                                ?>\" \
                    id=\"<?php echo $x;?>\" \
                    onclick=\"modificaMeGusta(<?php echo $_SESSION["usuario"]->getId(); ?>, <?php echo $ListOfArticulos[$x]->getId(); ?>, 'gusta', '<?php echo $x?>')\"> \
                    👍🏻 \
                    <button \
                    class=\"btn <?php if($ListOfArticulos[$x]->getGusta() == 0) 
                                    echo 'btn-primary'; 
                                else 
                                    echo 'btn-secondary'; 
                                ?>\" \
                    id=\"<?php echo $x;?>\" \
                    onclick=\"modificaMeGusta(<?php echo $_SESSION["usuario"]->getId(); ?>, <?php echo $ListOfArticulos[$x]->getId(); ?>, 'noGusta', '<?php echo $x?>')\"> \
                    👎🏻 \
                    </button> \
                    </td> \
                </tr> \
                ";
                    
                $("#tablaArticulos").append(registro);

                <?php 
                    }
                }
			    ?>

                $("#btnNuevosArticulos").hide();
            })

            $("button:odd").click(function(){
                var buttonId = this.id;
                var idArt = $("th[id]").eq(buttonId).attr('id');
                var idUser = <?php echo $_SESSION["usuario"]->getId();?>;
                var gusta = 0;
                var claseBoton = this.className;
                //alert("No Gusta "+ buttonId + ", idArticulo:" +idArt);
                
                //alert("Clase del boton: " + claseBoton);

                if(claseBoton == "btn btn-secondary")
                {
                    $.ajax({
                    url:'updateGusta.php',
                    method:'POST',
                    data:{
                        idArticulo:idArt,
                        idAutor:idUser,
                        gusta: gusta
                    },
                    success:function(response){
                        if(response == 1){
                            alert("Gusto actualizado " + response);
                            $("button:odd").eq(buttonId).removeClass('btn-secondary');
                            $("button:odd").eq(buttonId).addClass('btn-primary');
                            $("button:even").eq(buttonId).removeClass('btn-primary');
                            $("button:even").eq(buttonId).addClass('btn-secondary');
                        }
                        else{
                            alert("Hubo un error " + response);
                        }             
                    }
                });
                }
            });

            $("button:even").click(function(){
                var buttonId = this.id;
                var idArt = $("th[id]").eq(buttonId).attr('id');
                //var idArt = 7;
                var idUser = <?php echo $_SESSION["usuario"]->getId();?>;
                var gusta = 1;
                var claseBoton = this.className;
                //alert("No Gusta "+ buttonId + ", idArticulo:" +idArt);
                
                //alert("Clase del boton: " + claseBoton);

                if(claseBoton == "btn btn-secondary")
                {
                    $.ajax({
                    url:'updateGusta.php',
                    method:'POST',
                    data:{
                        idArticulo:idArt,
                        idAutor:idUser,
                        gusta: gusta
                    },
                    success:function(response){
                        if(response == 1){
                            alert("Gusto actualizado " + response);
                            $("button:even").eq(buttonId).removeClass('btn-secondary');
                            $("button:even").eq(buttonId).addClass('btn-primary');
                            $("button:odd").eq(buttonId).removeClass('btn-primary');
                            $("button:odd").eq(buttonId).addClass('btn-secondary');
                        }
                        else{
                            alert("Hubo un error " + response);
                        }
                    }
                });
                }
            });

        });
        </script>
</body>
</html>