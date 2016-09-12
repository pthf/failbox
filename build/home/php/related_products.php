<?php
session_start();
require_once("../admin/db/conexion.php");

$productos = array();
foreach ($_SESSION['carrito'] as $key => $value) {
    echo "<pre>";
    $query = "SELECT * FROM Productos p INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca WHERE p.Estatus = 'Activo' AND p.Stock > 0 AND p.Categorias_IdCategoria = '".$_SESSION['carrito'][$key]['id_categoria']."'";
    $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
    $row = mysql_fetch_array($resultado);
    print_r($row);
    echo "</pre>";
}

// print_r(json_encode($productos));

exit();
    $query = "SELECT * FROM Productos p INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca WHERE Destacado = 'SI' AND Estatus = 'Activo' AND Stock > 0 AND Categorias_IdCategoria = '".$_SESSION['carrito']."'";
    $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

    $productos = array();
    while ($row = mysql_fetch_array($resultado)) {

        $array_images = explode(',', $row['Image']);

        $producto = array(
                    "id" => $row['IdProducto'],
                    "name" => $row['NombreProd'],
                    "url" => $row['RouteProd'],
                    "descripcion" => $row['Descripcion'],
                    "marca" => $row['Marca'],
                    "price" => $row['PrecioLista'],
                    "not_price" => $row['PrecioFailbox'],
                    "image" => $array_images[0],
                    "images_slider" => $array_images,
                    "paypal" => $row['urlPaypal'],
        );
        //$productos[] = $producto;
        array_push($productos, $producto);
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($productos as $key => $value) {
        array_push($arrayGroup, $value);
        if($counter==3){
            array_push($arrayList, $arrayGroup);
            $counter = 0;
            unset($arrayGroup);
            $arrayGroup = array();
        }else{
            $counter++;
        }
    }

    if(count($arrayGroup)>0){
        array_push($arrayList, $arrayGroup);
        $counter = 0;
        unset($arrayGroup);
        $arrayGroup = array();
    }

    $items = array();
    for ($i=0; $i < count($arrayList); $i++) {
        $item = array(
            "group" => $i,
            "data" => $arrayList[$i],
        );
        array_push($items, $item);
    }
    // print_r(json_encode($items));

?>
