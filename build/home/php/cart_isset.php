<?php 
session_start();
if (isset($_SESSION['carrito'])) {
	$value = 1;
	print_r(json_encode($value));
} else {
	$value = 0;
	print_r(json_encode($value));
}
?>