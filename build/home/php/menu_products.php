
<?php
  require_once("../admin/db/conexion.php");
  $queryCat = "SELECT * FROM Categorias";
  $resultCat = mysql_query($queryCat,Conectar::con()) or die(mysql_error());
  $arrayDataCat = array();
  $arrayDataSubCat = array();
  while($lineCat = mysql_fetch_array($resultCat)){
    $querySubCat = "SELECT * FROM Subcategoria WHERE Categorias_IdCategoria = ".$lineCat['IdCategoria'];
    $resultSubCat = mysql_query($querySubCat,Conectar::con()) or die(mysql_error());
    while($lineSubCat = mysql_fetch_array($resultSubCat)){
      $queryBrand = "SELECT * FROM Productos INNER JOIN Marcas ON Marcas.IdMarca = Productos.Marcas_IdMarca WHERE Productos.Categorias_IdCategoria = ".$lineCat['IdCategoria']." AND Productos.Subcategoria_IdSubcategoria = ".$lineSubCat['IdSubcategoria']." AND Estatus = 'Activo'";
      $resultBrand = mysql_query($queryBrand,Conectar::con()) or die(mysql_error());
      $dataAuxSubCat = array($lineSubCat['Subcategoria'] => $lineSubCat['RouteSubcategoria']);
      array_push($arrayDataSubCat, $dataAuxSubCat);
    }
    $dataAuxCat = array(
      'icono' => $lineCat['Icono'],
      'url' => $lineCat['RouteCategoria'],
      'name' => $lineCat['Categoria'],
      'subcategories'  => $arrayDataSubCat
    );
    array_push($arrayDataCat, $dataAuxCat);
    unset($dataAuxCat);
    unset($arrayDataSubCat);
    $arrayDataSubCat = array();
  }
  print_r(json_encode($arrayDataCat));
?>
