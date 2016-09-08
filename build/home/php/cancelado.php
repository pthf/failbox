<?php 
    
    require_once("../admin/db/conexion.php");

    /* Email Failbox*/
    $id_pedido = $_GET['num'];
    $query4 = "SELECT * FROM Pedidos pe WHERE pe.IdPedido = '".$id_pedido."'";
    $result4 = mysql_query($query4,Conectar::con()) or die (mysql_error());
    $field = mysql_fetch_array($result4);

    if(count($field)>1){

        $query = "SELECT * FROM Productos p INNER JOIN Productos_has_Pedidos php ON php.Productos_IdProducto = p.IdProducto INNER JOIN Pedidos pe ON pe.IdPedido = php.Pedidos_IdPedido WHERE pe.IdPedido = $id_pedido";
        $result = mysql_query($query,Conectar::con()) or die (mysql_error());

        while ($row = mysql_fetch_array($result)) {

            $query1 = "SELECT Stock FROM Productos WHERE IdProducto = '".$row['IdProducto']."'";
            $result1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
            $row1 = mysql_fetch_array($result1);

            $return_total_stock = $row1['Stock'] + $row['Cantidad'];
            $query2 = "UPDATE Productos SET Stock = $return_total_stock WHERE IdProducto = '".$row['IdProducto']."'";
            $result2 = mysql_query($query2,Conectar::con()) or die (mysql_error());

        }
        
        header("Location: ../cancelado");

    }

?>