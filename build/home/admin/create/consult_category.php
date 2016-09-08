<?php 
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");

$query = "SELECT * FROM Categorias ORDER BY Categoria ASC";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
 	echo "<select id='selectCategory' name='category' class='form-control' required>";
	echo "<option disabled selected value=''>Selecciona..</option>";
while($row=mysql_fetch_array($resultado)){
 	echo "<option value='".$row['IdCategoria']."' name='".$row['Categoria']."'>".$row['Categoria']."</option>";
}
  	echo "</select>";
?>


