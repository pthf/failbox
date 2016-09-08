<?php
require_once("../admin/db/conexion.php");

$query = "SELECT * FROM Categorias";
$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

$categorias = array();
while ($row = mysql_fetch_array($resultado)) {

    $categoria = array(
                "id" => $row['IdCategoria'],
                "categoria" => $row['Categoria'],
                "ruta" => $row['RouteCategoria'],
                "icono" => $row['Icono']
    );
    $categorias[] = $categoria;
}
print_r(json_encode($categorias));
?>
