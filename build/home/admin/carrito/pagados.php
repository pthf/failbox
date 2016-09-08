<?php 
  session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: ../index.php");
  require_once("../db/conexion.php");
  // print_r($_SESSION);
  /*if ($_SESSION['idPrivilegio'] > 1)
    header("Location: proveedores/listProveedores.php");*/
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

  <!-- Custom styling plus plugins Diseñon completo-->
  <link href="../css/custom.css" rel="stylesheet">

  <link href="../js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="../js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


  <script src="../js/jquery.min.js"></script>

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
                    Administrador
                    <small>
                        Listado de pedidos pagados
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <?php
                          if($_SESSION['idPrivilegio'] == 1) { 
                            $sql = "SELECT * FROM Pedidos WHERE Status = '1'";
                            $res_sql = mysql_query($sql,Conectar::con()) or die(mysql_error());
                            $num_total_products = mysql_num_rows($res_sql);
                          } 
                        ?>
                        <h2>Total de productos: <?php echo $num_total_products;?></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Dirección</th>
                              <th>Status</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody> 
                            <?php
                            //Consultamos los registros almacenados en la base de datos
                            if ($_SESSION['idPrivilegio'] == 1) {
                              $query = "SELECT * FROM Pedidos pe
                                          INNER JOIN DatosEnvios d ON d.IdPedido = pe.IdPedido
                                          INNER JOIN Usuarios u ON u.IdUsuario = pe.Usuarios_IdUsuario WHERE pe.Status = '1' ORDER BY pe.IdPedido DESC";
                              $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                              while($fila = mysql_fetch_array($resultado)) { ?>
                              <tr>
                                <!-- <td><a href="../edit/editProduct.php?id=<?=$fila['IdProducto']?>"></a></td> -->
                                <td><?php echo $fila['IdPedido']?></td>
                                <td><?php echo $fila['Nombre'].' '.$fila['Apellido']?></td>
                                <td><?php echo $fila['Direccion']?></td>
                                <td>Pagado <i class="fa fa-check"></i></td>
                                <td style="width: 10%;"><a href="pedido.php?idpedido=<?=$fila['IdPedido'];?>">VER MÁS</a></td>
                              </tr>
                            <?php }
                            } ?>
                          </tbody>
                        </table>
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

        <!-- Datatables-->
        <script src="../js/datatables/jquery.dataTables.min.js"></script>
        <script src="../js/datatables/dataTables.bootstrap.js"></script>
        <script src="../js/datatables/dataTables.buttons.min.js"></script>
        <script src="../js/datatables/buttons.bootstrap.min.js"></script>
        <script src="../js/datatables/jszip.min.js"></script>
        <script src="../js/datatables/pdfmake.min.js"></script>
        <script src="../js/datatables/vfs_fonts.js"></script>
        <script src="../js/datatables/buttons.html5.min.js"></script>
        <script src="../js/datatables/buttons.print.min.js"></script>
        <script src="../js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="../js/datatables/dataTables.keyTable.min.js"></script>
        <script src="../js/datatables/dataTables.responsive.min.js"></script>
        <script src="../js/datatables/responsive.bootstrap.min.js"></script>
        <script src="../js/datatables/dataTables.scroller.min.js"></script>

        
        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable-responsive').DataTable();
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
        </script>
</body>

</html>
