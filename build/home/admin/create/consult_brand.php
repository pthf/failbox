<?php 
if(!isset($_SESSION['idAdmin']))
	header("Location: index.php");
require_once("../db/conexion.php");
 
//consulta todos los empleados
$query = "SELECT * FROM Marcas ORDER BY Marca ASC";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
 	echo "<select id='brand' name='brand' class='form-control' required>";
	echo "<option disabled selected value=''>Selecciona..</option>";
while($fila=mysql_fetch_array($resultado)){
 	echo "<option value='".$fila['IdMarca']."'>".$fila['Marca']."</option>";
}
  	echo "</select>";