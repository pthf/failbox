<?php
if(!isset($_SESSION['idAdmin']))
    header("Location: index.php");
require_once("../db/conexion.php");

class Products
{
/* Hacemos la inserción en la base de datos y nos redirecciona a la página llamada listProducts.php */
	public function save_product($name_product,$description,$array_categorys,$brand,$stocks,$price,$discount,$modelo,$sku,$estatus,$images)
	{
		$sql_products = "INSERT INTO Productos VALUES (null,'".$name_product."','".$description."','".$stocks."','".$price."','".$discount."','".$modelo."','".$sku."','".$estatus."','".$images."')";
		$res = mysql_query($sql_products,Conectar::con()) or die(mysql_error());

		//Obtenemos el ultimo id añadido en la tabla Productos
		$id_producto = mysql_insert_id();

		//Insertamos los datos con relacion a la tabla Productos_has_Categorias
		for ($i=0; $i < count($array_categorys); $i++) { 
			$sql_category = "INSERT INTO Productos_has_Categorias VALUES ('".$id_producto."', '".$array_categorys[$i]."')";
			$res = mysql_query($sql_category,Conectar::con()) or die(mysql_error());
		}
		
		//Insertamos los datos con relacion a la tabla Productos_has_Marcas
		$sql_brand = "INSERT INTO Productos_has_Marcas VALUES ('".$id_producto."', '".$brand."')";
		$res = mysql_query($sql_brand,Conectar::con()) or die(mysql_error());
		
		echo"
		<script type='text/javascript'>
			alert('El registro del producto se realizó correctamente');
			window.location='../create/createCharacteristics.php?id=$id_producto';
		</script>";
	}

	public function save_changes($id,$idcategory,$idbrand,$name_product,$description,$array_categorys,$brand,$stocks,$price,$discount,$modelo,$sku,$estatus,$images) {

		//Realizamos los cambios de los datos a la tabla Productos
		$sql_changes_prod = "UPDATE Productos SET NombreProd='".$name_product."',Descripcion='".$description."', Stock='".$stocks."',Precio='".$price."', Descuento='".$discount."',Modelo='".$modelo."',SKU='".$sku."',Estatus='".$estatus."',Image='".$images."'
							 WHERE IdProducto = '".$id."'";
		$res = mysql_query($sql_changes_prod,Conectar::con()) or die(mysql_error());

		//Eliminamos el Id de las Relaciones con las Categorias que corresponde al Id Producto  para despues actualizar los datos,
		//Esto se hace ya que cuenta con un arreglo de un cierto limite de productos y el update no acepta modificaciones de mas de una insercion
		$sql = "DELETE FROM Productos_has_Categorias WHERE Productos_IdProducto = '".$id."' AND Categorias_IdCategoria='".$idcategory."'";
		$res = mysql_query($sql,Conectar::con()) or die(mysql_error());

		//Ciclo para verificar el arreglo de las categorias y realiza un select para verificar si existe un valor en la base de datos
		//similar al que se esta modificando y de ser asi, no reraliza la insecion. 
		//En caso de que no exista se insertan los valores
		for ($i=0; $i < count($array_categorys); $i++) { 
			$query_cat = "SELECT Categorias_IdCategoria FROM Productos_has_Categorias WHERE Productos_IdProducto='".$id."' AND Categorias_IdCategoria='".$array_categorys[$i]."'";
			$result_query = mysql_query($query_cat,Conectar::con()) or die(mysql_error());
			$row = mysql_num_rows($result_query);

			if ($row != 1) {
				$sql_category = "INSERT INTO Productos_has_Categorias VALUES ('".$id."', '".$array_categorys[$i]."')";
				$res = mysql_query($sql_category,Conectar::con()) or die(mysql_error());
			}
		} 

		//Se realizan los cambios de la marca en la base de datos
		$sql_changes_brand = "UPDATE Productos_has_Marcas SET Productos_IdProducto='".$id."', Marcas_IdMarca='".$brand."'
							  WHERE Productos_IdProducto='".$id."' AND Marcas_IdMarca='".$idbrand."'";
		$res = mysql_query($sql_changes_brand,Conectar::con()) or die(mysql_error());
		//Realizar los cambios de las categorias y de las marcas dependiendo la validacion de los parametros por GET que se reciben

		echo"
		<script type='text/javascript'>
			alert('El registro del producto se realizó correctamente');
			window.location='../listProducts.php';
		</script>";

	}

	public function save_characteristics($id,$type_characteristic,$characteristic){

		$query = "SELECT * FROM Productos_has_Caracteristicas WHERE Productos_IdProducto = '".$id."' AND Caracteristicas_IdCaracteristica = '".$type_characteristic."'";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row_type = mysql_num_rows($result);

		//Si el resultado de $row_type es igual a "0" es porque no existe en la tabla, pero si es "1", ya se tiene ese tipo de caracteristica registrada
		//Entonces continuamos con la validacion
		if ($row_type == 0) {

			$sql = "INSERT INTO Productos_has_Caracteristicas VALUES ('".$id."','".$type_characteristic."','".$characteristic."')";
			$res = mysql_query($sql,Conectar::con()) or die(mysql_error());

			echo"
			<script type='text/javascript'>
				window.location='../create/createCharacteristics.php?id=$id';
			</script>";

		} else {

			echo"
			<script type='text/javascript'>
				window.location='../create/createCharacteristics.php?id=$id';
			</script>";

		}

	}

}
class Buscador
{
	private $busqueda=array();
	
	public function buscar()
	{
        $busqueda = mysql_real_escape_string(addslashes($_GET['busqueda']));
        /*consulta fulltext con el motor myisam
        $query = "SELECT *, MATCH(titulo, cuerpo) AGAINST ('$busqueda') as buscado
              FROM posts
              WHERE MATCH(titulo, cuerpo)
              AGAINST ('$busqueda')
              ORDER BY buscado DESC";
        */
            //consulta con like y el motor innodb
	    $query = "SELECT * FROM Productos WHERE NombreProd like '%".$busqueda."%' OR Descripcion like '%".$busqueda."%';";
	    $res = mysql_query($query,Conectar::con());
	    while ($reg=mysql_fetch_assoc($res))
	    {
	        $this->busqueda[] = $reg;
        }
            return $this->busqueda;
	}
}
?>