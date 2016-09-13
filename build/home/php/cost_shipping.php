<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['carrito'])) {
	$total_cost_shipping = 0;
	foreach ($_SESSION['carrito'] as $key => $value) {
		$total_cost_shipping = $total_cost_shipping + $_SESSION['carrito'][$key]["costo_envio"];
	}
	print_r(json_encode($total_cost_shipping));
}
?>