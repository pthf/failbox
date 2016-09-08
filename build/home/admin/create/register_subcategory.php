<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
var_dump("Entramos");
exit();
//variables POST
$category = $_POST['category'];
$subcategory = $_POST['other_subcategory'];
$lower_subcategory = strtolower($subcategory);
$capital_subcategory = ucwords($lower_subcategory);

if ($capital_subcategory == "" || $capital_subcategory == NULL) {

	echo "<span style='color:red'>Ingrese una subcategoria!!</span><br>";

} else {
	$query = "SELECT Subcategoria FROM Subcategorias WHERE Subcategoria = '".$capital_subcategory."'"; 
	$result_query = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysqli_num_rows($result_query);

	if ($row == 1) { 

		echo "<span style='color:red'>Ya existe la subcategoria, intente de nuevo!!</span><br>";

	} else { 

		//registra las categorias de los productos
		$sql = "INSERT INTO Subcategoria (IdSubcategoria, Subcategoria, Categorias_IdCategoria) VALUES ('','".$capital_subcategory."','".$category."')";
		$resultado = mysql_query($sql,Conectar::con()) or die(mysql_error());
		
	}

}

//include('consult_subcategory.php');

?>