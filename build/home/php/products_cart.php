<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['carrito'])) {
	print_r(json_encode($_SESSION['carrito']));
}

?>