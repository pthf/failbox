<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['carrito'])) {
	$total_not_price = 0;
	$quantity = 0;
	$suma_notprice = 0;
	foreach ($_SESSION['carrito'] as $key => $value) { 
		// $total_not_price = $total_not_price + $_SESSION['carrito'][$key]["precio_lista"];
		$valor = $_SESSION['carrito'][$key]["precio_lista"] * $_SESSION['carrito'][$key]["cantidad"];
		$suma_notprice = $suma_notprice + $valor;
	}
	// print_r($suma);
	print_r(json_encode($suma_notprice));
	// print_r(json_encode($quantity));
	// print_r(json_encode($total_notprice));
}
?>