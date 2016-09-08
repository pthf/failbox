<?php
session_start();
require_once("db/conexion.php");
class usuario
{
	public function nueva_sesion()
	{
		//recogemos las variables post del formulario
		$nombre = $_POST['username'];
		$password = $_POST['password'];
		//realizamos la consulta sql 
		//colocamos script_tags para eliminar las etiquetas html y php, de alguno que tenga
	    $query = "SELECT * FROM Usuarios WHERE Nombre='".strip_tags($nombre)."' AND Password='".strip_tags($password)."';";
		//ejecutamos la consulta y guardamos el resultado en la variable resultado
		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
		if ($reg=mysql_num_rows($resultado) == 1) {
			//defino una sesion y guardo datos 
			$_SESSION["autentificado"] = "SI"; 
   			header ("Location: listProducts.php");
		} else {
			//si no existe se manda al index del login con el parametro de usuario
   			header("Location: index.php?usuario=no_existe"); 
		}
	}
}
?>