<?php
file_put_contents("articulos.xml", "");
session_destroy();
header('Location: index.html');
?>