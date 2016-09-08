<?php
  require_once("../admin/db/conexion.php");
  $queryCat = "SELECT * FROM Categorias";
  $resultCat = mysql_query($queryCat,Conectar::con()) or die(mysql_error());
  $arrayDataCat = array();
  $arrayDataSubCat = array();
  $arrayDataBrand = array();
  while($lineCat = mysql_fetch_array($resultCat)){
    $querySubCat = "SELECT * FROM Subcategoria WHERE Categorias_IdCategoria = ".$lineCat['IdCategoria'];
    $resultSubCat = mysql_query($querySubCat,Conectar::con()) or die(mysql_error());
    while($lineSubCat = mysql_fetch_array($resultSubCat)){
      $queryBrand = "SELECT * FROM Productos INNER JOIN Marcas ON Marcas.IdMarca = Productos.Marcas_IdMarca WHERE Productos.Categorias_IdCategoria = ".$lineCat['IdCategoria']." AND Productos.Subcategoria_IdSubcategoria = ".$lineSubCat['IdSubcategoria']." AND Estatus = 'Activo'";
      $resultBrand = mysql_query($queryBrand,Conectar::con()) or die(mysql_error());
      $arrayBrandRegister = array();
      while($lineBrand = mysql_fetch_array($resultBrand)){
        $register = false;
        foreach ($arrayBrandRegister as $key => $value) {
          if($lineBrand['Marca'] == $value)
            $register = true;
        }
        if(!$register){
          $dataAuxBrand = array($lineBrand['Marca']  => $lineBrand['IdMarca']);
          array_push($arrayDataBrand, $dataAuxBrand);
          unset($dataAuxBrand);
          array_push($arrayBrandRegister, $lineBrand['Marca']);
        }
      }
      $dataAuxSubCat = array($lineSubCat['Subcategoria'] => $arrayDataBrand);
      array_push($arrayDataSubCat, $dataAuxSubCat);
      unset($dataAuxSubCat);
      unset($arrayDataBrand);
      $arrayDataBrand = array();
    }
    $dataAuxCat = array($lineCat['Categoria']  => $arrayDataSubCat);
    array_push($arrayDataCat, $dataAuxCat);
    unset($dataAuxCat);
    unset($arrayDataSubCat);
    $arrayDataSubCat = array();
  }
  print_r(json_encode($arrayDataCat));
?>
