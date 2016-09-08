<?php
	if(!isset($_SESSION['idAdmin']))
    	header("Location: index.php");
  	require_once("../db/conexion.php");
	//Creamos el objeto de la Clase Products
	$insert_product = new Products();

	//Arreglo de categorias
	$array_categorys = $_POST['categorys'];
	
	//Se concatena el arreglo de las imagenes en una variable
	$array_images = $_POST["images"];
	$images = implode("|", $array_images);

	//Mandamos los parametros a la funcion donde se insertan los datos
	$insert_product->save_product($_POST["name_product"],$_POST["description"],$array_categorys,$_POST['brand'],$_POST["stocks"],$_POST['price'],$_POST['discount'],$_POST['model'],$_POST['sku'],$_POST['status'],$images);

?>