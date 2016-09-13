<?php
session_start();
require_once("../admin/db/conexion.php");
if (isset($_SESSION['carrito'])) {
    $array_categories = array();
    foreach ($_SESSION['carrito'] as $key => $value) {
        $query = "SELECT * FROM Productos p INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca WHERE p.Estatus = 'Activo' AND p.Stock > 0 AND p.Categorias_IdCategoria = '".$_SESSION['carrito'][$key]['id_categoria']."'";
        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
        $row = mysql_fetch_array($resultado);
        array_push($array_categories, $row['Categorias_IdCategoria']);
    }
    $array = array_unique($array_categories);
    $array = array_values($array);
    $array_products_related = array();
    for ($i=0; $i < count($array); $i++) { 
        $query1 = "SELECT * FROM Productos p INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca WHERE Estatus = 'Activo' AND Stock > 0 AND Categorias_IdCategoria = '".$array[$i]."' ORDER BY RAND() LIMIT 4";
        $resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
        while ($row1 = mysql_fetch_array($resultado1)) {
            $array_images = explode(',', $row1['Image']);
            $dif = $row1['PrecioLista'] - $row1['PrecioFailbox'];
            $decimal = $dif/$row1['PrecioLista'];
            $porcent = round($decimal * 100);
            $result = array(
                "id" => $row1['IdProducto'],
                "name" => $row1['NombreProd'],
                "url" => $row1['RouteProd'],
                "descripcion" => $row1['Descripcion'],
                "marca" => $row1['Marca'],
                "price" => $row1['PrecioLista'],
                "not_price" => $row1['PrecioFailbox'],
                "image" => $array_images[0],
                "images_slider" => $array_images,
                "paypal" => $row1['urlPaypal'],
                "porcent" => $porcent
            );
            array_push($array_products_related, $result);
        }
        
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($array_products_related as $key => $value) {
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
    print_r(json_encode($items));
}

    