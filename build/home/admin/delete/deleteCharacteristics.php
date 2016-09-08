<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");

$id_product = $_GET['id'];
$id_characteristic = $_GET['caracteristica'];

$sql_charact = "DELETE FROM Productos_has_Caracteristicas WHERE Productos_IdProducto = '".$id_product."' AND Caracteristicas_IdCaracteristica = '".$id_characteristic."'";
	$res_charact = mysql_query($sql_charact,Conectar::con()) or die(mysql_error());


echo"
	<script type='text/javascript'>
		window.location='../create/createCharacteristics.php?id=$id_product';
	</script>";

?>