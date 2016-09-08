<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
    if (isset($_GET['id'])) {
    $sql = "SELECT * FROM Productos WHERE IdProducto = '".$_GET['id']."'";
    $result = mysql_query($sql,Conectar::con()) or die(mysql_error());
    if (mysql_num_rows($result) == 0) {
      header("Location: editProducts.php");
    }
  }
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

  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/animate.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">
  <link href="../css/icheck/flat/green.css" rel="stylesheet">
  <script src="../js/jquery.min.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
              <!-- <img src="../../src/images/failbox-04.png" alt="" style="width: 80%;"> -->
          </div>
          <div class="clearfix"></div>


          <!-- menu prile quick info -->
          <div class="profile">
              <a href="../listProducts.php"><img src="../../src/images/failbox-04.png" alt="" style="width: 90%;padding: 0 0% 10% 10%;"></a>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3 style="padding: 0 27% !important"><?php echo ($_SESSION['idPrivilegio'] == 1) ? 'Administrador' : 'Proveedor' ?></h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-suitcase"></i> Productos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="../listProducts.php">Productos</a>
                    </li>
                    <li><a href="../create/createProducts.php">Crear</a>
                    </li>
                    <li><a href="../edit/editProducts.php">Editar</a>
                    </li>
                    <li><a href="../create/carga_masiva.php">Carga Masiva</a>
                    </li>
                  </ul>
                </li>
              </ul>
              <?php if($_SESSION['idPrivilegio'] == 1) { ?>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-truck"></i> Proveedores <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="../proveedores/list_providers.php">Proveedores</a>
                    </li>
                    <li><a href="../proveedores/create_provider.php">Crear</a>
                    </li>
                    <li><a href="../proveedores/edit_providers.php">Editar</a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-picture-o"></i> Banners <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="../create/banners_home.php">Banners Principal</a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-archive"></i> Pedidos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <!-- <li><a href="../carrito/pedidos.php">Todos</a>
                    </li> -->
                    <li><a href="../carrito/pagados.php">Pagados</a>
                    </li>
                    <li><a href="../carrito/pendientes.php">Pendientes</a>
                    </li>
                    <!-- <li><a href="../carrito/cancelados.php">Cancelados</a>
                    </li> -->
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
                <?php if($_SESSION['idPrivilegio'] == 1) { ?>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../images/user.png" alt=""><?php echo $_SESSION['Usuario']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                <?php } else { 
                  $sql = "SELECT idProveedor,User,ImageProfile FROM Productos p INNER JOIN Proveedores pr ON pr.idProveedor = p.Proveedores_idProveedor WHERE pr.User = '".$_SESSION['Usuario']."'";
                  $res_sql = mysql_query($sql,Conectar::con()) or die(mysql_error());
                  $row = mysql_fetch_array($res_sql);
                  ?>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../images/profileProvider/<?php echo $row['ImageProfile']?>" alt=""><?php echo $_SESSION['Usuario']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                <?php } ?>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <?php if($_SESSION['idPrivilegio'] != 1) { ?> 
                    <li><a href="../proveedores/profile_provider.php?idProvider=<?=$row['idProveedor']?>">  Perfil</a>
                    </li>
                  <?php } ?>
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
                Editar Producto
                <small> Edita y/o corrige los detalles del producto.</small>
              </h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a href="../create/createProducts.php" class=""><i class="fa fa-plus-circle" style="color:#2A3F54"> Crear Producto&nbsp&nbsp&nbsp</i></a></li>
                        <li><a href="editProducts.php" class=""><i class="fa fa-bars" style="color:#2A3F54"> Mostrar Productos</i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
                <div class="x_content">

                    <?php
                      $id = $_GET['id'];
                      $query = "SELECT * FROM Productos WHERE IdProducto = '".$id."'";
                      $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                      $fila = mysql_fetch_array($resultado);
                    ?>
                  <div class="col-md-4 col-sm-7 col-xs-12 text-center" style="padding-top: 2%;">
                    <?php 
                      $query2 = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$id."'";
                      $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                      $fila1 = mysql_fetch_array($resultado2);
                    ?>
                    <div class="product-image">
                      <img src="../images/products/<?php echo $fila1['NombreImagen']; ?>" alt="..." />
                    </div>
                    <div class="product_gallery">
                    <?php while($fila1 = mysql_fetch_array($resultado2)) { ?>
                      <a>
                        <img src="../images/products/<?php echo $fila1['NombreImagen']; ?>" alt="..." />
                      </a>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="col-md-8 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                    <h3 class="prod_title">#ID Producto: <?php echo $_GET['id']?></h3>
                    <form class="form-horizontal form-label-left" id="formEditProduct" name="formEditProductData" enctype="multipart/form-data">
                        <div class="col-sm-6">
                          <input type="text" name="id" value="<?php echo $fila['IdProducto'];?>" hidden>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Categoría
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 ">
                              <?php 
                                $query3 = "SELECT * FROM Categorias c";
                                $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
                                  echo "<select id='selectCategory' name='category' class='form-control' required>";
                                while($row3 = mysql_fetch_array($resultado3)){
                                  if ($fila['Categorias_IdCategoria'] == $row3['IdCategoria']) {
                                    echo "<option selected value='".$row3['IdCategoria']."'>". $row3['Categoria']."</option>";
                                  } else {
                                    echo "<option value='".$row3['IdCategoria']."'>". $row3['Categoria']."</option>";
                                  }
                                }
                                  echo "</select>";
                                ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Subcategoría
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12" id="SubcategorySelected">
                              <?php 
                                $query3 = "SELECT * FROM Subcategoria s WHERE Categorias_IdCategoria = '".$fila['Categorias_IdCategoria']."'";
                                $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
                                  echo "<select id='subcategory' name='subcategory' class='form-control' required>";
                                while($row3 = mysql_fetch_array($resultado3)){
                                  if ($fila['Subcategoria_IdSubcategoria'] == $row3['IdSubcategoria']) {
                                    echo "<option selected value='".$row3['IdSubcategoria']."'>". $row3['Subcategoria']."</option>";
                                  } else {
                                    echo "<option value='".$row3['IdSubcategoria']."'>". $row3['Subcategoria']."</option>";
                                  }
                                }
                                  echo "</select>";
                                ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">Marca
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php
                                $query2 = "SELECT * FROM Marcas m";
                                $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                  echo "<select id='brand' name='brand' class='form-control' required>";
                                while($row2 = mysql_fetch_array($resultado2)){
                                  if ($fila['Marcas_IdMarca'] == $row2['IdMarca']) {
                                    echo "<option selected value='".$row2['IdMarca']."'>". $row2['Marca']."</option>";
                                  } else {
                                    echo "<option value='".$row2['IdMarca']."'>". $row2['Marca']."</option>";
                                  }
                                }
                                  echo "</select>";
                              ?>
                            </div>
                          </div>
                          <!-- <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Proveedor
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if($_SESSION['idPrivilegio'] == 1) { 
                                  $query2 = "SELECT * FROM Proveedores pr";
                                  $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                    echo "<select id='name_provider' name='name_provider' class='form-control' required>";
                                  while($row2 = mysql_fetch_array($resultado2)) {
                                    if ($fila['Proveedores_idProveedor'] == $row2['idProveedor']) {
                                      echo "<option selected value='".$row2['idProveedor']."'>". $row2['RazonSocial']."</option>";
                                    } else { 
                                      echo "<option value='".$row2['idProveedor']."'>". $row2['RazonSocial']."</option>";
                                    }
                                  }
                                  echo "</select>"; 
                                } else {
                                  $query2 = "SELECT * FROM Proveedores pr WHERE User = '".$_SESSION['Usuario']."'";
                                  $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                    echo "<select id='name_provider' name='name_provider' class='form-control' required>";
                                  while($row2 = mysql_fetch_array($resultado2)) {
                                    echo "<option value='".$row2['idProveedor']."'>". $row2['RazonSocial']."</option>";
                                  }
                                  echo "</select>";
                              } ?>
                            </div>
                          </div> -->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Proveedor
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control col-md-7 col-xs-12" id="name_provider" name="name_provider" placeholder="Nombre del proveedor" type="text" value="<?php echo $fila['NombreProveedor'];?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Nombre
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control col-md-7 col-xs-12" id="name_product" name="name_product" placeholder="Nombre del producto" type="text" value="<?php echo $fila['NombreProd'];?>">
                            </div>
                          </div>
                          <div class=" form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Descripción
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <textarea required="" rows="5" name="description" class="form-control col-md-7 col-xs-12" placeholder="Escribe la descripcion del producto"><?php echo $fila["Descripcion"];?></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stocks">Stocks
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="stocks" class="form-control col-md-7 col-xs-12" name="stocks" placeholder="Nombre del producto" required="" type="text" value="<?php echo $fila['Stock'];?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warranty">Garantía 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select required class="form-control" name="warranty">
                                <option selected disabled>Selecciona..</option>
                                <?php if($fila['Garantia'] == '1') { ?>
                                <option value="1" selected>6 meses</option>
                                <option value="2">1 año</option>
                                <option value="3">2 años</option>
                                <option value="4">3 años</option>
                                <?php } else if($fila['Garantia'] == '2') { ?>
                                <option value="1">6 meses</option>
                                <option value="2" selected>1 año</option>
                                <option value="3">2 años</option>
                                <option value="4">3 años</option>
                                <?php } else if($fila['Garantia'] == '3') { ?>
                                <option value="1">6 meses</option>
                                <option value="2">1 año</option>
                                <option value="3" selected>2 años</option>
                                <option value="4">3 años</option>
                                <?php } else if($fila['Garantia'] == '4') { ?>
                                <option value="1">6 meses</option>
                                <option value="2">1 año</option>
                                <option value="3">2 años</option>
                                <option value="4" selected>3 años</option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pricelist">Precio lista $
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="pricelist" class="form-control col-md-7 col-xs-12" name="pricelist" placeholder="Precio lista MXN" required="" type="text" value="<?php echo $fila['PrecioLista'];?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pricefailbox">Precio failbox $
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="pricefailbox" class="form-control col-md-7 col-xs-12" name="pricefailbox" placeholder="Precio failbox MXN" required="" type="text" value="<?php echo $fila['PrecioFailbox'];?>">
                            </div>
                          </div>
                          <div class=" form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cost_shipping">Costo de envío 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select required class="form-control" name="cost_shipping">
                                <option selected disabled>Selecciona..</option>
                                <?php if ($fila['CostoEnvio'] == 0) { ?>
                                <option value="0" selected>Envio Gratis</option>
                                <option value="99">5 Kg $98.79</option>
                                <option value="120">10 Kg $120.00</option>
                                <option value="135">15 Kg $134.98</option>
                                <?php } else if ($fila['CostoEnvio'] == 99) { ?>
                                <option value="0">Envio Gratis</option>
                                <option value="99" selected>5 Kg $98.79</option>
                                <option value="120">10 Kg $120.00</option>
                                <option value="135">15 Kg $134.98</option>
                                <?php } else if ($fila['CostoEnvio'] == 120) { ?>
                                <option value="0">Envio Gratis</option>
                                <option value="99">5 Kg $98.79</option>
                                <option value="120" selected>10 Kg $120.00</option>
                                <option value="135">15 Kg $134.98</option>
                                <?php } else if ($fila['CostoEnvio'] == 135) { ?>
                                <option value="0">Envio Gratis</option>
                                <option value="99">5 Kg $98.79</option>
                                <option value="120">10 Kg $120.00</option>
                                <option value="135" selected>15 Kg $134.98</option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="model">Modelo
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="model" class="form-control col-md-7 col-xs-12" name="model" placeholder="Nombre del producto" required="" type="text" value="<?php echo $fila['Modelo'];?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sku">SKU
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="sku" class="form-control col-md-7 col-xs-12" name="sku" placeholder="Nombre del producto" required="" type="text" value="<?php echo $fila['SKU'];?>">
                            </div>
                          </div>
                          <?php if($_SESSION['idPrivilegio'] == 1) { ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="estatus">Estatus
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" id="estatus" name="estatus">
                                  <?php if ($fila['Estatus'] == 'Activo') { ?>
                                  <option selected>Activo</option>
                                  <option>Inactivo</option>
                                  <?php } else if ($fila['Estatus'] == 'Inactivo') { ?>
                                  <option>Activo</option>
                                  <option selected>Inactivo</option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          <?php } else { ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="estatus">Estatus
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input disabled class="form-control" type="text" value="<?php echo $fila['Estatus']?>">
                                <input hidden type="text" name="estatus" value="<?php echo $fila['Estatus']?>">
                              </div>
                            </div>
                          <?php } ?>
                          <div class=" form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="outstanding">¿Destacar?
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="form-control" name="outstanding">
                                <?php if ($fila['Destacado'] == 'SI') { ?>
                                <option>NO</option>
                                <option selected>SI</option>
                                <?php } else if ($fila['Destacado'] == 'NO') { ?>
                                <option selected>NO</option>
                                <option>SI</option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class=" form-group">
                              <label for="url_paypal" class="control-label col-md-3">URL Paypal </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="url_paypal" type="text" name="url_paypal" class="form-control col-md-7 col-xs-12" required="" placeholder="URL Paypal" value="<?php echo $fila['urlPaypal'];?>">
                                <input hidden type="text" name="idPrivilegio" value="<?php echo $_SESSION['idPrivilegio'];?>">
                              </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                              <a href="editProducts.php" class="btn btn-danger">Cancelar</a>
                              <button type="submit" class="btn btn-primary">Siguiente</button>
                            </div>
                          </div>
                        </div>
                    </form>
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
  $(document).ready(function(){
    $("#selectCategory").change(function () {
        var idCategory = $("option:selected", this).attr('value');
        var namefunction = 'getEditProduct';
        $.ajax({
            url: "../php/functions.php",
            type: "POST",
            data: {
                namefunction: namefunction,
                idCategory: idCategory
            },
            success: function (result) {
                $('#SubcategorySelected select').html(result);
            },
            error: function () {},
            complete: function () {},
            timeout: 10000
        });
        
    });
  });
  </script>
  </script>
  <script src="../js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>

  <script src="../js/custom.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>

  <script src="../js/services.js"></script>
</body>

</html>