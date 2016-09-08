<?php 
session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
    if (isset($_GET['idProvider'])) {
    $sql = "SELECT * FROM Proveedores WHERE idProveedor = '".$_GET['idProvider']."'";
    $result = mysql_query($sql,Conectar::con()) or die(mysql_error());
    if (mysql_num_rows($result) == 0) {
      header("Location: edit_providers.php");
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
                    <li><a href="list_providers.php">Proveedores</a>
                    </li>
                    <li><a href="create_provider.php">Crear</a>
                    </li>
                    <li><a href="edit_providers.php">Editar</a>
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
                  <li>
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
                Mi Perfil
                <small> Edita y/o corrige detalles de mi perfil de proveedor.</small>
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
                      $idProvider = $_GET['idProvider'];
                      $query = "SELECT * FROM Proveedores WHERE idProveedor = '".$idProvider."'";
                      $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                      $fila = mysql_fetch_array($resultado);
                    ?>
                  <div class="col-md-4 col-sm-7 col-xs-12 text-center">
                    <div class="product-image">
                      <img src="../images/profileProvider/<?php echo $fila['ImageProfile']; ?>" alt="..." />
                    </div>
                  </div>

                  <div class="col-md-8 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                    <h3 class="prod_title">#ID Proveedor: <?php echo $_GET['idProvider']?></h3>
                    <form class="form-horizontal form-label-left" id="formEditProvider" name="formEditProviderData" enctype="multipart/form-data">
                        <div class="col-sm-5">
                          <input type="text" name="idProveedor" value="<?php echo $fila['idProveedor'];?>" hidden>
                          <div class="form-group code_provider">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="modelo">Código proveedor
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="code" type="text" name="code" required="" placeholder="" class="form-control col-md-7 col-xs-12" value="<?php echo $fila['CodigoProveedor']; ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Razón Social 
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12 ">
                              <input id="reason_social" class="form-control col-md-7 col-xs-12" name="reason_social" placeholder="Nombre del proveedor" required="" type="text" value="<?php echo $fila['RazonSocial']?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">Estado
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12" id="StateSelected">
                              <?php 
                                $query = "SELECT * FROM Estados ORDER BY Estado ASC";
                                $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                  echo "<select id='selectState' name='state' class='form-control' required>";
                                while($row2 = mysql_fetch_array($resultado)){
                                  if ($fila['Estados_IdEstado'] == $row2['IdEstado']) {
                                    echo "<option selected value='".$row2['IdEstado']."'>". $row2['Estado']."</option>";
                                  } else {
                                    echo "<option value='".$row2['IdEstado']."'>". $row2['Estado']."</option>";
                                  }
                                }
                                  echo "</select>";
                              ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">Ciudad
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12" id="CitySelected">
                              <?php 
                                $query = "SELECT * FROM Ciudades ORDER BY Ciudad ASC";
                                $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                  echo "<select id='city' name='city' class='form-control' required>";
                                while($row2 = mysql_fetch_array($resultado)){
                                  if ($fila['Ciudades_IdCiudad'] == $row2['IdCiudad']) {
                                    echo "<option selected value='".$row2['IdCiudad']."'>". $row2['Ciudad']."</option>";
                                  } else {
                                    echo "<option value='".$row2['IdCiudad']."'>". $row2['Ciudad']."</option>";
                                  }
                                }
                                  echo "</select>";
                              ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Dirección
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="address" class="form-control col-md-7 col-xs-12" name="address" placeholder="Calle y número" required="" type="text" value="<?php echo $fila['Direccion']?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Colonia
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="colony" class="form-control col-md-7 col-xs-12" name="colony" placeholder="Colonia" required="" type="text" value="<?php echo $fila['Colonia']?>">
                            </div>
                          </div>
                          <div class=" form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">C.P.
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="cp" class="form-control col-md-7 col-xs-12" name="cp" placeholder="Código Postal" required="" type="text" value="<?php echo $fila['CP']?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stocks">Tel.
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="tel" class="form-control col-md-7 col-xs-12" name="tel" placeholder="Número de teléfono" required="" type="text" value="<?php echo $fila['Telefono']?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warranty">Email 
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Correo Electónico" required="" type="email" value="<?php echo $fila['Email']?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="pricelist">Tipo Proveedor
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <?php 
                                $query = "SELECT * FROM TipoProveedor ORDER BY TipoProveedor ASC";
                                $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                    echo "<select id='type_provider' name='type_provider' class='form-control' required>";
                                while($row2 = mysql_fetch_array($resultado)){
                                  if ($fila['TipoProveedor_idTipoProveedor'] == $row2['idTipoProveedor']) {
                                    echo "<option selected value='".$row2['idTipoProveedor']."'>". $row2['TipoProveedor']."</option>";
                                  } else {
                                    echo "<option value='".$row2['idTipoProveedor']."'>". $row2['TipoProveedor']."</option>";
                                  }
                                }
                                    echo "</select>";
                                ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="pricefailbox">Costo de envío
                            </label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <select id="selectOutstanding" required class="form-control" name="outstanding">
                                <?php if ($fila['CostoEnvio'] == 1) { ?>
                                <option value="2">NO</option>
                                <option selected value="1">SI</option>
                                <?php } else if ($fila['CostoEnvio'] == 2) { ?>
                                <option selected value="2">NO</option>
                                <option value="1">SI</option>
                                <?php } ?>
                              </select>
                            </div>
                            <p class="help-block"> ¿Incluye costo de envío?</p>
                          </div>
                          <div class="form-group price_outstanding">
                            <label for="sku" class="control-label col-md-4">Paquete $</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input id="small" type="number" name="priceSmall" min="0" class="form-control col-md-7 col-xs-12" placeholder="Chico" value="<?php echo $fila['PaqChico']?>">
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input id="medium" type="number" name="priceMedium" min="0" class="form-control col-md-7 col-xs-12" placeholder="Mediano" value="<?php echo $fila['PaqMediano']?>">
                            </div>
                          </div>
                          <div class="form-group price_outstanding">
                            <label for="sku" class="control-label col-md-4"></label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input id="big" type="number" name="priceBig" min="0" class="form-control col-md-7 col-xs-12" placeholder="Grande" value="<?php echo $fila['PaqGrande']?>">
                            </div>
                          </div>
                          <div class=" form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="cost_shipping">Usuario
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input id="user" class="form-control col-md-7 col-xs-12" name="user" placeholder="Nombre de Usuario" required="" type="text" value="<?php echo $fila['User']?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="sku">Imagen Perfil
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input required="" type="file" class="form-control" id="profile-home" name="profileImage[]">
                              <p class="help-block"> (Requerido: 2133×547px)</p>
                              <div class="result_provider"></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                              <a href="../listProducts.php" class="btn btn-danger">Cancelar</a>
                              <button type="submit" class="btn btn-primary">Siguiente</button>
                            </div>
                          </div>
                        </div>
                    </form>
                    <br>
                    <div class="col-sm-5">
                      <div class="form-group">
                        <div class="col-md-10 col-md-offset-3">
                          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">¿Cambiar contraseña?</a>
                          
                          <!-- Modal -->
                          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <form id="formChangePassProvider">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Cambiar la Contraseña</h4>
                                  </div>
                                  <div class="modal-body">
                                    <label class="control-label col-md-3" for="past_password">Contraseña anterior
                                    </label>
                                    <div class=" form-group">
                                      <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" name="idProveedor" value="<?php echo $fila['idProveedor'];?>" hidden>
                                        <input id="past_password" class="form-control col-md-7 col-xs-12" name="past_password" placeholder="Nombre de Usuario" required="" type="password">
                                      </div>
                                    </div>
                                  </div><br>
                                  <div class="modal-body">
                                    <label class="control-label col-md-3" for="new_password">Nueva contraseña
                                    </label>
                                    <div class=" form-group">
                                      <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="new_password" class="form-control col-md-7 col-xs-12" name="new_password" placeholder="Nueva contraseña" required="" type="password">
                                      </div>
                                    </div>
                                  </div><br>
                                  <div class="modal-body">
                                    <label class="control-label col-md-3" for="repeat_password">Repetir contraseña
                                    </label>
                                    <div class=" form-group">
                                      <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="repeat_password" class="form-control col-md-7 col-xs-12" name="repeat_password" placeholder="Repite contraseña" required="" type="password">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-body">
                                    <label class="control-label col-md-3" for="repeat_password">
                                    </label>
                                    <div class=" form-group">
                                      <div class="col-md-8 col-sm-6 col-xs-12">
                                        <div class="result_change_pass"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="sumbit" class="btn btn-primary">Enviar y guardar</button>
                                  </div>
                                </form>
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
    $(".code_provider").hide();
    var value_array = '<?php echo $fila['CostoEnvio']?>';
    if (value_array == 1) {
      $(".price_outstanding").show();
      $("#small").prop( "disabled", false );
      $("#small").prop( "required", true );
      $("#medium").prop('disabled',false);
      $("#medium").prop('required',true);
      $("#big").prop('disabled',false);
      $("#big").prop('required',true);
    } else if (value_array == 2) {
      $(".price_outstanding").hide();
      $("#small").prop( "disabled", true );
      $("#medium").prop('disabled',true);
      $("#big").prop('disabled',true);
    };

    $("#selectOutstanding").change(function () {
      var value = $("option:selected", this).attr('value');
      if (value == 1) {
        $(".price_outstanding").show();
        $("#small").prop( "disabled", false );
        $("#small").prop( "required", true );
        $("#medium").prop('disabled',false);
        $("#medium").prop('required',true);
        $("#big").prop('disabled',false);
        $("#big").prop('required',true);
      } else {
        $(".price_outstanding").hide();
        $("#small").prop( "disabled", true );
        $("#medium").prop('disabled',true);
        $("#big").prop('disabled',true);
      }; 
    });
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
    $("#selectState").change(function () {
        var idState = $("option:selected", this).attr('value');
        var namefunction = 'getChangeCity';
        $.ajax({
            url: "../php/functions.php",
            type: "POST",
            data: {
                namefunction: namefunction,
                idState: idState
            },
            success: function (result) {
                $('#CitySelected select').html(result);
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