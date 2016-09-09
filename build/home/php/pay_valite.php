<?php
    // Primera comprobación. Cerraremos este if más adelante
    if($_POST){
        // Obtenemos los datos en formato variable1=valor1&variable2=valor2&...
        $raw_post_data = file_get_contents('php://input');

        // Los separamos en un array
        $raw_post_array = explode('&',$raw_post_data);

        // Separamos cada uno en un array de variable y valor
        $myPost = array();
        foreach($raw_post_array as $keyval){
            $keyval = explode("=",$keyval);
            if(count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // Nuestro string debe comenzar con cmd=_notify-validate
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')){
            $get_magic_quotes_exists = true;
        }
        foreach($myPost as $key => $value){
            // Cada valor se trata con urlencode para poder pasarlo por GET
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }

            //Añadimos cada variable y cada valor
            $req .= "&$key=$value";
        }

        // $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');   // Esta URL debe variar dependiendo si usamos SandBox o no. Si lo usamos, se queda así.
        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');         // Si no usamos SandBox, debemos usar esta otra linea en su lugar.
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            // Ooops, error. Deberiamos guardarlo en algún log o base de datos para examinarlo después.
            curl_close($ch);
            exit;
        }
        curl_close($ch);
                if (strcmp ($res, "VERIFIED") == 0) {
            /**
             * A partir de aqui, deberiamos hacer otras comprobaciones rutinarias antes de continuar. Son opcionales, pero recomiendo al menos las dos primeras. Por ejemplo:
             *
             * * Comprobar que $_POST["payment_status"] tenga el valor "Completed", que nos confirma el pago como completado.
             * * Comprobar que no hemos tratado antes la misma id de transacción (txd_id)
             * * Comprobar que el email al que va dirigido el pago sea nuestro email principal de PayPal
             * * Comprobar que la cantidad y la divisa son correctas
             */

            // Después de las comprobaciones, toca el procesamiento de los datos.

            /**
             * En este punto tratamos la información.
             * Podemos hacer con ella muchas cosas:
             *
             * * Guardarla en una base de datos.
             * * Guardar cada linea del pedido en una linea diferente en la base de datos.
             * * Guardar un log.
             * * Restar las cantidades de los artículos del stock.
             * * Enviar un mensaje de confirmcaión al cliente.
             * * Enviar un mensaje al encargado de pedidos para que lo prepare.
             * * Comprobar mediante complejas operaciones matemáticas si el cliente es el número un millon y notificarle de que ha ganado dos noches de hotel en Torrevieja.
             * * ¡Imaginación!
             */

            require_once("../admin/db/conexion.php");

            /* Email Failbox*/
            $id_pedido = $_GET['num'];
            $query4 = "SELECT * FROM Pedidos pe INNER JOIN DatosEnvios dte ON dte.IdPedido = pe.IdPedido WHERE pe.IdPedido = '".$id_pedido."'";
            $result4 = mysql_query($query4,Conectar::con()) or die (mysql_error());
            $field = mysql_fetch_array($result4);

            if(count($field)>1){

                $query = "UPDATE Pedidos SET Status = 1 WHERE IdPedido = '$id_pedido'";
                $result = mysql_query($query,Conectar::con()) or die (mysql_error());

                $orden_pedido = $field['OrdenPedido'];
                $nombre_cliente = $field['Nombre'];
                $apellidos_cliente = $field['Apellido'];
                $email_cliente = $field['Email'];
                // $email_cliente = 'jvazcruz28@gmail.com';
                $telefono_cliente = $field['Telefono'];
                $telefono_cliente_cel = $field['Celular'];
                $fecha_pedido = $field['FechaPedido'];
                $fecha_entrega = $field['FechaEntrega'];
                $id_pedido = $field['IdPedido'];

                // $to = "pepe@paratodohayfans.com";
                $to = "francisco@paratodohayfans.com";
                $subject = 'Compra Online FAILBOX';
                $message = "<html><head></head><body>";
                $message .= "<h1><img src='http://failbox.mx/home/test/admin/images/logo_failbox.png' width='200px' height='auto'></h1>";
                $message .= "<span style='font-family:Gotham-Light;'>Gracias por su interes en los Productos de Failbox. <br>Su Orden ha sido recibida y será procesada una vez el Pago haya sido confirmado.</span>";
                ?>
                <?php
                $message .= "<table style='width:70%;margin-top: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;border-right: 1px solid #70B14C !important;'>Detalles de la Orden</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;'></th>
                              </tr>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                    ID de Orden: $orden_pedido<br>
                                    Fecha de Orden: $fecha_pedido<br>
                                    Fecha de Pago: $fecha_entrega<br>
                                </td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                    Email: $email_cliente<br>
                                    Teléfono: $telefono_cliente<br>
                                    Celular: $telefono_cliente_cel<br>
                                </td>
                              </tr>
                            </table>";

                $query6 = "SELECT * FROM DatosEnvios
                          WHERE IdPedido =  $id_pedido";
                $result6 = mysql_query($query6) or die(mysql_error());
                $lineresult = mysql_fetch_array($result6);
                if(mysql_num_rows($result6)>0){

                    $message .= "<table style='width:70%;margin-top: 2%;margin-bottom: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family: Gotham-Light;background: #70B153;color: #FFF;'>Dirección de Pago</th>
                              </tr>
                              <tr>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                    $nombre_cliente<br>
                                    ".$lineresult['Direccion']."<br>
                                    ".$lineresult['Colonia']."<br>
                                    ".$lineresult['CP']."<br>
                                    ".$lineresult['Ciudad']."<br>
                                    ".$lineresult['Estado']."<br>
                                </td>
                              </tr>
                            </table>";


                    $query5 = "SELECT * FROM Productos_has_Pedidos pp
                              INNER JOIN Productos p ON p.IdProducto = pp.Productos_IdProducto
                              INNER JOIN Pedidos pe ON pe.IdPedido = pp.Pedidos_IdPedido
                              WHERE pp.Pedidos_IdPedido = $id_pedido";
                    $result5 = mysql_query($query5) or die(mysql_error());

                    $message .= "<table style='width:70%;margin-top: 2%;margin-bottom: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Imágen</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Producto</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Modelo</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Cantidad</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Precio</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Total</th>
                              </tr>
                    ";
                    $costo_envio = 0;
                    $sub_total = 0;
                    while ($line5 = mysql_fetch_array($result5)) {
                        $subtotal = $line5['Cantidad'] * $line5['Precio'];
                        $costo_envio = $costo_envio + $line5['CostoEnvio'];
                        $sub_total = $sub_total + $subtotal;
                        $images = explode(',', $line5['Image']);
                        $message .= "
                              <tr>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'><img src='http://failbox.mx/home/admin/images/products/".$images[0]."' width='80px' height='auto'></td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['NombreProd']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Modelo']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Cantidad']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Precio']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$subtotal."</td>
                              </tr>";

                    }

                     $message .= "
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Subtotal:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ $sub_total.00</th>
                            </tr>
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Costo Envío:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ $costo_envio.00</th>
                            </tr>
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Total:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ ".$field['Total'].".00</th>
                            </tr>
                            </table>";

                    $message .= "<div style='position: relative;width: 70%;height: 2%;padding-top: 2vw;padding-bottom: 2vw;background: #70B153;text-align: center;font-family: 'Gotham-Light';font-size: 1.1em;'>
                                    <span style='font-family:Gotham-Light;color: #FFFFFF;display: inline-block;padding-left: 3vw;padding-right: 3vw;font-weight: bold;'>©2016 FAILBOX - <a href='http://failbox.mx/home/' style='color:#58595B'>Compra más</a></span>
                                </div>";

                }else{
                    $message .= "<h4>Entrega en Failbox</h4><br>";
                }

                $message .= "</body></html>";

                $headers = "From: " . strip_tags($to) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($to) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                mail($to, $subject, $message, $headers);

                /* Email Cliente */
                $to = $email_cliente;
                // $to = "pepe@paratodohayfans.com";
                $email_failbox = "hola@failbox.mx";
                $subject = '!Tienda Failbox Online¡';
                $message = "<html><head></head><body>";
                $message .= "<h1><img src='http://failbox.mx/home/admin/images/logo_failbox.png' width='200px' height='auto'></h1>";
                $message .= "<span style='font-family:Gotham-Light;'>Gracias ".$nombre_cliente.' '.$apellidos_cliente." por tu compra en Failbox.<br>Proporcionaste los números teléfonicos: $telefono_cliente - $telefono_cliente_cel.<br></span>";
                $message .= "<span style='font-family:Gotham-Light;'><br></span>";
                $message .= "<span style='font-family:Gotham-Light;'>Tu orden de pedido es '".$orden_pedido."' por favor guárdalo para futuras aclaraciones.</span><br>";
                $message .= "<span style='font-family:Gotham-Light;'>La fecha de entrega será de 5 a 8 días hábiles.<br>";
                $message .= "<span style='font-family:Gotham-Light;'><br></span>";
                $message .= "<span style='font-family:Gotham-Light;'>Si tienes alguna duda o sugerencia mándanos un correo <br>a: hola@failbox.mx o llámanos al número: (33)    18-18-32-82.</span><br>";
                $message .= "<span style='font-family:Gotham-Light;'><br></span>";
                $message .= "<span style='font-family:Gotham-Light;'>A continuación se muestra los productos que ordenaste: </span>";
                ?>
                <?php
                $message .= "<table style='width:70%;margin-top: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;border-right: 1px solid #70B14C !important;'>Detalles de la Orden</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;'></th>
                              </tr>

                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family: 'Gotham-Light';>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family: 'Gotham-Light';>
                                    ID de Orden: $orden_pedido<br>
                                    Fecha de Orden: $fecha_pedido<br>
                                    Fecha de Pago: $fecha_entrega<br>
                                </td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family: 'Gotham-Light';>
                                    Email: $email_cliente<br>
                                    Teléfono: $telefono_cliente<br>
                                    Celular: $telefono_cliente_cel<br>
                                </td>
                              </tr>
                            </table>";

                $query6 = "SELECT * FROM DatosEnvios
                          WHERE IdPedido =  $id_pedido";
                $result6 = mysql_query($query6) or die(mysql_error());
                $lineresult = mysql_fetch_array($result6);
                if(mysql_num_rows($result6)>0){

                    $message .= "<table style='width:70%;margin-top: 2%;margin-bottom: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family: Gotham-Light;background: #70B153;color: #FFF;'>Dirección de Pago</th>
                              </tr>
                              <tr>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                                    $nombre_cliente<br>
                                    ".$lineresult['Direccion']."<br>
                                    ".$lineresult['Colonia']."<br>
                                    ".$lineresult['CP']."<br>
                                    ".$lineresult['Ciudad']."<br>
                                    ".$lineresult['Estado']."<br>
                                </td>
                              </tr>
                            </table>";


                    $query5 = "SELECT * FROM Productos_has_Pedidos pp
                              INNER JOIN Productos p ON p.IdProducto = pp.Productos_IdProducto
                              INNER JOIN Pedidos pe ON pe.IdPedido = pp.Pedidos_IdPedido
                              WHERE pp.Pedidos_IdPedido = $id_pedido";
                    $result5 = mysql_query($query5) or die(mysql_error());

                    $message .= "<table style='width:70%;margin-top: 2%;margin-bottom: 2%;border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>
                              <tr style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;background: #70B153;color: #FFF;'>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Imágen</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Producto</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Modelo</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Cantidad</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Precio</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Total</th>
                              </tr>
                    ";
                    $costo_envio = 0;
                    $sub_total = 0;
                    while ($line5 = mysql_fetch_array($result5)) {
                        $subtotal = $line5['Cantidad'] * $line5['Precio'];
                        $costo_envio = $costo_envio + $line5['CostoEnvio'];
                        $sub_total = $sub_total + $subtotal;
                        $images = explode(',', $line5['Image']);
                        $message .= "
                              <tr>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'><img src='http://failbox.mx/home/admin/images/products/".$images[0]."' width='80px' height='auto'></td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['NombreProd']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Modelo']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Cantidad']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$line5['Precio']."</td>
                                <td style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>".$subtotal."</td>
                              </tr>";

                    }

                     $message .= "
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Subtotal:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ $sub_total.00</th>
                            </tr>
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Costo Envío:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ $costo_envio.00</th>
                            </tr>
                            <tr>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border: 1px solid white;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;border-right: 1px solid #97999c;border-bottom: 1px solid #FFF;'></th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>Total:</th>
                                <th style='border: 1px solid #97999c;border-collapse: collapse;padding: 5px;text-align: center;font-family:Gotham-Light;'>$ ".$field['Total'].".00</th>
                            </tr>
                            </table>";

                    $message .= "<div style='position: relative;width: 70%;height: 2%;padding-top: 2vw;padding-bottom: 2vw;background: #70B153;text-align: center;font-family: 'Gotham-Light';font-size: 1.1em;'>
                                    <span style='font-family:Gotham-Light;color: #FFFFFF;display: inline-block;padding-left: 3vw;padding-right: 3vw;font-weight: bold;'>©2016 FAILBOX - <a href='http://failbox.mx/home/' style='color:#58595B'>Compra más</a></span>
                                </div>";

                }else{
                    $message .= "<h4>Entrega en Failbox</h4><br>";
                }

                $message .= "</body></html>";

                $headers = "From: " . strip_tags($email_failbox) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($to) . "\r\n";
                $headers .= "CC: 'pepe@paratodohayfans.com'\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                mail($to, $subject, $message, $headers);

            }else{

            }

        } else if (strcmp ($res, "INVALID") == 0) {
            // El estado que devuelve es INVALIDO, la información no ha sido enviada por PayPal. Deberías guardarla en un log para comprobarlo después
        }
    } else {    // Si no hay datos $_POST
        // Podemos guardar la incidencia en un log, redirigir a una URL...
    }
?>
