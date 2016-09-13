<?php 
session_start();
require_once("../admin/db/conexion.php");
if (isset($_SESSION['id_pedido'])) {
	$query = "SELECT * FROM Pedidos WHERE IdPedido = '".$_SESSION['id_pedido']."'";
	$result = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$array = array(
		'IdPedido' => $row['IdPedido'],
		'IdOrden' => $row['OrdenPedido']
	);
	print_r(json_encode($array));
	// print_r(json_encode($_SESSION['id_pedido']));
}

?>