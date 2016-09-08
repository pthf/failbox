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
  <script type="text/javascript">
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip();
      (function ($) {
        $('#filtrar').keyup(function () {
          var rex = new RegExp($(this).val(), 'i');
          $('.buscar .products').hide();
          $('.buscar .products').filter(function () {
            return rex.test($(this).text());
          }).show();
        })
      }(jQuery));
    });
  </script>

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
              <h3>Mostrar y Editar Producto
                <small>
                Edita o elimina algun producto.
              </small>
              </h3>
            </div>
            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group-btn"> 
                  <span class="input-group">Buscar</span>
                    <input id="filtrar" type="text" class="form-control" placeholder="Ingrese el nombre del producto a buscar...">
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content">

                  <div class="row buscar">
                    <div class="x_title">
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a href="../create/createProducts.php" class=""><i class="fa fa-plus-circle" style="color:#2A3F54"> Crear Producto&nbsp&nbsp&nbsp</i></a></li>
                        <li><a href="editProducts.php" class=""><i class="fa fa-bars" style="color:#2A3F54"> Mostrar Productos</i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <?php
                    if($_SESSION['idPrivilegio'] == 1) {  
                      $query4 = "SELECT * FROM Productos p INNER JOIN Proveedores pr ON pr.idProveedor = p.Proveedores_idProveedor";
                      $resultado4 = mysql_query($query4,Conectar::con()) or die(mysql_error());
                      $num_total_registros = mysql_num_rows($resultado4);
                      //Si hay registros
                      if ($num_total_registros > 0) {
                        //Limito la busqueda
                        $TAMANO_PAGINA = 5;
                              $pagina = false;

                        //examino la pagina a mostrar y el inicio del registro a mostrar
                              if (isset($_GET["pagina"]))
                                  $pagina = $_GET["pagina"];
                              
                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        }
                        else {
                          $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        //calculo el total de paginas
                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

                        //echo '<h3>Numero de articulos: '.$num_total_registros .'</h3>';
                        $query5 = "SELECT * FROM Productos p INNER JOIN Proveedores pr ON pr.idProveedor = p.Proveedores_idProveedor ORDER BY p.IdProducto ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        $resultado5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
                        while ($fila = mysql_fetch_array($resultado5)) { ?>
                        <div class="col-xs-4 products">
                        <div class="well profile_view">
                          <div class="col-sm-12 details_prod">
                            <h4 class="brief"><i>ID: <?php echo $fila['IdProducto']?></i></h4>
                            <div class="left col-xs-8">
                              <div class="row">
                                <div class="col-md-6">
                                  <span><strong>Nombre:</strong> <?php echo $fila['NombreProd']?></span>
                                </div>
                                <div class="col-md-6">
                                  <ul class="list-unstyled">
                                  <p><strong>SKU:</strong> <?php echo $fila['SKU']?></p>
                                </div>
                              </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Stocks:</strong> <?php echo $fila['Stock']?></div>
                                  <div class="col-md-6"><strong>Marca:</strong>
                                    <?php 
                                      $query1 = "SELECT * FROM Marcas m 
                                                  INNER JOIN Productos p
                                                  ON p.Marcas_IdMarca = m.IdMarca
                                                  WHERE p.IdProducto = '".$fila['IdProducto']."'";
                                      $resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
                                      $fila1 = mysql_fetch_array($resultado1);
                                      echo $fila1['Marca']; 
                                    ?>
                                  </div>
                                </div>
                                <div class="row">
                                </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Categoria:</strong>
                                    <?php 
                                      $query2 = "SELECT * FROM Categorias c
                                                  INNER JOIN Productos p
                                                  ON p.Categorias_IdCategoria = c.IdCategoria
                                                  WHERE p.IdProducto = ".$fila['IdProducto'];
                                      $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                      while($fila2 = mysql_fetch_array($resultado2)) { 
                                        echo $fila2['Categoria'];
                                      }
                                    ?>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Subcategoria:</strong>
                                    <?php 
                                      $query2 = "SELECT * FROM Subcategoria s
                                                  INNER JOIN Productos p
                                                  ON p.Subcategoria_IdSubcategoria = s.IdSubcategoria
                                                  WHERE p.IdProducto = ".$fila['IdProducto'];
                                      $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                      while($fila2 = mysql_fetch_array($resultado2)) { 
                                        echo $fila2['Subcategoria'];
                                      }
                                    ?>
                                  </div>
                                </div>
                              </ul>
                            </div>
                            <div class="col-xs-4 text-center">
                              <?php 
                                $query3 = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$fila['IdProducto']."'";
                                $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
                                $fila3 = mysql_fetch_array($resultado3);
                              ?>
                              <a href="editProduct.php?id=<?php echo $fila['IdProducto'];?>"><img src="../images/products/<?php echo $fila3['NombreImagen']; ?>" alt="" class="img-rounded img-responsive img_details"></a>
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-8 emphasis">
                              <p class="ratings">
                                Lista: <strike><?php echo '$ '.$fila['PrecioLista'].'.00'?></strike>
                                Failbox: <?php echo '$ '.$fila['PrecioFailbox'].'.00'?>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-4 emphasis text-right">
                              <?php if ($fila['Estatus'] == 'Activo') { ?>
                                <a href="editEstatus.php?id=<?php echo $fila['IdProducto'];?>&estatus=Inactivo" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="¿Desactivar?">
                                  <?php echo $fila['Estatus'];?>
                                </a>
                              <?php } else { ?>
                                <a href="editEstatus.php?id=<?php echo $fila['IdProducto'];?>&estatus=Activo" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Activar?">
                                  <?php echo $fila['Estatus'];?>
                                </a>
                              <?php } ?>
                              <a href="editProduct.php?id=<?php echo $fila['IdProducto'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
                              <a href="../delete/deleteProduct.php?id=<?php echo $fila['IdProducto']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                        <?php } 
                        echo "<div class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;''>";
                          echo "<nav>";
                            echo "<ul class='pagination pagination-split'>";
                              if ($total_paginas > 1) {
                                if ($pagina != 1) {
                                    echo "<li>";
                                      echo '<a href="editProducts.php?pagina='.($pagina-1).'"><span title="Primer Pagina"aria-hidden="true">&laquo;</span></a>';
                                    echo "</li>";
                                } 
                                  for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pagina == $i) {
                                      //si muestro el indice de la pagina actual, no coloco enlace
                                      echo "<li><a style='background:#A5A9AC; color:#FFFFFF;'>";
                                        echo $pagina;
                                      echo "</a></li>";
                                    } else {
                                      //si el indice no corresponde con la pagina mostrada actualmente,
                                      //coloco el enlace para ir a esa pagina
                                        echo "<li>";
                                          echo '<a href="editProducts.php?pagina='.$i.'">'.$i.'</a>';
                                        echo "</li>";
                                    }
                                  }
                                  if ($pagina != $total_paginas) { 
                                    echo "<li>";
                                      echo '<a href="editProducts.php?pagina='.($pagina+1).'"><span title="Ultima Pagina" aria-hidden="true">&raquo;</span></a>';
                                    echo "</li>";
                                  }
                                }
                              echo "</li>";
                            echo "</ul>";
                          echo "</nav>";
                        echo "</div>";
                      }
                    } else {
                      $query4 = "SELECT * FROM Productos p INNER JOIN Proveedores pr ON pr.idProveedor = p.Proveedores_idProveedor WHERE pr.User = '".$_SESSION['Usuario']."'";
                      $resultado4 = mysql_query($query4,Conectar::con()) or die(mysql_error());
                      $num_total_registros = mysql_num_rows($resultado4);
                      //Si hay registros
                      if ($num_total_registros > 0) {
                        //Limito la busqueda
                        $TAMANO_PAGINA = 5;
                              $pagina = false;

                        //examino la pagina a mostrar y el inicio del registro a mostrar
                              if (isset($_GET["pagina"]))
                                  $pagina = $_GET["pagina"];
                              
                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        }
                        else {
                          $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        //calculo el total de paginas
                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

                        //echo '<h3>Numero de articulos: '.$num_total_registros .'</h3>';
                        $query5 = "SELECT * FROM Productos p INNER JOIN Proveedores pr ON pr.idProveedor = p.Proveedores_idProveedor WHERE pr.User = '".$_SESSION['Usuario']."' ORDER BY p.IdProducto ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        $resultado5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
                        while ($fila = mysql_fetch_array($resultado5)) { ?>
                        <div class="col-xs-4 products">
                        <div class="well profile_view">
                          <div class="col-sm-12 details_prod">
                            <h4 class="brief"><i>ID: <?php echo $fila['IdProducto']?></i></h4>
                            <div class="left col-xs-8">
                              <div class="row">
                                <div class="col-md-6">
                                  <span><strong>Nombre:</strong> <?php echo $fila['NombreProd']?></span>
                                </div>
                                <div class="col-md-6">
                                  <ul class="list-unstyled">
                                  <p><strong>SKU:</strong> <?php echo $fila['SKU']?></p>
                                </div>
                              </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Stocks:</strong> <?php echo $fila['Stock']?></div>
                                  <div class="col-md-6"><strong>Marca:</strong>
                                    <?php 
                                      $query1 = "SELECT * FROM Marcas m 
                                                  INNER JOIN Productos p
                                                  ON p.Marcas_IdMarca = m.IdMarca
                                                  WHERE p.IdProducto = '".$fila['IdProducto']."'";
                                      $resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
                                      $fila1 = mysql_fetch_array($resultado1);
                                      echo $fila1['Marca']; 
                                    ?>
                                  </div>
                                </div>
                                <div class="row">
                                </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Categoria:</strong>
                                    <?php 
                                      $query2 = "SELECT * FROM Categorias c
                                                  INNER JOIN Productos p
                                                  ON p.Categorias_IdCategoria = c.IdCategoria
                                                  WHERE p.IdProducto = ".$fila['IdProducto'];
                                      $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                      while($fila2 = mysql_fetch_array($resultado2)) { 
                                        echo $fila2['Categoria'];
                                      }
                                    ?>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6"><strong>Subcategoria:</strong>
                                    <?php 
                                      $query2 = "SELECT * FROM Subcategoria s
                                                  INNER JOIN Productos p
                                                  ON p.Subcategoria_IdSubcategoria = s.IdSubcategoria
                                                  WHERE p.IdProducto = ".$fila['IdProducto'];
                                      $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                      while($fila2 = mysql_fetch_array($resultado2)) { 
                                        echo $fila2['Subcategoria'];
                                      }
                                    ?>
                                  </div>
                                </div>
                              </ul>
                            </div>
                            <div class="col-xs-4 text-center">
                              <?php 
                                $query3 = "SELECT * FROM Productos_has_Imagenes WHERE Productos_IdProducto = '".$fila['IdProducto']."'";
                                $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
                                $fila3 = mysql_fetch_array($resultado3);
                              ?>
                              <a href="editProduct.php?id=<?php echo $fila['IdProducto'];?>"><img src="../images/products/<?php echo $fila3['NombreImagen']; ?>" alt="" class="img-rounded img-responsive img_details"></a>
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-8 emphasis">
                              <p class="ratings">
                                Lista: <strike><?php echo '$ '.$fila['PrecioLista'].'.00'?></strike>
                                Failbox: <?php echo '$ '.$fila['PrecioFailbox'].'.00'?>
                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-4 emphasis text-right">
                              <?php if ($fila['Estatus'] == 'Activo') { ?>
                                <a href="editEstatus.php?id=<?php echo $fila['IdProducto'];?>&estatus=Inactivo" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="¿Desactivar?">
                                  <?php echo $fila['Estatus'];?>
                                </a>
                              <?php } else { ?>
                                <a href="editEstatus.php?id=<?php echo $fila['IdProducto'];?>&estatus=Activo" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Activar?">
                                  <?php echo $fila['Estatus'];?>
                                </a>
                              <?php } ?>
                              <a href="editProduct.php?id=<?php echo $fila['IdProducto'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
                              <a href="../delete/deleteProduct.php?id=<?php echo $fila['IdProducto']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                        <?php } 
                        echo "<div class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;''>";
                          echo "<nav>";
                            echo "<ul class='pagination pagination-split'>";
                              if ($total_paginas > 1) {
                                if ($pagina != 1) {
                                    echo "<li>";
                                      echo '<a href="editProducts.php?pagina='.($pagina-1).'"><span title="Primer Pagina"aria-hidden="true">&laquo;</span></a>';
                                    echo "</li>";
                                } 
                                  for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pagina == $i) {
                                      //si muestro el indice de la pagina actual, no coloco enlace
                                      echo "<li><a style='background:#A5A9AC; color:#FFFFFF;'>";
                                        echo $pagina;
                                      echo "</a></li>";
                                    } else {
                                      //si el indice no corresponde con la pagina mostrada actualmente,
                                      //coloco el enlace para ir a esa pagina
                                        echo "<li>";
                                          echo '<a href="editProducts.php?pagina='.$i.'">'.$i.'</a>';
                                        echo "</li>";
                                    }
                                  }
                                  if ($pagina != $total_paginas) { 
                                    echo "<li>";
                                      echo '<a href="editProducts.php?pagina='.($pagina+1).'"><span title="Ultima Pagina" aria-hidden="true">&raquo;</span></a>';
                                    echo "</li>";
                                  }
                                }
                              echo "</li>";
                            echo "</ul>";
                          echo "</nav>";
                        echo "</div>";
                      }

                    } ?>
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

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>

  <script src="../js/custom.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>

   <style >
    .row.buscar {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .col-xs-4 {
        flex: 0 0 100%;
        width: auto;
    }
    </style>
    </body>

</body>

</html>
