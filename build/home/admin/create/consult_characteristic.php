<?php 
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
 
$query = "SELECT * FROM Caracteristicas ORDER BY NombreCaracteristica ASC";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
  echo "<select id='characteristic' name='type_characteristic' class='form-control' required>";
  echo "<option disabled selected value=''>Selecciona..</option>";
while($fila=mysql_fetch_array($resultado)){ 
  echo "<option value='".$fila['IdCaracteristica']."'>".$fila['NombreCaracteristica']."</option>";
}
  echo "</select>";