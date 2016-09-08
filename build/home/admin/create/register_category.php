<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
 
//variables POST
  var_dump($_GET['other_category']);
  exit();
$category = $_POST['other_category'];
$lower_category = strtolower($category);
$capital_category = ucwords($lower_category);

if ($capital_category == "" || $capital_category == NULL) {

	echo "<span id='result_subcategory' style='color:red'>Ingrese una categoria!!</span><br>";

} else {

	$query = "SELECT Categoria FROM Categorias WHERE Categoria = '".$capital_category."'"; 
	$result_query = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_num_rows($result_query);

	if ($row == 1) { 

		echo "<span class='result_subcategory' style='color:red'>Ya existe la categoria, intente de nuevo!!</span><br>";


	} else { 

		function scanear_string($string)
		{
		 
		    $string = trim($string);
		 
		    $string = str_replace(
		        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ñ', 'Ñ', 'ç', 'Ç'),
		        array('n', 'N', 'c', 'C',),
		        $string
		    );
		 
		    //Esta parte se encarga de eliminar cualquier caracter extraño
		    $string = str_replace(
		        array('¨', 'º', '-', '~',
		             '#', '@', '|', '!', '"',
		             "·", "$", "%", "&", "/",
		             "(", ")", "?", "'", "¡",
		             "¿", "[", "^", "<code>", "]",
		             "+", "}", "{", "¨", "´",
		             ">", "<", ";", ",", ":",
		             "."),
		        '',
		        $string
		    );
		 
		 
		    return $string;
		}

		$nombre_cat = scanear_string(strtolower($capital_category));
		$nombre_cat = explode(' ', $nombre_cat);
		$nombres_filters = array_filter($nombre_cat);
		$nombre_cat = implode('-', $nombres_filters);


		//registra las categorias de los productos
		$sql = "INSERT INTO Categorias (IdCategoria, Categoria, RouteCategoria) VALUES ('', '".$capital_category."', '".$nombre_cat."')";
		$resultado_consulta_mysql = mysql_query($sql,Conectar::con()) or die(mysql_error());
		
	}

}

include('consult_category.php');

?>