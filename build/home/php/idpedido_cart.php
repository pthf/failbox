<?php 
session_start();
// include('delete_session_cart.php'); 
if (isset($_SESSION['id_pedido'])) {
	print_r(json_encode($_SESSION['id_pedido']));
}

?>