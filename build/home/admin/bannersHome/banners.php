<?php 
  session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
?> 
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FAILBOX! | Admin</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!--Plugin para los iconos-->
        <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="../css/custom.css" rel="stylesheet">
        <link href="../css/icheck/flat/green.css" rel="stylesheet">
        <link href="../css/fileinput.css" rel="stylesheet">

        <script src="../js/jquery.min.js"></script>
        <script src="../js/fileinput.js"></script>
        <script src="../js/ajax.js"></script>
    </head>


    <body class="nav-md">

        <div class="container body">


            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">

                        <div class="navbar nav_title" style="border: 0;">
                            <a href="../listProducts.php" class="site_title"><i class="fa fa-send"></i> <span>Failbox</span></a>
                            <!--<a href="index3.html"><img src="images/failbox-04.svg"></a>-->
                        </div>
                        <div class="clearfix"></div>


                        <!-- menu prile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="../images/user.png" alt="" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Bienvenido</span>
                            </div>
                        </div>
                        <!-- /menu prile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                            <div class="menu_section">
                              <h3><?php echo ($_SESSION['idPrivilegio'] == 1) ? 'Administrador' : 'Proveedor' ?></h3>
                              <ul class="nav side-menu">
                                <li><a><i class="fa fa-suitcase"></i> Productos <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu" style="display: none">
                                    <li><a href="../listProducts.php">Productos</a>
                                    </li>
                                    <li><a href="createProducts.php">Crear</a>
                                    </li>
                                    <li><a href="../edit/editProducts.php">Editar</a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                              <?php if($_SESSION['idPrivilegio'] == 1) { ?>
                              <ul class="nav side-menu">
                                <li><a><i class="fa fa-truck"></i> Proveedores <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu" style="display: none">
                                    <li><a href="../proveedores/listProveedores.php">Proveedores</a>
                                    </li>
                                    <li><a href="#">Crear</a>
                                    </li>
                                    <li><a href="#">Editar</a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                              <ul class="nav side-menu">
                                <li><a><i class="fa fa-picture-o"></i> Banners <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu" style="display: none">
                                    <li><a href="#">Banners Principal</a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                              <?php } ?>
                            </div>

                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">

                    <div class="nav_menu">
                        <nav class="" role="navigation">
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="../images/user.png" alt=""><?php echo $_SESSION['Usuario']?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="#">  Perfil</a>
                                        </li>
                                        <li><a href="../login/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesion</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">

                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>
                                    Crear Proveedor
                                    <small>
                                        Crea un nuevo proveedor.
                                    </small>
                                </h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a data-toggle="tab" href="#home">PRODUCTOS</a></li>
                                      <li><a data-toggle="tab" href="#menu1">CARACTERISTICAS</a></li>
                                      <li><a data-toggle="tab" href="#menu2">IMAGENES</a></li>
                                      <li><a data-toggle="tab" href="#menu3">NUEVA CATEGORIA</a></li>
                                      <li><a data-toggle="tab" href="#menu4">NUEVA SUBCATEGORIA</a></li>
                                      <li><a data-toggle="tab" href="#menu5">NUEVA MARCA</a></li>
                                    </ul>

                                    <div class="tab-content">
                                      <div id="home" class="tab-pane fade in active">
                                        <form class="form-horizontal form-label-left" id="formProduct" name="formProductData" enctype="multipart/form-data">
                                            <div class="col-sm-5"><br>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Categoría   
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div id="result_category"><?php include('consult_category.php');?></div>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Subcategoría   
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class='form-control' id="selectSubCategory" required name="subcategory">
                                                            <option disabled selected>Selecciona..</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">Marca  
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <div id="result_brand"><?php include('consult_brand.php');?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Nombre Producto 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="name_product" class="form-control col-md-7 col-xs-12" name="name_product" placeholder="Nombre del producto" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Descripción 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea id="description" required="" rows="5" name="description" class="form-control col-md-7 col-xs-12" placeholder="Escribe la descripcion del producto" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stocks">Stocks 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="number" min="0" id="stocks" name="stocks" required="" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de productos">
                                                    </div>
                                                </div>
                                                <!--<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warranty">Garantía 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required class="form-control" name="warranty">
                                                            <option selected disabled>Selecciona..</option>
                                                            <option>6 meses</option>
                                                            <option>1 año</option>
                                                            <option>2 año</option>
                                                            <option>3 año</option>
                                                        </select>
                                                    </div>
                                                </div>-->
                                            </div>
                                            <div class="col-sm-5"><br>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pricelist">Precio lista $ 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="number" id="pricelist" name="pricelist" required="" min="0" data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12" placeholder="Precio lista MXN">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pricefailbox">Precio failbox $ 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="number" id="pricefailbox" name="pricefailbox" required="" min="0" data-validate-minmax="10,100" placeholder="Precio failbox MXN" class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="modelo">Modelo 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="model" type="text" name="model" required="" placeholder="Codigo de producto" class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label for="sku" class="control-label col-md-3">SKU </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="sku" type="text" name="sku" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="" placeholder="No. REF. (SKU)">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Estatus 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required class="form-control" name="status">
                                                            <option disabled selected>Selecciona..</option>
                                                            <option>Activo</option>
                                                            <option>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="outstanding">¿Producto destacado?
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required class="form-control" name="outstanding">
                                                            <option disabled selected>Selecciona..</option>
                                                            <option>SI</option>
                                                            <option>NO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label for="url_paypal" class="control-label col-md-3">URL Paypal </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="url_paypal" type="text" name="url_paypal" class="form-control col-md-7 col-xs-12" required="" placeholder="URL Paypal">
                                                    </div>
                                                </div>
                                                <!--<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Subir Imagen 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="file" id="image" name="image[]" value="" required multiple>
                                                        <p class="help-block">Subir unicamente imagenes .jpg, .jpeg, png.</p>
                                                    </div>
                                                </div>-->
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a href="../listProducts.php" class="btn btn-danger">Cancelar</a>
                                                        <?php if (isset($_GET['id'])) { ?>  
                                                        <button type="submit" class="btn btn-primary" disabled>Siguiente</button>
                                                        <p class="help-block"> "Crea las características e imágenes del producto".</p>
                                                        <?php } else { ?>
                                                        <button type="submit" class="btn btn-primary">Siguiente</button>
                                                        <p class="help-block"> "Click en el botón Siguiente y continua en la pestaña Características".</p>
                                                        <?php }?>
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                        </form>
                                      </div>
                                      <div id="menu1" class="tab-pane fade">   
                                        <div class="col-sm-5"><br>
                                            <div class="form-group">
                                                <form name="new_characteristic" action="" onsubmit="sendCharacteristic(); return false">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">Nueva Característica *
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required id="new_characteristic" class="form-control col-md-7 col-xs-12" type="text" name="new_characteristic" placeholder="Tipo característica">
                                                        <p class="help-block"> Ejemplo: color, tamaño, peso, etc.</p>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <button type="submit" value"Grabar" class="btn btn-info">Añadir Característica</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <form class="form-horizontal form-label-left" id="formCharacteristics">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_characteristic">Tipo Característica *  
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div id="result_characteristic"><?php include('consult_characteristic.php');?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="characteristic">Característica *
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php if (!isset($_GET['id'])) { ?>  
                                                        <input type="text" min="0" id="characteristic" name="characteristic" required="" class="form-control col-md-7 col-xs-12" placeholder="Tipo característica" disabled>
                                                        <?php } else { ?>
                                                        <input type="text" min="0" id="characteristic" name="characteristic" required="" class="form-control col-md-7 col-xs-12" placeholder="Tipo característica">
                                                        <?php } ?>
                                                    </div>
                                                    <input hidden type="text" name="idProducto" value="<?php echo $_GET['id']?>">
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a href="../listProducts.php" class="btn btn-danger">Cancelar </a>
                                                        <?php if (!isset($_GET['id'])) { ?>  
                                                        <button type="submit" class="btn btn-primary" disabled >Siguiente</button>
                                                        <p class="help-block"> "Para continuar necesitas crear un producto en la pestaña Productos".</p>
                                                        <?php } else { ?>
                                                        <button type="submit" class="btn btn-primary">Siguiente</button>
                                                        <p class="help-block"> "Click en el botón Siguiente y continua en la pestaña Imágenes".</p>
                                                        <?php } ?>
                                                        
                                                        <!-- <a href="../listProducts.php" class="btn btn-warning">Finalizar</a>   -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-5">
                                            <?php if(isset($_GET['id'])) { ?> 
                                            <table class="table table-striped">
                                                <thead>
                                                  <tr>
                                                    <th>Tipo</th>
                                                    <th>Característica</th>
                                                    <!-- <th></th> -->
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $query = "SELECT * FROM Productos p
                                                            INNER JOIN Productos_has_Caracteristicas phc 
                                                                ON phc.Productos_IdProducto = p.IdProducto
                                                            INNER JOIN Caracteristicas ca 
                                                                ON ca.IdCaracteristica = phc.Caracteristicas_IdCaracteristica
                                                            WHERE p.IdProducto = '".$_GET['id']."'";
                                                $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                while($fila=mysql_fetch_array($resultado)) { ?>
                                                  <tr>
                                                    <td><?php echo $fila['NombreCaracteristica']; ?></td>
                                                    <td><?php echo $fila['DetalleCaracteristica']; ?></td>
                                                    <!-- <td><a href="../delete/deleteCharacteristics.php?id=<?php echo $_GET['id']; ?>&caracteristica=<?php echo $fila['Caracteristicas_IdCaracteristica']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar </a></td> -->
                                                  </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                        </div>
                                      </div>
                                      <div id="menu2" class="tab-pane fade">
                                        <div class="col-sm-5"><br>
                                            <form class="form-horizontal form-label-left" method="post" id="formulario" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">Subir imagen: 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php if (!isset($_GET['id'])) { ?> 
                                                        <input type="file" id="image" name="image[]" multiple required disabled>
                                                        <?php } else { ?>
                                                        <input type="file" id="image" name="image[]" multiple required>
                                                        <?php } ?>
                                                        <p class="help-block"> Subir imagenes de tipo jpeg, jpg, png y tamaño minimo de 60 x 500 pixels.</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                   <div class="col-md-6 col-md-offset-3">
                                                        <a href="../listProducts.php" class="btn btn-danger">Finalizar</a>
                                                        <?php if (!isset($_GET['id'])) { ?> 
                                                        <button class="btn btn-info" type="button" id="btn" disabled >Subir imágenes</button>
                                                        <p class="help-block"> "Para subir las imagenes, necesitas crear un nuevo producto".</p>
                                                        <?php } else { ?>
                                                        <button class="btn btn-info" type="button" id="btn">Subir imágenes</button>
                                                        <p class="help-block"> "Al terminar de subir las imagenes click en el botón Finalizar".</p>
                                                        <?php } ?>
                                                        
                                                    </div> 
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-5"><br>
                                            <?php if(isset($_GET['id'])) { ?> 
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Imagen</th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $query2 = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$_GET['id']."'";
                                                    $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());

                                                    while($fila1 = mysql_fetch_array($resultado2)) { ?>
                                                    <tr>
                                                        <td><?php echo $fila1['NombreImagen']; ?></td>
                                                        <td>
                                                            <img src="../images/products/<?php echo $fila1['NombreImagen']; ?>" alt="..." style="width: 70px; height: 60px;">
                                                        </td>
                                                        <!-- <td><a href="../delete/deleteImage.php?id=<?php echo $_GET['id']; ?>&imagen=<?php echo $fila1['IdImagen']?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar </a></td> -->
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>  
                                            <?php } ?>
                                        </div>

                                        <div id="vista-previa"></div>
                                        <div id="respuesta"></div>
                                      </div>
                                      <div id="menu3" class="tab-pane fade">
                                        <form class="form-horizontal form-label-left" name="new_category" action="" onsubmit="sendCategory(); return false">
                                            <div class="col-sm-5"><br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Nueva categoría 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required id="other_category" class="form-control col-md-7 col-xs-12" type="text" name="other_category" placeholder="Categoría">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <button type="submit" value"Grabar" class="btn btn-primary">Agregar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-5"><br>
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#ID</th>
                                                            <th>Categoría</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $query2 = "SELECT * FROM Categorias";
                                                        $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());

                                                        while($fila1 = mysql_fetch_array($resultado2)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $fila1['IdCategoria']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $fila1['Categoria']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>  
                                            </div>
                                        </form>
                                      </div>
                                      <div id="menu4" class="tab-pane fade">
                                        <form class="form-horizontal form-label-left" name="new_subcategory" id="formNewSubcategory">
                                            <div class="col-sm-5"><br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Categoría 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                        $query = "SELECT * FROM Categorias";
                                                        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                            echo "<select id='category' name='category' class='form-control' required>";
                                                            echo "<option disabled selected>Selecciona..</option>";
                                                        while($row2 = mysql_fetch_array($resultado)){
                                                            echo "<option value='".$row2['IdCategoria']."'>". $row2['Categoria']."</option>";
                                                        }
                                                            echo "</select>";
                                                      ?>    
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Subcategoría
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required id="other_subcategory" class="form-control col-md-7 col-xs-12" type="text" name="other_subcategory" placeholder="Subcategoría">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <button type="submit" value"Grabar" class="btn btn-primary">Agregar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5"><br>
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#ID</th>
                                                            <th>Subcategorías</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $query2 = "SELECT * FROM Subcategoria s";
                                                        $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());

                                                        while($fila1 = mysql_fetch_array($resultado2)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $fila1['IdSubcategoria']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $fila1['Subcategoria']; ?></td>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>  
                                            </div>
                                            
                                        </form>
                                            <div class="result_subcategory"></div>
                                            <div class="error_subcategory"></div>
                                      </div>
                                      <div id="menu5" class="tab-pane fade">
                                        <div class="form-group">
                                            <form class="form-horizontal form-label-left" name="new_brand" action="" onsubmit="sendBrand(); return false">
                                                <div class="col-sm-5"><br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">Nueva marca 
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required id="other_brand" class="form-control col-md-7 col-xs-12" type="text" name="other_brand" placeholder="Marca">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-3">
                                                            <button type="submit" value"Grabar" class="btn btn-primary">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5"><br>
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#ID</th>
                                                            <th>Marcas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $query2 = "SELECT * FROM Marcas s";
                                                        $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());

                                                        while($fila1 = mysql_fetch_array($resultado2)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $fila1['IdMarca']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $fila1['Marca']; ?></td>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>  
                                            </div>
                                            </form>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="x_content">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="alta-producto">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /page content -->

                    <!-- footer content -->
                    <footer>
                      <div class="pull-right">
                        ©2016 FAILBOX - Website by <a href="https://colorlib.com">PTHF</a>
                      </div>
                      <div class="clearfix"></div>
                    </footer>
                    <!-- /footer content -->
                </div>
            </div>

            <div id="custom_notifications" class="custom-notifications dsp_none">
                <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
                </ul>
                <div class="clearfix"></div>
                <div id="notif-group" class="tabbed_notifications"></div>
            </div>

            <script type="text/javascript">
                $("#selectCategory").change(function () {
                    var idCategory = $("option:selected", this).attr('value');
                    var namefunction = 'getStatesUser';
                    $.ajax({
                        url: "../php/functions.php",
                        type: "POST",
                        data: {
                            namefunction: namefunction,
                            idCategory: idCategory
                        },
                        success: function (result) {
                            $('#selectSubCategory').html(result);
                        },
                        error: function () {},
                        complete: function () {},
                        timeout: 10000
                    });
                });
            </script>
            <script src="../js/bootstrap.min.js"></script>

            <script src="../js/custom.js"></script>   

            <script src="../js/services.js"></script>

</html>