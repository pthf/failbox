<?php 
  require_once("../db/conexion.php");
?>

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
                                    <li><a href="carga_masiva.php">Carga Masiva</a>
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
                                    <li><a href="../edit_providers.php">Editar</a>
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
                                    Realizar la carga masiva de los productos.
                                    <small>
                                      Sube todos los productos.
                                    </small>
                                </h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">

                                    <div class="tab-content">
                                      <div id="home" class="tab-pane fade in active">
                                        <div class="col-sm-9"><br>
                                          <div class="form-group">
                                             <form class="form-horizontal form-label-left" id="formCargaProductos" enctype="multipart/form-data">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">Carga Productos:
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="" type="file" class="form-control" name="upload_products" size="20">
                                                    <p class="help-block"> Subir únicamente archivos csv.</p>
                                                    <div class="result_products"></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12">
                                                    <button type="submit" name='submit' value='submit' class="btn btn-info">Enviar</button>
                                                </div>
                                            </form> 
                                            <?php if(isset($_GET['total_ids'])) { ?>
                                            <form class="form-horizontal form-label-left" id="formCargaCaracteristicas" enctype="multipart/form-data">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">Carga Caracteristicas:
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="" type="file" class="form-control" name="upload_char" size="20">
                                                    <p class="help-block"> Subir únicamente archivos csv.</p>
                                                    <div class="result_chars"></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12">
                                                    <button type="submit" name='submit' value='submit' class="btn btn-info">Enviar</button>
                                                </div>
                                            </form>
                                            <?php } ?>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">
                                            </label>
                                                <?php if (isset($_GET['total_ids'])) { ?>
                                                <a href="createExcelProducts.php?total_ids=<?php echo $_GET['total_ids']?>"><button type="submit" name='submit' value='submit' class="btn btn-success"><i class="fa fa-download"></i> Productos</button></a>
                                                <?php } ?>
                                                <a href="createExcelCatSub.php"><button type="submit" name='submit' value='submit' class="btn btn-warning"><i class="fa fa-download"></i> Categorías y Subcategorías</button></a>
                                                <a href="createExcelBrand.php"><button type="submit" name='submit' value='submit' class="btn btn-warning"><i class="fa fa-download"></i> Marcas</button></a>
                                                <a href="createExcelChar.php"><button type="submit" name='submit' value='submit' class="btn btn-warning"><i class="fa fa-download"></i> Características</button></a>
                                          </div>
                                          <div>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p class="help-block">Para crear la carga de los productos, necesitas descargar los archivos en excel con las categorías y características.</p>
                                            </div>
                                          </div>
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

            <script src="../js/bootstrap.min.js"></script>

            <script src="../js/custom.js"></script>   

            <script src="../js/services.js"></script>

</html>