<?php
	if(!isset($_SESSION['idAdmin']))
    	header("Location: index.php");
  	require_once("../db/conexion.php");
	//Creamos el objeto de la Clase Products
	$insert_changes = new Products();
	
	//Arreglo de categorias
	$array_categorys = $_POST['categorys'];
	
	//Se concatena el arreglo de las imagenes en una variable
	$array_images = $_POST["images"];
	$images = implode("|", $array_images);

	//Mandamos los parametros a la funcion donde se insertan los datos
	$insert_changes->save_changes($_GET['id'],$_GET['categoria'],$_GET['marca'],$_POST["name_product"],$_POST["description"],$array_categorys,$_POST['brand'],$_POST["stocks"],$_POST['price'],$_POST['discount'],$_POST['model'],$_POST['sku'],$_POST['estatus'],$images);

?>