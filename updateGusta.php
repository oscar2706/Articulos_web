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
      {
         $temaArticuloSql = "SELECT idTema FROM articulo WHERE idArticulo = ?";
         $temaArticuloStmt = $conn->prepare($temaArticuloSql);
         $temaArticuloStmt->execute([$idArticle]);
         $resultadoTemaArticuloStmt = $temaArticuloStmt->fetch(PDO::FETCH_OBJ);

         $meGustaPorTemaSql = "SELECT cantidadGusta FROM tema WHERE idTema = ?";
         $meGustaPorTemaStmt = $conn->prepare($meGustaPorTemaSql);
         $meGustaPorTemaStmt->execute([$resultadoTemaArticuloStmt->idTema]);
         $resultadoMeGustaPorTemaStmt = $meGustaPorTemaStmt->fetch(PDO::FETCH_OBJ);

         if($gusta == 1)
         {
            $nuevaCantidadMeGusta = $resultadoMeGustaPorTemaStmt->cantidadGusta + 2;
         }
         else
         {
            $nuevaCantidadMeGusta = $resultadoMeGustaPorTemaStmt->cantidadGusta - 2;
         }

         $nuevoMeGustaPorTemaSql = "UPDATE tema SET cantidadGusta = ? WHERE idTema = ?";
         $nuevoMeGustaPorTemaStmt = $conn->prepare($nuevoMeGustaPorTemaSql);
         $nuevoMeGustaPorTemaStmt->execute([$nuevaCantidadMeGusta, $resultadoTemaArticuloStmt->idTema]);

         echo 1;
      }
      else
         echo 0;
   }
   else{
      $insertSql = "INSERT INTO gusta_Articulo (idAutor, idArticulo, gusta) VALUES (?, ?, ?)";
      $insertStmt = $conn->prepare($insertSql);
      if($insertStmt->execute([$idAutor, $idArticle, $gusta]))
      {
         $temaArticuloSql = "SELECT idTema FROM articulo WHERE idArticulo = ?";
         $temaArticuloStmt = $conn->prepare($temaArticuloSql);
         $temaArticuloStmt->execute([$idArticle]);
         $resultadoTemaArticuloStmt = $temaArticuloStmt->fetch(PDO::FETCH_OBJ);

         $meGustaPorTemaSql = "SELECT cantidadGusta FROM tema WHERE idTema = ?";
         $meGustaPorTemaStmt = $conn->prepare($meGustaPorTemaSql);
         $meGustaPorTemaStmt->execute([$resultadoTemaArticuloStmt->idTema]);
         $resultadoMeGustaPorTemaStmt = $meGustaPorTemaStmt->fetch(PDO::FETCH_OBJ);

         if($gusta == 1)
         {
            $nuevaCantidadMeGusta = $resultadoMeGustaPorTemaStmt->cantidadGusta + 1;
         }
         else
         {
            $nuevaCantidadMeGusta = $resultadoMeGustaPorTemaStmt->cantidadGusta - 1;
         }

         $nuevoMeGustaPorTemaSql = "UPDATE tema SET cantidadGusta = ? WHERE idTema = ?";
         $nuevoMeGustaPorTemaStmt = $conn->prepare($nuevoMeGustaPorTemaSql);
         $nuevoMeGustaPorTemaStmt->execute([$nuevaCantidadMeGusta, $resultadoTemaArticuloStmt->idTema]);

         echo 1 ;
      } 
      else
         echo 0;
   }
?>