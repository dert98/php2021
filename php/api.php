<?php
// Content Type JSON
header("Content-type: application/json");

// Database connection
include("dbml.php"); 
  $dbml = new dbManager("productos","idProducto");
// Read data from database
$action = "read";
if (isset($_GET["action"])) {
  $action = $_GET["action"];
}
if ($action == "readp") {
  $dbml->select();
  $reg = $dbml->getArray();
  $res["productos"] = $reg;
}
if ($action == "readu") {
  $dbml = new dbManager("usuarios","idUsuario");
  $dbml->select();
  $reg = $dbml->getArray();
  $res["usuarios"] = $reg;
}
if ($action == "readc") {
  $dbml = new dbManager("categorias_productos","idCategoriaProducto");
  $dbml->select();
  $reg = $dbml->getArray();
  $res["categorias"] = $reg;
}
// Close database connection
$dbml->close();

// Print json encoded data
echo json_encode($res);
die();
?>
    