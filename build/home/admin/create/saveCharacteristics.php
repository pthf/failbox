<?php
session_start();
	if(!isset($_SESSION['idAdmin']))
		header("Location: index.php");
	require_once("../db/conexion.php");
	require_once("../class/class.php");
	//Creamos el objeto de la Clase Products
	$insert_characteristics = new Products();

	//Mandamos los parametros a la funcion donde se insertan los datos
	$insert_characteristics->save_characteristics($_GET['id'],$_POST["type_characteristic"],$_POST["characteristic"]);
?>