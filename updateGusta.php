 <?php include("classUsuario.php");
   $db_servername = "localhost";
   $db_usuario = "root";
   $db_contrasena = "";
   $dbname = "Article";

   $idArticle = $_POST['idArticulo'];
   $idAutor = $_POST['idAutor'];
   $gusta = $_POST['gusta'];
   try {
      $conn = new PDO("mysql:host=$db_servername;dbname=$dbname", $db_usuario, $db_contrasena);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->exec("SET NAMES 'utf8';");
   } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
   }
   $sql = "SELECT gusta FROM gusta_Articulo WHERE idArticulo = ? and idAutor = ?";
   $stmt = $conn->prepare($sql);

   if($stmt->execute([$idArticle, $idAutor]) == true && $stmt->rowCount() == 1){
      $updateSql = "UPDATE gusta_Articulo SET gusta = ? WHERE idArticulo = ? and idAutor = ?";
      $updateStmt = $conn->prepare($updateSql);
      if($updateStmt->execute([$gusta, $idArticle, $idAutor]))
         echo 1;
      else
         echo 0;
   }
   else{
      $insertSql = "INSERT INTO gusta_Articulo (idAutor, idArticulo, gusta) VALUES (?, ?, ?)";
      $insertStmt = $conn->prepare($insertSql);
      if($insertStmt->execute([$idAutor, $idArticle, $gusta]))
         echo 1 ;
      else
         echo 0;
   }
?>