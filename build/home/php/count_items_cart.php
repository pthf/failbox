<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['carrito'])) {
	$total_items_shipping = 0;
	foreach ($_SESSION['carrito'] as $key => $value) {
		$total_items_shipping = $total_items_shipping + $value['cantidad'];
	}
	print_r(json_encode($total_items_shipping));
}
?>