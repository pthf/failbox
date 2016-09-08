<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['carrito'])) {
	$total_cost_shipping = 0;
	for ($i=0; $i < count($_SESSION['carrito']); $i++) { 
		$total_cost_shipping = $total_cost_shipping + $_SESSION['carrito'][$i]["costo_envio"];
	}
	print_r(json_encode($total_cost_shipping));
}
?>