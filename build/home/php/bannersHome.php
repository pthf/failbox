<?php
require_once("../admin/db/conexion.php");

$query = "SELECT * FROM BannersHome";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

$banners = array();
while ($row = mysql_fetch_array($resultado)) {
    $banner =
        array(
            "id" => $row['idBannersHome'],
            "name" => $row['BannersHomeName'],
            "link" => $row['BannersHomeUrl'],
            "image" => $row['BannersHomeImage'],
        );
    $banners[] = $banner;
}
print_r(json_encode($banners));
?>
