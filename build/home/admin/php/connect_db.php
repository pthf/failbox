<?php

	$mysql_host = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_database = "failbox";
	$link = "";

	// $mysql_host = "localhost";
	// $mysql_user = "root";
	// $mysql_password = "j8ykhpLukx";
	// $mysql_database = "failbox";
	// $link = "";

	function connect_base_de_datos (){
		$GLOBALS['link'] = mysql_connect($GLOBALS['mysql_host'],$GLOBALS['mysql_user'],$GLOBALS['mysql_password'])
			or die('No se pudo conectar: '.mysql_error());
		mysql_select_db($GLOBALS['mysql_database']) or die('Error al conectar a la base de datos: '.$GLOBALS['mysql_database']);
	}

	function close_database(){
		mysql_close($GLOBALS['link']);
	}

?>
