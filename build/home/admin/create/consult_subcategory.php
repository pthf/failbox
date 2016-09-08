<?php 
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");

$query = "SELECT * FROM Subcategorias";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
 	echo "<select name='subcategory' id='selectSubCategory' class='form-control' required>";
	echo "<option disabled selected>Selecciona..</option>";
while($row=mysql_fetch_array($resultado)){
 	echo "<option value='".$row['IdSubcategoria']."'>".$row['Subcategoria']."</option>";
}
  	echo "</select>";

?>

