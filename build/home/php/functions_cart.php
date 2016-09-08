<?php
    include ("../admin/db/conexion.php");
    // connect_base_de_datos();
    session_start();
    // include('delete_session_cart.php'); 

    $namefunction = $_POST['namefunction'];
    switch($namefunction){

      case 'cambio_tamano':
        cambio_tamano();
        break;
      case 'cambio_cantidad':
        cambio_cantidad();
        break;
      case 'agregar_producto':
        agregar_producto();
        break;
      case 'actualizar_carrito':
        actualizar_carrito();
        break;
      case 'eliminar_item_cart':
        eliminar_item_cart();
        break;
      case 'incrementar_item_cart':
        incrementar_item_cart();
        break;
      case 'disminuir_item_cart':
        disminuir_item_cart();
        break;
      case 'actualizar_carrito_confirmar':
          actualizar_carrito_confirmar();
          break;
      case 'verificar_fecha':
          verificar_fecha();
          break;
      case 'colonia_change':
          colonia_change();
          break;
      case 'municipio_change':
          municipio_change();
          break;
      case 'cpostal_change':
          cpostal_change();
          break;
      case 'calcular_costo_final':
          calcular_costo_final();
          break;
      case 'registrar_datos_pago':
          registrar_datos_pago($_POST['total_cart'],$_POST['total_not_cart']);
          break;
      case 'registrar_factura':
          registrar_factura();
          break;
      case 'verify_day_end':
          verify_day_end();
          break;
      case 'verify_max_stock':
          verify_max_stock($_POST['idProduct'], $_POST['quantity']);
          break;
      case 'verify_stocks':
          verify_stocks($_POST['idProduct'], $_POST['quantity']);
          break;
      case 'verify_my_cart':
          verify_my_cart($_POST['idProduct'], $_POST['quantity']);
          break;
      case 'registrar_cupon':
        registrar_cupon();
        break;
    }

    function verify_max_stock($idProduct, $cantidad){

      if(isset($_SESSION['carrito'])){

        $total_cantidad_aux = 0;
        $resultvar = 1;
        $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
        $result = mysql_query($query,Conectar::con()) or die(mysql_error());
        $line = mysql_fetch_array($result);
        if(mysql_num_rows($result)>0){
          $stock_max = $line['Stock'];
            foreach ($_SESSION['carrito'] as $key => $value) {
              if($value['id_producto'] == $idProduct){
                $cantidad_cart = $value['cantidad'];
                $total_cantidad_aux = $cantidad_cart + $cantidad;
                // var_dump($total_cantidad_aux);
                $query = "SELECT Stock FROM Productos WHERE IdProducto =".$value['id_producto'];
                $result = mysql_query($query,Conectar::con()) or die(mysql_error());
                $line = mysql_fetch_array($result);
                $stock_max = $line['Stock'];

                if($stock_max<$total_cantidad_aux)
                  $resultvar =  0;
                else
                  $resultvar =  1;
                break;
              }
            }
        }
        echo $resultvar;

      } else {

        $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
        $result = mysql_query($query,Conectar::con()) or die(mysql_error());
        $line = mysql_fetch_array($result);
        if(mysql_num_rows($result)>0){
          $stock_max = $line['Stock'];
          if($stock_max<$cantidad)
            echo 0;
          else
            echo 1;
        }

      }
    }

    /*
    * Description: check remaining products.
    * return int
    */

    function verify_my_cart($idProduct, $cantidad){

        $total_cantidad_aux = 0;
        $resultvar = 1;

        if(isset($_SESSION['carrito'])){

            $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            $line = mysql_fetch_array($result);
            if(mysql_num_rows($result)>0){

                $stock_max = $line['Stock'];

                foreach ($_SESSION['carrito'] as $key => $value) {

                    if($value['id_producto'] == $idProduct) {

                        $cantidad_cart = $value['cantidad'];
                        // $total_cantidad_aux = $cantidad + 1;
                        $total_cantidad_aux = ($cantidad_cart + $cantidad);
                        $query = "SELECT Stock FROM Productos WHERE IdProducto =".$value['id_producto'];
                        $result = mysql_query($query,Conectar::con()) or die(mysql_error());
                        $line = mysql_fetch_array($result);
                        $stock_max = $line['Stock'];
                        $my_real_cart = $stock_max - $cantidad;
                        $total = $stock_max - ( $cantidad_cart + $cantidad );
                        echo $total;
                        break;
                    } else {
                        $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
                        $result = mysql_query($query,Conectar::con()) or die(mysql_error());
                        $line = mysql_fetch_array($result);
                        if(mysql_num_rows($result)>0){
                            $stock_max = $line['Stock'];
                            echo (int)$stock_max - (int)$cantidad;
                        }
                        break;
                    }
                }
            }

        } else {

            $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            $line = mysql_fetch_array($result);
            if(mysql_num_rows($result)>0){
                $stock_max = $line['Stock'];
                echo (int)$stock_max - (int)$cantidad;
            }
        }
    }

    function verify_stocks($idProduct, $cantidad){

      $total_cantidad_aux = 0;
      $resultvar = 1;
      $query = "SELECT Stock FROM Productos WHERE IdProducto =".$idProduct;
      $result = mysql_query($query,Conectar::con()) or die(mysql_error());
      $line = mysql_fetch_array($result);
      if(mysql_num_rows($result)>0){
        $stock_max = $line['Stock'];
        foreach ($_SESSION['carrito'] as $key => $value) {
          if($value['id_producto'] == $idProduct){
            $cantidad_cart = $value['cantidad'];
            // $total_cantidad_aux = $cantidad + 1;
            $total_cantidad_aux = ($cantidad_cart + $cantidad);
            $query = "SELECT Stock FROM Productos WHERE IdProducto =".$value['id_producto'];
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            $line = mysql_fetch_array($result);
            $stock_max = $line['Stock'];
            if($stock_max<$total_cantidad_aux)
              $resultvar =  0;
            else
              $resultvar =  1;
            break;
          }
        }
      }
      echo $resultvar;

    }

    function cambio_tamano(){

      $id_tamano = $_POST['id_tamano'];
      $id_producto = $_POST['id_producto'];

      $query = "SELECT precio FROM detalle_tamano WHERE id_tamano_producto = ".$id_tamano." AND id_producto = ".$id_producto;
      $result = mysql_query($query) or die(mysql_error());
      $line = mysql_fetch_array($result);

      echo $line['precio'];

    }

    function cambio_cantidad(){

      $id_tamano = $_POST['id_tamano'];
      $id_producto = $_POST['id_producto'];

      if($id_tamano!=0){
        $query = "SELECT precio FROM detalle_tamano WHERE id_tamano_producto = ".$id_tamano." AND id_producto = ".$id_producto;
        $result = mysql_query($query) or die(mysql_error());
        $line = mysql_fetch_array($result);
        echo $line['precio'];
      }else{
        $query = "SELECT precio_producto FROM producto WHERE id_producto = ".$id_producto;
        $result = mysql_query($query) or die(mysql_error());
        $line = mysql_fetch_array($result);
        echo $line['precio_producto'];
      }

    }

    //Agregar productos al carrito.
    function agregar_producto(){

      if(isset($_SESSION['carrito'])){

        $id_producto = $_POST['idProduct'];
        $precio = $_POST['notprice'];
        $cantidad = $_POST['quantity'];
        $sub_total = $precio*$cantidad;

        $arreglo_carrito = $_SESSION['carrito'];
        $find = false;

        foreach ($arreglo_carrito as $key => $value) {
          if($arreglo_carrito[$key]['id_producto'] == $id_producto)
            $find = true; 
        }

        if ($find == true) {
          for ($i=0; $i < count($arreglo_carrito); $i++) { 
            if ($id_producto == $arreglo_carrito[$i]['id_producto']) {
              if ($cantidad == 1) {

                $arreglo_carrito[$i]['cantidad'] = $arreglo_carrito[$i]['cantidad'] + 1;
                $arreglo_carrito[$i]['sub_total'] = $arreglo_carrito[$i]['cantidad'] * $arreglo_carrito[$i]['precio'];

              } else if ($cantidad > 1) {

                $arreglo_carrito[$i]['cantidad'] = $arreglo_carrito[$i]['cantidad'] + $cantidad;
                $arreglo_carrito[$i]['sub_total'] = $arreglo_carrito[$i]['cantidad'] * $arreglo_carrito[$i]['precio'];

              }
            }
          }

          $_SESSION['carrito'] = $arreglo_carrito;
          $_SESSION['expire']=time();

        } else {

          $query = "SELECT * FROM Productos WHERE IdProducto =".$id_producto;
          $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          $line = mysql_fetch_array($result);

          $images = explode(',', $line['Image']);
          $arreglo_descr_producto = array(
            'id_producto' => $id_producto,
            'nombre_producto' => $line['NombreProd'],
            'descripcion_producto' => $line['Descripcion'],
            'foto_producto' => $images[0],
            'id_categoria' => $line['Categorias_IdCategoria'],
            'id_subcategoria' => $line['Subcategoria_IdSubcategoria'],
            'id_marca' => $line['Marcas_IdMarca'],
            'cantidad' => $cantidad,
            'precio_lista' => $line['PrecioLista'],
            'precio' => $precio,
            'sub_total' => $sub_total,
            'costo_envio' => $line['CostoEnvio']
          );

          array_push($arreglo_carrito, $arreglo_descr_producto);
          $_SESSION['carrito'] = $arreglo_carrito;
          $_SESSION['expire']=time();

        }

          // print_r($_SESSION['carrito']);

      } else {
        $id_producto = $_POST['idProduct'];
        $precio = $_POST['notprice'];
        $cantidad = $_POST['quantity'];
        $sub_total = $precio*$cantidad;

          $query = "SELECT * FROM Productos WHERE IdProducto =".$id_producto;
          $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          $line = mysql_fetch_array($result);

          $images = explode(',', $line['Image']);
          $arreglo_descr_producto[] = array(
            'id_producto' => $id_producto,
            'nombre_producto' => $line['NombreProd'],
            'descripcion_producto' => $line['Descripcion'],
            'foto_producto' => $images[0],
            'id_categoria' => $line['Categorias_IdCategoria'],
            'id_subcategoria' => $line['Subcategoria_IdSubcategoria'],
            'id_marca' => $line['Marcas_IdMarca'],
            'cantidad' => $cantidad,
            'precio_lista' => $line['PrecioLista'],
            'precio' => $precio,
            'sub_total' => $sub_total,
            'costo_envio' => $line['CostoEnvio']
          );

          $_SESSION['carrito'] = $arreglo_descr_producto;
          $_SESSION['expire']=time(); 

      } 

    }

    //Eliminar producto del carrito.
    function eliminar_item_cart(){
      $idItemCart = $_POST['idItemCart'];
      $arreglo_carrito = $_SESSION['carrito'];
      foreach ($arreglo_carrito as $key => $value) {
        if($arreglo_carrito[$key]['id_producto'] == $idItemCart){
          unset($arreglo_carrito[$key]);
        }
      }

      $_SESSION['carrito'] = $arreglo_carrito;
      $_SESSION['expire']=time();

      if(count($_SESSION['carrito']) == 0){
        unset($_SESSION['carrito']);
        unset($_SESSION['total_carrito']);
        unset($_SESSION['id_pedido']);
        unset($_SESSION['descuento-aplicado']);
        unset($_SESSION['descuento']);
      }

    }

    //Disminuir cantidad de un articulo.
    function disminuir_item_cart(){
      if (isset($_SESSION['carrito'])) {
        $idItemCart = $_POST['idItemCart'];
        $arreglo_carrito = $_SESSION['carrito'];

        foreach ($arreglo_carrito as $key => $value) {
          if($arreglo_carrito[$key]['id_producto'] == $idItemCart){

            $arreglo_carrito[$key]['cantidad'] = $arreglo_carrito[$key]['cantidad'] - 1;
            $arreglo_carrito[$key]['sub_total'] = $arreglo_carrito[$key]['cantidad'] * $arreglo_carrito[$key]['precio'];

            if($arreglo_carrito[$key]['cantidad']==0){
              unset($arreglo_carrito[$key]);
            }
          }
        }

        $_SESSION['carrito'] = $arreglo_carrito;
        $_SESSION['expire']=time();

        if(count($_SESSION['carrito']) == 0){
          unset($_SESSION['carrito']);
          unset($_SESSION['total_carrito']);
          unset($_SESSION['id_pedido']);
          unset($_SESSION['descuento-aplicado']);
          unset($_SESSION['descuento']);
        }
      }
    }

    //Aumentar cantidad de un articulo.
    function incrementar_item_cart(){

      $idItemCart = $_POST['idItemCart'];
      $arreglo_carrito = $_SESSION['carrito'];

      foreach ($arreglo_carrito as $key => $value) {
        if($arreglo_carrito[$key]['id_producto'] == $idItemCart){

          $arreglo_carrito[$key]['cantidad'] = $arreglo_carrito[$key]['cantidad'] + 1;
          $arreglo_carrito[$key]['sub_total'] = $arreglo_carrito[$key]['cantidad'] * $arreglo_carrito[$key]['precio'];

          if($arreglo_carrito[$key]['cantidad']==0){
            unset($arreglo_carrito[$key]);
          }
        }
      }

      $_SESSION['carrito'] = $arreglo_carrito;
      $_SESSION['expire']=time();

      if(count($_SESSION['carrito']) == 0){
        unset($_SESSION['carrito']);
        unset($_SESSION['total_carrito']);
        unset($_SESSION['id_pedido']);
        unset($_SESSION['descuento-aplicado']);
        unset($_SESSION['descuento']);
      }

    }

    //En esta parte, actualizaremos la parte del carrito frontend, mostrando cada cambio al instante.
    function actualizar_carrito(){

        if(isset($_SESSION['carrito'])){
          $total = 0;
          $costo_envio = 0;
          for ($i=0; $i < count($_SESSION['carrito']); $i++) { 
            $total = $total + $_SESSION['carrito'][$i]["sub_total"];
            $costo_envio = $costo_envio + $_SESSION['carrito'][$i]['costo_envio'];
          }

          // echo '
          //         <div class="act_cont">
          //           <div class="total_buy">
          //             <span>TOTAL</span>
          //           </div>
          //               <span class="price_total">$'.number_format($total,2,".",",").'</span>
          //               <a href="carrito.php"> <span class="gotocart">IR AL CARRITO</span> </a>
          //               <span class="alertaCapMax"></span>
          //           </div>
          //   ';

          // $_SESSION['costo_envio'] = $costo_envio;
          $total_total = $total + $costo_envio;
          $_SESSION['total_carrito'] = $total_total;
          $_SESSION['carrito'] = $_SESSION['carrito'];
          $_SESSION['expire']=time();

        }else{

          echo "No hay sesion actualizar_carrito";
          echo '
            <div class="g_cart_cont"><br>
              <div class="price_total">
                <span>NO HAZ AGREGADO NINGÚN PRODUCTO.</span>
              </div><br>
              <div class="total_buy">
                <span>TOTAL</span>
              </div>
              <span class="price_total">$00.00</span>
              </div>
              <span class="alertaCapMax"></span>
          ';
          
        }

    }

    //Actualizamos el carrito de la session confirma
    function actualizar_carrito_confirmar(){
      $resultado = 1;
      if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $value) {
          $query = "SELECT Stock FROM Productos WHERE IdProducto = '".$value['id_producto']."'";
          $result = mysql_query($query,Conectar::con())or die(mysql_error());
          $row = mysql_fetch_array($result);
          if ($row['Stock'] == 0) {
            $resultado = $value['id_producto'];
            unset($_SESSION['carrito'][$key]); 
            if(count($_SESSION['carrito']) == 0){
              unset($_SESSION['carrito']);
              unset($_SESSION['total_carrito']);
              unset($_SESSION['id_pedido']);
              unset($_SESSION['descuento-aplicado']);
              unset($_SESSION['descuento']);
            }
          } else if ($value['cantidad'] > $row['Stock']) {
            $resultado = -1;
            $_SESSION['carrito'][$key]['cantidad'] = $row['Stock'];
          } else {
            $total_stock = ($row['Stock'] - $value['cantidad']);
            $query = "UPDATE Productos SET Stock = '".$total_stock."' WHERE IdProducto = '".$value['id_producto']."'";
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            unset($_SESSION['carrito']);
            unset($_SESSION['total_carrito']);
            unset($_SESSION['id_pedido']);
            unset($_SESSION['descuento-aplicado']);
            unset($_SESSION['descuento']);
            $resultado = 1;
          }
        }
        echo $resultado;
      }
    }

    function verify_day_end(){
      $dia_final = $_POST['dia_final'];
      $mes_final_val = $_POST['mes_final_val']+1;
      $anio_final = $_POST['anio_final'];
      $time = strtotime($mes_final_val.'/'.$dia_final.'/'.$anio_final);
      $dateStringCompare = date('Y-m-d',$time);
      $counter = 0;
      $dayAccept = false;
      while(!$dayAccept){
        $change = false;
        foreach ($_SESSION['carrito'] as $key => $value) {
          $query = "SELECT * FROM block_date_product WHERE dateBlock = '$dateStringCompare' AND idProduct = ".$value["id_producto"];
          $result = mysql_query($query) or die(mysql_error());
          if(mysql_num_rows($result)>0){
            $change = true;
            $counter++;
            $dateIncrement = strtotime("+1 day", strtotime($dateStringCompare));
            $dateStringCompare = date('Y-m-d',$dateIncrement);
          }else{
            $q1 = "SELECT sum(detalle_pedido.cantidad) AS sumatoria FROM pedido INNER JOIN detalle_pedido
                   ON pedido.id_pedido = detalle_pedido.id_pedido
                   WHERE detalle_pedido.id_producto = ".$value["id_producto"]."
                   AND pedido.fecha_entrega = '".$dateStringCompare."'
                   AND pedido.status = 1";
            $r1 = mysql_query($q1) or die(mysql_error());
            $l1 = mysql_fetch_array($r1);
            $cant = $l1['sumatoria'] + $value["cantidad"];
            $q2 = "SELECT horas_produccion FROM producto WHERE id_producto = ".$value["id_producto"];
            $r2 = mysql_query($q2) or die(mysql_error());
            $l2 = mysql_fetch_array($r2);
            $stock = $l2['horas_produccion'];
            if($cant>$stock){
              $change = true;
              $counter++;
              $dateIncrement = strtotime("+1 day", strtotime($dateStringCompare));
              $dateStringCompare = date('Y-m-d',$dateIncrement);
            }
          }
        }
        if($change){
          $dayAccept = false;
        }else{
           $dayAccept = true;
        }
      }
      $data = array(
        'counter' => $counter,
        'fecha' => $dateStringCompare
      );
      echo json_encode($data);
    }

    //En esta funcion vamos a verificar la fecha y solamente daremos los dias que estan permitidos laborar.
    function verificar_fecha(){
        $select_month = $_POST['select_month'];
        $select_year = $_POST['select_year'];
        $query = "SELECT * FROM close_date WHERE month = ".$select_month;
        $result = mysql_query($query) or die(mysql_error());
        $array_no_days[] = "";
        while($line = mysql_fetch_array($result)){
            $close_date = array(
                'day' => $line['day'],
                'year' => $line['year'],
                'month' => $line['month']
            );
            array_push($array_no_days,$close_date);
        }

        //Aqui se agrega al array $array_no_days los dias bloqueados que se superaron.
        switch ($select_month) {
            case 1: case 3: case 5: case 7: case 8: case 10: case 12:
            echo '<select class="comprar_select select_day" name="select_day">';
                for($i=1; $i<=31; $i++ ){
                    $found = 0;
                    foreach ($array_no_days as $key => $value) {
                        if($i==$array_no_days[$key]['day'] && $select_year == $array_no_days[$key]['year'])
                            $found=1;
                    }

                    if($found==0){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'" name="bloqueado" >'.$i.'</option>';
                    }

                }
            echo "</select>";
            break;
            case 2:
            echo '<select class="comprar_select select_day" name="select_day">';
                for($i=1; $i<=28; $i++ ){
                    $found = 0;
                    foreach ($array_no_days as $key => $value) {
                        if($i==$array_no_days[$key]['day'] && $select_year == $array_no_days[$key]['year'])
                            $found=1;
                    }

                    if($found==0){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'" name="bloqueado" >'.$i.'</option>';
                    }

                }
            echo "</select>";
            break;
            case 4: case 6: case 9: case 11:
            echo '<select class="comprar_select select_day" name="select_day">';
                for($i=1; $i<=30; $i++ ){
                    $found = 0;
                    foreach ($array_no_days as $key => $value) {
                        if($i==$array_no_days[$key]['day'] && $select_year == $array_no_days[$key]['year'])
                            $found=1;
                    }

                    if($found==0){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'" name="bloqueado" >'.$i.'</option>';
                    }

                }
            echo "</select>";
            break;
        }
        echo '
        <select class="comprar_select select_month" name="select_month">
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
        <select class="comprar_select select_year" name="select_year">
            <option name="1" value="2016">2016</option>
            <option name="2" value="2017">2017</option>
            <option name="3" value="2018">2018</option>
        </select>
        ';
    }

    function registrar_datos_pago($total_cart,$total_not_cart){
          
      parse_str($_POST['action'],$formData);

      date_default_timezone_set('UTC');
      date_default_timezone_set("America/Mexico_City");
      $datatime = date("Y-m-d H:i:s");
      $datatime_ = date("Y-m-d H:i:s");

      if (isset($_SESSION['id_pedido'])) {

        $query = "SELECT * FROM Pedidos WHERE IdPedido = '".$_SESSION['id_pedido']."'"; 
        $result = mysql_query($query,Conectar::con()) or die(mysql_error());
        $num_row = mysql_num_rows($result);
        if ($num_row > 0) {
          $row = mysql_fetch_array($result);
          $query1 = "UPDATE Pedidos SET FechaPedido = '".$datatime."', FechaEntrega = '".$datatime_."', Total='".$total_cart."', TotalList='".$total_not_cart."' WHERE IdPedido = '".$_SESSION['id_pedido']."'";
          $result1 = mysql_query($query1,Conectar::con()) or die(mysql_error());

          foreach ($_SESSION['carrito'] as $key => $value) {
            $query = "SELECT * FROM Productos_has_Pedidos WHERE Pedidos_IdPedido = '".$_SESSION['id_pedido']."' AND Productos_IdProducto = '".$value['id_producto']."'";
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            $row = mysql_num_rows($result);
            if ($row > 0) {
              $query5 = "UPDATE Productos_has_Pedidos SET Cantidad = '".$value['cantidad']."', Precio = '".$value['precio']."', CostoEnvio = '".$value['costo_envio']."' 
                                                    WHERE Pedidos_IdPedido = '".$_SESSION['id_pedido']."' AND Productos_IdProducto = '".$value['id_producto']."'";
              $result5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
            } else {
              $query5 = "INSERT INTO Productos_has_Pedidos VALUES ('".$value['id_producto']."','".$_SESSION['id_pedido']."','".$value['cantidad']."','".$value['precio']."','".$value['costo_envio']."')";
              $result5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
            }
          }

          $query2 = "UPDATE DatosEnvios SET TipoDireccion='".$formData['typeAddress']."',Estado='".$formData['state']."',Ciudad='".$formData['city']."',
                                            Direccion='".$formData['address']."',Colonia='".$formData['colony']."',CP='".$formData['cp']."',
                                            Telefono='".$formData['tel']."',Celular='".$formData['cel']."',Nombre='".$formData['name']."',Apellido='".$formData['lastname']."',
                                            Email='".$formData['email']."' WHERe IdPedido='".$_SESSION['id_pedido']."'";
          $result2 = mysql_query($query2,Conectar::con()) or die(mysql_error());                                  
        }

      } else {

          if (isset($_SESSION['carrito'])) {
            $orden_pedido = "NULL";
            $query3 = "INSERT INTO Pedidos VALUES (null,'".$orden_pedido."','$datatime', '$datatime_','0', '".$total_cart."', '".$total_not_cart."', 1) ";
            $result3 = mysql_query($query3,Conectar::con()) or die(mysql_error());

            $idPedido = mysql_insert_id();
            $_SESSION['id_pedido'] = $idPedido;

            $orden_pedido = "PAYFAILBOX".$idPedido.date("Y").date("m").date("d");
            $query = "UPDATE Pedidos SET OrdenPedido = '$orden_pedido' WHERE IdPedido = $idPedido";
            $result = mysql_query($query,Conectar::con()) or die(mysql_error());

            foreach ($_SESSION['carrito'] as $key => $value) {
              $query5 = "INSERT INTO Productos_has_Pedidos VALUES ('".$value['id_producto']."','".$idPedido."','".$value['cantidad']."','".$value['precio']."','".$value['costo_envio']."')";
              $result5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
            }

            $query4 = "INSERT INTO DatosEnvios VALUES (null,'".$formData['typeAddress']."', '".$formData['state']."', '".$formData['city']."', 
                                                    '".$formData['address']."', '".$formData['colony']."', '".$formData['cp']."', 
                                                    '".$formData['tel']."','".$formData['cel']."', '".$formData['name']."', '".$formData['lastname']."', 
                                                    '".$formData['email']."','".$idPedido."')";
            $result4 = mysql_query($query4,Conectar::con()) or die(mysql_error());
          } else {
            echo -1;
          }
      }

    }

    function registrar_cupon () {
      parse_str($_POST['action'],$formData);
      date_default_timezone_set('UTC');
      date_default_timezone_set("America/Mexico_City");
      $date = date('Y-m-d');
      if (!isset($_SESSION['descuento-aplicado'])) {
        if (isset($_SESSION['id_pedido'])) {
          // foreach ($_SESSION['carrito'] as $key => $value) {
          //   $query = "SELECT * FROM Productos WHERE IdProducto = '".$value['id_producto']."'";
          //   $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          //   $row = mysql_fetch_array($result);
          //   if ($row['CodigoCupon'] == $formData['cupon']) {
          //     if ($row['FechaInicio'] == $date) {
          //       $descuento = ($value['precio'] * $row['Descuento'])/100;
          //       $precio_descuento = ($value['precio'] - $descuento) * $value['cantidad'];
          //       $_SESSION['carrito'][$key]['sub_total'] = $precio_descuento;
          //       $_SESSION['total_carrito'] = $_SESSION['total_carrito'] - $precio_descuento;
          //       $_SESSION['descuento-aplicado'] = 1;
          //       $query = "UPDATE Pedidos SET Total = '".$_SESSION['total_carrito']."' WHERE IdPedido = '".$_SESSION['id_pedido']."'";
          //       $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          //     }
          //   }
          // }
          $query = "SELECT * FROM Cupones WHERE CodigoCupon = '".$formData['cupon']."'";
          $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          $row = mysql_fetch_array($result);
          $num_row = mysql_num_rows($result);
          if ($num_row > 0) {
            $_SESSION['descuento'] = $row['Descuento']/100;
            $descuento = ($_SESSION['total_carrito'] * $row['Descuento'])/100;
            $precio_descuento = $_SESSION['total_carrito'] - $descuento;
            $_SESSION['total_carrito'] = $precio_descuento;
            $_SESSION['descuento-aplicado'] = 1;
            $query1 = "UPDATE Pedidos SET Total = '".$_SESSION['total_carrito']."' WHERE IdPedido = '".$_SESSION['id_pedido']."'";
            $result1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
            echo 1;
          } else {
            echo 0;
          }
        } else {
          // foreach ($_SESSION['carrito'] as $key => $value) {
            // $query = "SELECT * FROM Productos WHERE IdProducto = '".$value['id_producto']."'";
            // $result = mysql_query($query,Conectar::con()) or die(mysql_error());
            // $row = mysql_fetch_array($result);
            // if ($row['CodigoCupon'] == $formData['cupon']) {
            //   if ($row['FechaInicio'] == $date) {
            //     $descuento = ($value['precio'] * $row['Descuento'])/100;
            //     $precio_descuento = ($value['precio'] - $descuento) * $value['cantidad'];
            //     $_SESSION['carrito'][$key]['sub_total'] = $precio_descuento;
            //     $_SESSION['total_carrito'] = $_SESSION['total_carrito'] - $precio_descuento;
            //     $_SESSION['descuento-aplicado'] = 1;
            //   }
            // }
            // }
          $query = "SELECT * FROM Cupones WHERE CodigoCupon = '".$formData['cupon']."'";
          $result = mysql_query($query,Conectar::con()) or die(mysql_error());
          $row = mysql_fetch_array($result);
          $num_row = mysql_num_rows($result);
          if ($num_row > 0) {
            $_SESSION['descuento'] = $row['Descuento']/100;
            $descuento = ($_SESSION['total_carrito'] * $row['Descuento'])/100;
            $precio_descuento = $_SESSION['total_carrito'] - $descuento;
            $_SESSION['total_carrito'] = $precio_descuento;
            $_SESSION['descuento-aplicado'] = 1;
            echo 1;
          } else {
            echo 0;
          }
        }

      } else if(isset($_SESSION['descuento-aplicado']) == 1){
        echo -1;
      }
    }

?>
