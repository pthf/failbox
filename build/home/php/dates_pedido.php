<?php
session_start();
require_once("../admin/db/conexion.php");

if (isset($_SESSION['id_pedido'])) {
	$query = "SELECT * FROM DatosEnvios WHERE IdPedido = '".$_SESSION['id_pedido']."'";
	$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_fetch_array($resultado);
	print_r(json_encode($row));
}
?>