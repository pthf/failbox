<?php 
session_start();
if (isset($_SESSION['carrito'])) {
	$total_price = 0;
	$costo_envio = 0;
	foreach ($_SESSION['carrito'] as $key => $value) {
		$total_price = $total_price + $_SESSION['carrito'][$key]["sub_total"];
	 	$costo_envio = $costo_envio + $_SESSION['carrito'][$key]['costo_envio'];
	 	$total = $total_price + $costo_envio;
	}
	if (isset($_SESSION['descuento'])) {
		if ($_SESSION['descuento-aplicado'] == 1) {
			$descuento = $total_price * $_SESSION['descuento'];
            $precio_descuento = $total_price - $descuento;
            $_SESSION['total_carrito'] = $precio_descuento + $costo_envio;
		} 
		$arrayName = array(
			'costo_envio' => $costo_envio,
			'total_price' => $total_price,
			'total' =>	$total,
			'total_descuento' => $_SESSION['total_carrito'],
			'descuento' => $_SESSION['descuento']
		);
	} else {
		$arrayName = array(
			'costo_envio' => $costo_envio,
			'total_price' => $total_price,
			'total' =>	$total,
			'total_descuento' => $total
		);
	}
	print_r(json_encode($arrayName));
}
?>