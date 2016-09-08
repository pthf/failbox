<?php
session_start();
if(!isset($_SESSION['idAdmin']))
	header("Location: index.php");
require_once("../db/conexion.php");

$id_producto = $_GET['id'];

	if (isset($_FILES["image"]))
	{
	   $reporte = null;
	     for($x=0; $x<count($_FILES["image"]["name"]); $x++)
	    {
		    $image = $_FILES["image"];
		   	$nombre = $image["name"][$x];
		    //$nombre = date("YmdHis").strtolower($image["name"][$x]);
		    $tipo = $image["type"][$x];
		    $ruta_provisional = $image["tmp_name"][$x];
		    $size = $image["size"][$x];

		    if ($ruta_provisional) {
			    $dimensiones = getimagesize($ruta_provisional);
			    $width = $dimensiones[0];
			    $height = $dimensiones[1];
			}
		    $carpeta = "../images/products/";

		    if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif')
		    {
		        // $reporte .= "<p style='color: red'>ERROR $nombre, el archivo no es una imagen.</p>";
		        $reporte .= 0;
		    }
		    else 
		    {
		    	// $array_images = implode(",", $_FILES["image"]["name"]);

				$src = $carpeta.$nombre;
		        move_uploaded_file($ruta_provisional, $src);

		        $query1 = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto='".$id_producto."' AND NombreImagen='".$nombre."'";
				$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
				$row = mysql_num_rows($resultado1);

				if ($row == 0) { 

					$query2 = "INSERT INTO Productos_has_Imagenes VALUES ('".$id_producto."',null,'".$nombre."')";
					$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
					// echo $query2;
			        // echo "<p style='color: blue'>La imagen $nombre ha sido subida con éxito</p>";
			        echo 1;

			        $query = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$id_producto."'";
					$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

					$array_images = array();
					while ($row = mysql_fetch_array($resultado)) {
						array_push($array_images, $row['NombreImagen']);
					}

					$imagenes = implode(',', $array_images);
					$query3 = "UPDATE Productos SET Image = '".$imagenes."' WHERE IdProducto = '".$id_producto."'";
				    $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
			        // echo $query3;

				} else {

					// echo "<p style='color: red'>Error $nombre, ya existe</p>";
					echo -1;

				}

		    }
	    }
	        echo $reporte;
	}