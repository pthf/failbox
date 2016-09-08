<?php

require_once("../admin/db/conexion.php");

if (isset($_GET['nameCategory']) && isset($_GET['nameSubcategory']) && isset($_GET['nameBrand'])) {

    $query = "SELECT * FROM Productos p
                INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca
                INNER JOIN Categorias c ON c.IdCategoria = p.Categorias_IdCategoria
                INNER JOIN Subcategoria s ON s.IdSubcategoria = p.Subcategoria_IdSubcategoria
                WHERE c.RouteCategoria = '" . $_GET['nameCategory'] . "' AND s.RouteSubcategoria = '" . $_GET['nameSubcategory'] . "' AND m.RouteMarca = '" . $_GET['nameBrand'] . "' AND Estatus = 'Activo' AND Stock > 0";
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
        $productos[] = $producto;
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($productos as $key => $value) {
        array_push($arrayGroup, $value);
        if ($counter == 8) {
            array_push($arrayList, $arrayGroup);
            $counter = 0;
            unset($arrayGroup);
            $arrayGroup = array();
        } else {
            $counter++;
        }
    }

    if (count($arrayGroup) > 0) {
        array_push($arrayList, $arrayGroup);
        $counter = 0;
        unset($arrayGroup);
        $arrayGroup = array();
    }

    $items = array();
    for ($i = 0; $i < count($arrayList); $i++) {
        $item =  array(
          "group" => $i,
          "data" => $arrayList[$i]
        );
        array_push($items, $item);
    }
    echo json_encode($items);
    //echo $item;
} else if (isset($_GET['nameCategory']) && isset($_GET['nameSubcategory'])) {
    $query = "SELECT * FROM Productos p
                INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca
                INNER JOIN Categorias c ON c.IdCategoria = p.Categorias_IdCategoria
                INNER JOIN Subcategoria s ON s.IdSubcategoria = p.Subcategoria_IdSubcategoria
                WHERE c.RouteCategoria = '" . $_GET['nameCategory'] . "' AND s.RouteSubcategoria = '" . $_GET['nameSubcategory'] . "' AND Estatus = 'Activo' AND Stock > 0";
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
        $productos[] = $producto;
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($productos as $key => $value) {
        array_push($arrayGroup, $value);
        if ($counter == 8) {
            array_push($arrayList, $arrayGroup);
            $counter = 0;
            unset($arrayGroup);
            $arrayGroup = array();
        } else {
            $counter++;
        }
    }

    if (count($arrayGroup) > 0) {
        array_push($arrayList, $arrayGroup);
        $counter = 0;
        unset($arrayGroup);
        $arrayGroup = array();
    }

    $items = array();
    for ($i = 0; $i < count($arrayList); $i++) {
        $item =  array(
          "group" => $i,
          "data" => $arrayList[$i]
        );
        array_push($items, $item);
    }
    echo json_encode($items);
} else if (isset($_GET['nameCategory'])) {
    $query = "SELECT * FROM Productos p
                INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca
                INNER JOIN Categorias c ON c.IdCategoria = p.Categorias_IdCategoria
                INNER JOIN Subcategoria s ON s.IdSubcategoria = p.Subcategoria_IdSubcategoria
                WHERE c.RouteCategoria = '" . $_GET['nameCategory'] . "' AND Estatus = 'Activo' AND Stock > 0";
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
        $productos[] = $producto;
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($productos as $key => $value) {
        array_push($arrayGroup, $value);
        if ($counter == 8) {
            array_push($arrayList, $arrayGroup);
            $counter = 0;
            unset($arrayGroup);
            $arrayGroup = array();
        } else {
            $counter++;
        }
    }

    if (count($arrayGroup) > 0) {
        array_push($arrayList, $arrayGroup);
        $counter = 0;
        unset($arrayGroup);
        $arrayGroup = array();
    }

    $items = array();
    for ($i = 0; $i < count($arrayList); $i++) {
        $item =  array(
          "group" => $i,
          "data" => $arrayList[$i]
        );
        array_push($items, $item);
    }
    echo json_encode($items);
} else {
    $query = "SELECT * FROM Productos p
                INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca
                INNER JOIN Categorias c ON c.IdCategoria = p.Categorias_IdCategoria
                INNER JOIN Subcategoria s ON s.IdSubcategoria = p.Subcategoria_IdSubcategoria WHERE Estatus = 'Activo' AND Stock > 0";
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
        $productos[] = $producto;
    }

    $arrayList = array();
    $arrayGroup = array();
    $counter = 0;
    foreach ($productos as $key => $value) {
        array_push($arrayGroup, $value);
        if ($counter == 8) {
            array_push($arrayList, $arrayGroup);
            $counter = 0;
            unset($arrayGroup);
            $arrayGroup = array();
        } else {
            $counter++;
        }
    }

    if (count($arrayGroup) > 0) {
        array_push($arrayList, $arrayGroup);
        $counter = 0;
        unset($arrayGroup);
        $arrayGroup = array();
    }

    $items = array();
    for ($i = 0; $i < count($arrayList); $i++) {
        $item =  array(
          "group" => $i,
          "data" => $arrayList[$i]
        );
        array_push($items, $item);
    }
    echo json_encode($items);

}



?>
