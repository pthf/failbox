<?php
	require_once("../admin/db/conexion.php");
	
	$email = $_POST['email'];
  
	$query = "SELECT * FROM Newsletter WHERE Email = '".$email."'";
	$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
	$row = mysql_num_rows($resultado);

	if ($row == 0) {
		$query1 = "INSERT INTO Newsletter VALUES(null,'".$email."')";
		$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
	} else {
		echo -1;
	}
?>
