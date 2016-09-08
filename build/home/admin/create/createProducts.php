<?php 
  session_start();
  if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
  require_once("../db/conexion.php");
  if (isset($_GET['id'])) {
    $sql = "SELECT * FROM Productos WHERE IdProducto = '".$_GET['id']."'";
    $result = mysql_query($sql,Conectar::con()) or die(mysql_error());
    if (mysql_num_rows($result) == 0) {
      header("Location: createProducts.php");
    }
    $id_producto = $_GET['id'];
  }
  // print_r($_SESSION);
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
        <script>
         $(function(){   
           $("#image").on("change", function(){
               /* Limpiar vista previa */
               $("#vista-previa").html('');
               var archivos = document.getElementById('image').files;
               var navegador = window.URL || window.webkitURL;
               /* Recorrer los archivos */
               for(x=0; x<archivos.length; x++)
               {
                   /* Validar tamaño y tipo de archivo */
                   var size = archivos[x].size;
                   var type = archivos[x].type;
                   var name = archivos[x].name;
                   if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif')
                   {
                       $("#vista-previa").append("<p style='color: red'>El archivo "+name+" no es del tipo de imagen permitida.</p>");
                       $('#vista-previa').hide(8000);
                   }
                   // else
                   // {
                   //   var objeto_url = navegador.createObjectURL(archivos[x])
                   //   $("#vista-previa").append("<img src="+objeto_url+" width='250px' height='250px'>");
                   // }
               }
           });
           
           $("#btn").on("click", function(){
                var formData = new FormData($("#formulario")[0]);
                var ruta = "../class/functionImage.php";
                var id = "<?php echo $id_producto?>";
                $.ajax({
                    url: ruta+"?id="+id,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(datos)
                    {
                      if (datos == 0) {
                          alert('Error, tipo de archivo no es una imagen o no has cargado ningun archivo.');
                          $('#formulario')[0].reset();
                      } else if (datos == 1) {
                          alert('La imagen ha sido guardada con éxito.');
                          location.reload();
                      } else if (datos == -1) {
                          alert('Error, la imagen ya existe.');
                          $('#formulario')[0].reset();
                      };
                    }
                });
               });
           
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
                                    <li><a href="createProducts.php">Crear</a>
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
                                    <li><a href="../proveedores/edit_providers.php">Editar</a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                              <ul class="nav side-menu">
                                <li><a><i class="fa fa-picture-o"></i> Banners <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu" style="display: none">
                                    <li><a href="banners_home.php">Banners Principal</a>
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
                                    Crear Producto
                                    <small>
                                        Crea un nuevo producto con sus caracteristicas.
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
                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Proveedor 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <?php if($_SESSION['idPrivilegio'] == 1) { 
                                                          $query2 = "SELECT * FROM Proveedores pr";
                                                          $resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
                                                            echo "<select id='name_provider' name='name_provider' class='form-control' required>";
                                                            echo "<option disabled selected value=''>Selecciona..</option>";
                                                          while($row2 = mysql_fetch_array($resultado2)) {
                                                            echo "<option value='".$row2['idProveedor']."'>". $row2['RazonSocial']."</option>";
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
                                                            <option disabled selected value=''>Selecciona..</option>
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
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_provider">Proveedor 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="name_provider" class="form-control col-md-7 col-xs-12" name="name_provider" placeholder="Nombre del proveedor" type="text" required>
                                                        <div class="result"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Nombre Producto 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required id="name_product" class="form-control col-md-7 col-xs-12" name="name_product" placeholder="Nombre del producto" type="text">
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
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warranty">Garantía 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required class="form-control" name="warranty">
                                                            <option selected disabled value=''>Selecciona..</option>
                                                            <option value="1">6 meses</option>
                                                            <option value="2">1 año</option>
                                                            <option value="3">2 años</option>
                                                            <option value="4">3 años</option>
                                                        </select>
                                                    </div>
                                                </div>
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
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cost_shipping">Costo de envío 
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php if($_SESSION['idPrivilegio'] == 1) { ?>
                                                      <select required class="form-control" name="cost_shipping">
                                                          <option selected disabled value=''>Selecciona..</option>
                                                          <option value="0">Envio Gratis</option>
                                                          <option value="99">5 Kg $98.79</option>
                                                          <option value="120">10 Kg $120.00</option>
                                                          <option value="135">15 Kg $134.98</option>
                                                      </select>
                                                    <?php } else { 
                                                      $query3 = "SELECT pr.CostoEnvio,pr.PaqChico,pr.PaqMediano,pr.PaqGrande FROM Proveedores pr WHERE User = '".$_SESSION['Usuario']."'";
                                                      $resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
                                                      $row3 = mysql_fetch_array($resultado3);
                                                      $arrayName = array($row3['PaqChico'],$row3['PaqMediano'],$row3['PaqGrande']);

                                                      if ($row3['CostoEnvio'] == 2) {
                                                        echo "<select id='cost_shipping' name='cost_shipping' class='form-control' required>";
                                                        echo "<option value='0'>Envio Gratis</option>";
                                                        echo "</select>"; 
                                                      } else if ($row3['CostoEnvio'] == 1){
                                                          echo "<select id='cost_shipping' name='cost_shipping' class='form-control' required>";
                                                          echo "<option disabled selected>Selecciona..</option>";
                                                          echo "<option value='0'>Envio Gratis</option>";
                                                        for($i=0; $i<count($arrayName); $i++) {
                                                          echo "<option value='".$arrayName[$i]."'>".'$ '.$arrayName[$i].'.00'."</option>";
                                                        }
                                                        echo "</select>"; 
                                                      }

                                                    } ?>
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
                                                      <?php if ($_SESSION['idPrivilegio'] == 1) { ?>
                                                        <select required class="form-control" name="status">
                                                            <!-- <option disabled selected value=''>Selecciona..</option> -->
                                                            <option>Activo</option>
                                                            <option>Inactivo</option>
                                                        </select>
                                                      <?php } else { ?>
                                                        <select required class="form-control" name="status">
                                                            <option>Inactivo</option>
                                                        </select>
                                                      <?php } ?>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="outstanding">¿Producto destacado?
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required class="form-control" name="outstanding">
                                                            <option disabled selected value=''>Selecciona..</option>
                                                            <option>SI</option>
                                                            <option>NO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label for="url_paypal" class="control-label col-md-3">URL Paypal </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="url_paypal" type="text" name="url_paypal" class="form-control col-md-7 col-xs-12" required="" placeholder="URL Paypal">
                                                        <input hidden type="text" name="idPrivilegio" value="<?php echo $_SESSION['idPrivilegio'];?>">
                                                    </div>
                                                </div>
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
                                                        <button type="submit" value"Grabar" class="btn btn-info">Agregar</button>
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
                                                        <button type="submit" class="btn btn-primary" disabled >Guardar</button>
                                                        <p class="help-block"> "Para continuar necesitas crear un producto en la pestaña Productos".</p>
                                                        <?php } else { ?>
                                                        <button type="submit" class="btn btn-primary">Guadar</button>
                                                        <p class="help-block"> "Si ya terminaste de agregar las características, continua en la pestaña Imágenes".</p>
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
                                                            WHERE p.IdProducto = '".$_GET['id']."' ORDER BY ca.NombreCaracteristica ASC";
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
                                        <div class="col-sm-8"><br>
                                            <form class="form-horizontal form-label-left" method="post" id="formulario" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_characteristic">Subir imágen: 
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control" type="file" id="image" name="image[]" multiple required>
                                                        <p class="help-block"> Subir imágenes de tipo jpeg, jpg, png y tamaño minimo de 60 x 500 pixels.</p>
                                                    </div>
                                                    <!-- <div id="vista-previa"></div> -->
                                                    <div id="respuesta"></div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <button class="btn btn-primary" type="submit" id="btn">Subir imágenes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-6"><br>
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

                                      </div>
                                      <div id="menu3" class="tab-pane fade">
                                        <form class="form-horizontal form-label-left" name="new_category" action="" id="formNewCategory">
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
                                                        $query2 = "SELECT * FROM Categorias ORDER BY Categoria ASC";
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
                                                        $query = "SELECT * FROM Categorias ORDER BY Categoria ASC";
                                                        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
                                                            echo "<select id='category' name='category' class='form-control' required>";
                                                            echo "<option disabled selected value=''>Selecciona..</option>";
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
                                                        $query2 = "SELECT * FROM Subcategoria s ORDER BY Subcategoria ASC";
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
                                                        $query2 = "SELECT * FROM Marcas s ORDER BY Marca ASC";
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
