<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
 
//variables POST
$characteristic = $_POST['characteristic'];
$lower_characteristic = strtolower($characteristic);
$capital_characteristic = ucwords($lower_characteristic);

if ($capital_characteristic == "" || $capital_characteristic == NULL) {

	echo "<span style='color:red'>Ingrese una caractersitica!!</span><br>";

} else {

	$query = "SELECT NombreCaracteristica FROM Caracteristicas WHERE NombreCaracteristica = '".$capital_characteristic."'"; 
	$result_query = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_num_rows($result_query);

	if ($row == 1) { 

		echo "<span style='color:red'>Ya existe la caracteristica, intente de nuevo!!</span><br>";

	} else { 

		//registra las caracteristicas de los productos
		$sql = "INSERT INTO Caracteristicas (IdCaracteristica, NombreCaracteristica) VALUES ('', '".$capital_characteristic."')";
		$resultado_consulta_mysql = mysql_query($sql,Conectar::con()) or die(mysql_error());

	} 

}

include('consult_characteristic.php');
?>