<?php 
session_start();
if (isset($_SESSION['carrito'])) {
	$productos = array();
	foreach ($_SESSION['carrito'] as $key => $value) {
		$arreglo = $_SESSION['carrito'][$key]['cantidad'].' : '.$_SESSION['carrito'][$key]['nombre_producto'].' : $'.(number_format($_SESSION['carrito'][$key]['precio'], 2, '.', ''));
		array_push($productos, $arreglo);
	}
	print_r(json_encode($productos));
}
?>