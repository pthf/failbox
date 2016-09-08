<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");

$idProvider = $_GET['idProvider'];
$estatus = $_GET['estatus'];

$query = "UPDATE Proveedores SET EstatusProv = '".$estatus."' WHERE idProveedor = '".$idProvider."'";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

echo"
	<script type='text/javascript'>
		window.location='edit_providers.php';
	</script>";

?>