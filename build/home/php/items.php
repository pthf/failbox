<?php
require_once("../admin/db/conexion.php");

$query = "SELECT * FROM Productos p INNER JOIN Marcas m ON m.IdMarca = p.Marcas_IdMarca WHERE Estatus = 'Activo' AND Stock > 0";
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
                "sku"=> $row['SKU'],
                "cost_shipping" => $row['CostoEnvio'],
                "image" => $array_images[0],
                "images_slider" => $array_images,
                "paypal" => $row['urlPaypal'],
                "stocks" => $row['Stock']
    );
    $productos[] = $producto;
}
print_r(json_encode($productos));
?>
