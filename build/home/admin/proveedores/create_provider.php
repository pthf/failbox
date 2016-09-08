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
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="../images/user.png" alt=""><?php echo $_SESSION['Usuario']?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
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

                                    <div class="tab-content">
                                      <div id="home" class="tab-pane fade in active">
                                        <form class="form-horizontal form-label-left" id="formNewTypeProvider" name="formNewProviderData" enctype="multipart/form-data">
                                            <div class="col-sm-5"><br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Agregar Tipo
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required class='form-control' type="text" name="other_provider" placeholder="Agrega un tipo de proveedor">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <button type="submit" class="btn btn-success">Agregar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal form-label-left" id="formNewProvider" name="formProviderData" enctype="multipart/form-data">
                                            <div class="col-sm-5"><br>
                                                <div class="form-group code_provider">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="modelo">Código proveedor
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php 
                                                        $query = "SELECT MAX(idProveedor) as idProveedor FROM Proveedores";
                                                        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                        $row = mysql_fetch_array($resultado);
                                                        date_default_timezone_set('UTC');
                                                        date_default_timezone_set("America/Mexico_City");
                                                        $datatime = date("Y-m-d");
                                                        $code = 'PROV-'.$datatime.$row['idProveedor'];
                                                        ?>
                                                        <input id="code" type="text" name="code" required="" placeholder="" class="form-control col-md-7 col-xs-12" value="<?php echo $code; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="reason_social">Razón Social 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="reason_social" class="form-control col-md-7 col-xs-12" name="reason_social" placeholder="Nombre del proveedor" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">Estado 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php 
                                                        $query = "SELECT * FROM Estados ORDER BY Estado ASC";
                                                        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                            echo "<select id='selectState' name='state' class='form-control' required>";
                                                            echo "<option disabled selected value=''>Selecciona..</option>";
                                                        while($row2 = mysql_fetch_array($resultado)){
                                                            echo "<option value='".$row2['IdEstado']."'>". $row2['Estado']."</option>";
                                                        }
                                                            echo "</select>";
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">Ciudad 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class='form-control' id="selectCity" required name="city">
                                                            <option disabled selected value="">Selecciona..</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Dirección 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="address" class="form-control col-md-7 col-xs-12" name="address" placeholder="Calle y número" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="colony">Colonia 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="colony" class="form-control col-md-7 col-xs-12" name="colony" placeholder="Colonia" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cp">C.P. 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="cp" class="form-control col-md-7 col-xs-12" name="cp" placeholder="Código Postal" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tel">Tel. 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="tel" class="form-control col-md-7 col-xs-12" name="tel" placeholder="Número de teléfono" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Correo Electónico" required="" type="email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5"><br>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="providerType">Tipo de Proveedor   
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php 
                                                        $query = "SELECT * FROM TipoProveedor ORDER BY TipoProveedor ASC";
                                                        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                            echo "<select id='type_provider' name='type_provider' class='form-control' required>";
                                                            echo "<option disabled selected value=''>Selecciona..</option>";
                                                        while($row2 = mysql_fetch_array($resultado)){
                                                            echo "<option value='".$row2['idTipoProveedor']."'>". $row2['TipoProveedor']."</option>";
                                                        }
                                                            echo "</select>";
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Estatus
                                                    </label>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <select id="status" required class="form-control" name="status">
                                                            <option disabled selected value="">Selecciona..</option>
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="outstanding">Costo de envío
                                                    </label>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <select id="selectOutstanding" required class="form-control" name="outstanding">
                                                            <option disabled selected value="">Selecciona..</option>
                                                            <option value="1">Sí</option>
                                                            <option value="2">No</option>
                                                        </select>
                                                    </div>
                                                        <p class="help-block"> ¿Incluye costo de envío?</p>
                                                </div>
                                                <div class="form-group price_outstanding">
                                                    <label for="sku" class="control-label col-md-3">Precio por paquete $</label>
                                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                                        <input id="small" type="number" name="priceSmall" min="0" class="form-control col-md-7 col-xs-12" placeholder="Chico">
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                                        <input id="medium" type="number" name="priceMedium" min="0" class="form-control col-md-7 col-xs-12" placeholder="Mediano">
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                                        <input id="big" type="number" name="priceBig" min="0" class="form-control col-md-7 col-xs-12" placeholder="Grande">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Usuario 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="user" class="form-control col-md-7 col-xs-12" name="user" placeholder="Nombre de Usuario" required="" type="text">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="password" class="form-control col-md-7 col-xs-12" name="password" placeholder="Contraseña" required="" type="password">
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="repeat_password">Repetir Contraseña
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="repeat_password" class="form-control col-md-7 col-xs-12" name="repeat_password" placeholder="Contraseña" required="" type="password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="profile-home" class="control-label col-md-3 col-sm-3 col-xs-12">Imagen Perfil</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="" type="file" class="form-control" id="profile-home" name="profileImage[]">
                                                        <p class="help-block"> (Requerido: 2133×547px)</p>
                                                        <div class="result_provider"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a href="list_providers.php" class="btn btn-danger">Cancelar</a>
                                                        <button type="submit" class="btn btn-primary">Siguiente</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                        </form>
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
                $(".code_provider").hide();
                $(".price_outstanding").hide();
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
                $("#selectState").change(function () {
                    var idState = $("option:selected", this).attr('value');
                    var namefunction = 'getStatesProvider';
                    $.ajax({
                        url: "../php/functions.php",
                        type: "POST",
                        data: {
                            namefunction: namefunction,
                            idState: idState
                        },
                        success: function (result) {
                            // alert(result);
                            $('#selectCity').html(result);
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