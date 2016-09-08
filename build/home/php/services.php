<?php
	if(isset($_GET['namefunction'])){
		include ("../admin/db/conexion.php");

		$namefunction = $_GET['namefunction'];
		switch ($namefunction) {
			case 'getIdPedido':
				getIdPedido($_GET['id']);
				break;
		}
	}

	function getIdPedido($id){
		$query = "SELECT * FROM Pedidos WHERE IdPedido = '".$id."' AND Status = '1'";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		$dataIdPedido = array();
		while($line = mysql_fetch_array($result)){
			$dataIdPedido[] = array(
				'IdPedido' => $line['IdPedido'],
				'Total' => $line['Total'],
				'TotalNot' => $line['TotalList'],
				'Usuario' => $line['Usuarios_IdUsuario']
			);
		}
		echo json_encode($dataIdPedido);
	}
