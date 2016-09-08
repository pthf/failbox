<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
 
//variables POST
$brand = $_POST['other_brand'];
$lower_brand = strtolower($brand);
$capital_brand = ucwords($lower_brand);

if ($capital_brand == "" || $capital_brand == NULL) {

	echo "<span style='color:red'>Ingrese una marca!!</span><br>";

} else {

	$query = "SELECT Marca FROM Marcas WHERE Marca = '".$capital_brand."'"; 
	$result_query = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_num_rows($result_query);

	if ($row == 1) { 

		echo "<span style='color:red'>Ya existe la marca, intente de nuevo!!</span><br>";

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

		$nombre_brand = scanear_string(strtolower($capital_brand));
		$nombre_brand = explode(' ', $nombre_brand);
		$nombres_filters = array_filter($nombre_brand);
		$nombre_brand = implode('-', $nombres_filters);

		//registra los categorias de los productos
		$sql = "INSERT INTO Marcas (IdMarca, Marca, RouteMarca) VALUES ('', '".$capital_brand."', '".$nombre_brand."')";
		$resultado_consulta_mysql = mysql_query($sql,Conectar::con()) or die(mysql_error());

	} 

}

include('consult_brand.php');
?>