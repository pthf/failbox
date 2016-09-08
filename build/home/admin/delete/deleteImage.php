<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");

$id_product = $_GET['id'];
$id_imagen = $_GET['imagen'];

$sql_charact = "DELETE FROM Productos_has_Imagenes WHERE IdImagen = '".$id_imagen."'";
	$res_charact = mysql_query($sql_charact,Conectar::con()) or die(mysql_error());

$query = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$id_product."'";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

$array_images = array();
while ($row = mysql_fetch_array($resultado)) {
	array_push($array_images, $row['NombreImagen']);
}

$imagenes = implode(',', $array_images);
$query3 = "UPDATE Productos SET Image = '".$imagenes."' WHERE IdProducto = '".$id_product."'";
    $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());

echo"
	<script type='text/javascript'>
		window.location='../create/createCharacteristics.php?id=$id_product';
	</script>";

?>