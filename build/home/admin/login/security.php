<?php 
//Inicio la sesión 
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["idAdmin"] != "SI") { 
    //si no existe, envio a la página de autentificacion 
    header("Location: http://localhost/www/FAILBOX/build/admin/"); 
    //ademas salgo de este script 
    exit(); 
} 
?>