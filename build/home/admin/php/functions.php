<?php
require_once("../db/conexion.php");
	if(isset($_POST['namefunction'])){
		$namefunction = $_POST['namefunction'];
		switch ($namefunction) {
			case 'verifyPasswordLogin':
				verifyPasswordLogin();
				break;
			case 'addNewAdminUser':
				addNewAdminUser();
				break;
			case 'addNewCharacteristics':
				addNewCharacteristics();
				break;
			case 'changePassword':
				changePassword();
				break;
			case 'deleteAdmin':
				deleteAdmin();
				break;
			case 'getStatesUser':
				getStatesUser($_POST['idCategory']);
				break;
			case 'getStatesProvider':
				getStatesProvider($_POST['idState']);
				break;
			case 'addNewProduct':
				addNewProduct();
				break;
			case 'editProduct':
				editProduct();
				break;
			case 'addNewSubcategory':
				addNewSubcategory();
				break;
			case 'addNewCategory':
				addNewCategory();
				break;
			case 'getEditProduct':
				getEditProduct($_POST['idCategory']);
				break;
			case 'addImageBanner':
				addImageBanner();
				break;
			case 'deleteBannerHome':
				deleteBannerHome($_POST['dataBanner']);
				break;
			case 'cargaMasivaProductos':
				cargaMasivaProductos();
				break;
			case 'cargaMasivaCaracteristicas':
				cargaMasivaCaracteristicas();
				break;
			case 'cargaMasivaImages':
				cargaMasivaImages();
				break;
			case 'addNewTypeProvider':
				addNewTypeProvider();
				break;
			case 'addNewProvider':
				addNewProvider();
				break;
			case 'getChangeCity':
				getChangeCity($_POST['idState']);
				break;
			case 'editProvider':
				editProvider();
				break;
			case 'changePassProvider':
				changePassProvider();
				break;
			case 'actualizar_status_pedido':
				actualizar_status_pedido();
				break;
		}
	}

	function changePassword(){
		$idAdmin = $_POST['idAdmin'];
		$password = $_POST['password'];
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);

		$query = "UPDATE Usuarios SET Password = '$passwordhash' WHERE IdUsuario = $idAdmin";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
	}

	function deleteAdmin(){
			$idAdmin = $_POST['id'];
			$query = "DELETE FROM Usuarios WHERE IdUsuario = $idAdmin";
			$result = mysql_query($query,Conectar::con()) or die(mysql_error());
	}

	function addNewAdminUser(){
		$name = $_POST['username'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$typePerfil = $_POST['typePerfil'];
		$userPrivileges = $_POST['userPrivileges'];
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);

		$query = "INSERT INTO Usuarios (Nombre, Apellido, Email, Password, TipoPerfil, Privilegios, adminLastConnection) VALUES
																		('$name', '$lastname', '$email', '$passwordhash', '$typePerfil','$userPrivileges', '0000-00-00 00:00:00')";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
	}

	function verifyPasswordLogin(){

		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT * FROM Usuarios WHERE NombreUser = '$username'";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		if(mysql_num_rows($result) > 0){
			$find = false;
			while($line = mysql_fetch_array($result)){
				if(password_verify($password, $line['Password'])){
					$find = true;
					date_default_timezone_set('America/Mexico_City');
					$lastDate = date("Y-m-d H:i:s");
					$query2 = "UPDATE Usuarios SET UltimaConexion = '$lastDate' WHERE IdUsuario = ".$line['IdUsuario'];
					$result2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
					session_start();
					$_SESSION['idAdmin'] = $line['IdUsuario'];
					$_SESSION['Usuario'] = $line['NombreUser'];
					$_SESSION['idPrivilegio'] = $line['Privilegios'];
				}
			}
			if($find)
				echo 1;
			else
			 echo -1;
		}else{
			echo 0;
		}

	}

	function getStatesUser($id){

		$query = "SELECT * FROM Subcategoria WHERE Categorias_IdCategoria = $id ORDER BY Subcategoria ASC";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		echo '<option disabled selected value="">Selecciona..</option>';
		while ($line = mysql_fetch_array($result)) {
			echo '<option value="'.$line["IdSubcategoria"].'" name="'.$line["IdSubcategoria"].'">'.$line["Subcategoria"].'</option>';
		}

	}

	function getStatesProvider($id){

		$query = "SELECT * FROM Ciudades WHERE IdEstado = $id ORDER BY Ciudad ASC";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		echo '<option disabled selected value="">Selecciona..</option>';
		while ($line = mysql_fetch_array($result)) {
			echo '<option value="'.$line["IdCiudad"].'" name="'.$line["IdCiudad"].'">'.$line["Ciudad"].'</option>';
		}

	}

	function getEditProduct($id){

		$query = "SELECT * FROM Subcategoria WHERE Categorias_IdCategoria = $id ORDER BY Subcategoria ASC";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
			echo '<option disabled selected value="">Selecciona..</option>';
		while ($line = mysql_fetch_array($result)) {
			echo '<option value="'.$line["IdSubcategoria"].'" name="'.$line["IdSubcategoria"].'">'.$line["Subcategoria"].'</option>';
		}

	}

	function addNewProduct() {

		parse_str($_POST['action'],$formData);

	    date_default_timezone_set('UTC');
	    date_default_timezone_set("America/Mexico_City");
	    $datatime = date("Y-m-d H:i:s");

		$image = "null";

		$query = "SELECT * FROM Proveedores WHERE idProveedor = '".$formData['name_provider']."'";
		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row1 = mysql_fetch_array($resultado);

		$nombre_prod = scanear_string(strtolower($formData['name_product']));
		$nombre_prod = explode(' ', $nombre_prod);
		$nombres_filters = array_filter($nombre_prod);
		$nombre_prod = implode('-', $nombres_filters);

		$sql_products = "INSERT INTO Productos
							VALUES (null,'".$formData['name_provider']."','".$formData['name_product']."',
								'".$formData["description"]."','".$nombre_prod."','".$formData['stocks']."',
								'".$formData['pricelist']."','".$formData['pricefailbox']."',
								'".$formData['cost_shipping']."','".$formData['warranty']."',
								'".$formData['model']."','".$formData['sku']."',
								'".$formData['status']."','".$image."',
								'".$formData['url_paypal']."','".$formData['outstanding']."',
								'".$datatime."','".$formData['idPrivilegio']."',
								'".$formData['brand']."','".$formData['category']."',
								'".$formData['subcategory']."','".$row1['idProveedor']."')";
		$res = mysql_query($sql_products,Conectar::con()) or die(mysql_error());

		//Obtenemos el ultimo id añadido en la tabla Productos
		$rs = mysql_query("SELECT MAX(IdProducto) AS id FROM Productos",Conectar::con()) or die (mysql_error());
		if ($row = mysql_fetch_row($rs)) {
			$id = trim($row[0]);
			echo $id;
		}


	}

	function addNewCharacteristics() {

		parse_str($_POST['action'],$formData);

	    date_default_timezone_set('UTC');
	    date_default_timezone_set("America/Mexico_City");
	    $datatime = date("Y-m-d H:i:s");

	    $query = "SELECT * FROM Productos_has_Caracteristicas WHERE Productos_IdProducto = '".$formData['idProducto']."' AND Caracteristicas_IdCaracteristica = '".$formData['type_characteristic']."'";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row_type = mysql_num_rows($result);

		//Si el resultado de $row_type es igual a "0" es porque no existe en la tabla, pero si es "1", ya se tiene ese tipo de caracteristica registrada
		//Entonces continuamos con la validacion
		if ($row_type == 0) {

			$sql = "INSERT INTO Productos_has_Caracteristicas VALUES ('".$formData['idProducto']."','".$formData['type_characteristic']."','".$formData['characteristic']."')";
			$res = mysql_query($sql,Conectar::con()) or die(mysql_error());

			echo $formData['idProducto'];

		} else {

			echo $formData['idProducto'];

		}

	}

	function addNewSubcategory() {

		parse_str($_POST['action'],$formData);

		$query = "SELECT * FROM Subcategoria WHERE Categorias_IdCategoria = '".$formData['category']."' AND Subcategoria = '".$formData['other_subcategory']."'";
		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row = mysql_num_rows($resultado);

		if ($row == 0) {

			$nombre_subcat = scanear_string(strtolower($formData['other_subcategory']));
			$nombre_subcat = explode(' ', $nombre_subcat);
			$nombres_filters = array_filter($nombre_subcat);
			$nombre_subcat = implode('-', $nombres_filters);

			$sql = "INSERT INTO Subcategoria (IdSubcategoria, Subcategoria, RouteSubcategoria, Categorias_IdCategoria) VALUES ('','".$formData['other_subcategory']."','".$nombre_subcat."','".$formData['category']."')";
			$res = mysql_query($sql,Conectar::con()) or die(mysql_error());

			// $id = mysqli_insert_id();
			$rs = mysql_query("SELECT MAX(IdSubcategoria) AS id FROM Subcategoria",Conectar::con()) or die(mysql_error());
			if ($row = mysql_fetch_row($rs)) {
				$id = trim($row[0]);
			}
			// echo '<span style="color:blue">Se agrego correctamente...!!</span><br>';

		} else {

			// echo '<span style="color:red">Ya existe la subcategoria, intente de nuevo!!</span><br>';

		}

	}

	function addNewCategory() {

		parse_str($_POST['action'],$formData);

		$query = "SELECT Categoria FROM Categorias WHERE Categoria = '".$formData['other_category']."'";
		$result_query = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row = mysql_num_rows($result_query);

		if ($row == 0) {

			$nombre_cat = scanear_string(strtolower($formData['other_category']));
			$nombre_cat = explode(' ', $nombre_cat);
			$nombres_filters = array_filter($nombre_cat);
			$nombre_cat = implode('-', $nombres_filters);


			//registra las categorias de los productos
			$sql = "INSERT INTO Categorias (IdCategoria, Categoria, RouteCategoria) VALUES ('', '".$formData['other_category']."', '".$nombre_cat."')";
			$resultado_consulta_mysql = mysql_query($sql,Conectar::con()) or die(mysql_error());

			// echo '<span style="color:blue">Se agrego correctamente...!!</span><br>';

		} else {

			// echo '<span style="color:red">Ya existe la subcategoria, intente de nuevo!!</span><br>';

		}

	}

	function editProduct() {

	    parse_str($_POST['action'], $formData);

	    date_default_timezone_set('UTC');
	    date_default_timezone_set("America/Mexico_City");
	    $datatime = date("Y-m-d H:i:s");

		$nombre_prod = scanear_string(strtolower($formData['name_product']));
		$nombre_prod = explode(' ', $nombre_prod);
		$nombres_filters = array_filter($nombre_prod);
		$nombre_prod = implode('-', $nombres_filters);

	    //Realizamos los cambios de los datos a la tabla Productos
	    $sql_changes_prod = "UPDATE Productos
	                            SET NombreProveedor='".$formData['name_provider']."', NombreProd='" . $formData['name_product'] . "',
	                            	RouteProd='" .$nombre_prod. "', Descripcion='" . $formData["description"] . "',
	                                Stock='" . $formData['stocks'] . "', PrecioLista='" . $formData['pricelist'] . "',
	                                PrecioFailbox='" . $formData['pricefailbox'] . "', CostoEnvio='".$formData['cost_shipping']."',
	                                Modelo='" . $formData['model'] . "',
	                                SKU='" . $formData['sku'] . "', Estatus='" . $formData['estatus'] . "',
	                                urlPaypal='" . $formData['url_paypal'] . "',Destacado='" . $formData['outstanding'] . "',
	                                FechaAlta='".$datatime."', IdPrivilegio='" . $formData['idPrivilegio'] . "', Marcas_IdMarca='".$formData['brand']."', Categorias_IdCategoria='".$formData['category']."',
	                                Subcategoria_IdSubcategoria='".$formData['subcategory']."'
								WHERE IdProducto = '" . $formData['id'] . "'";
	    $res = mysql_query($sql_changes_prod,Conectar::con()) or die(mysql_error());

	    $id_product = $formData['id'];
	    echo $id_product;
	}

	function addImageBanner () {

		parse_str($_POST['action'], $formData);

		$fileNames = [];
		$indice = 0;
		foreach ($_FILES['failboxBannerImage']["error"]  as $key => $value) {
			$fileName = $_FILES["failboxBannerImage"]["name"][$key];
			$fileName = date("YmdHis").pathinfo($_FILES["failboxBannerImage"]["type"][$key], PATHINFO_EXTENSION);
			array_push($fileNames, $fileName);
			$fileType = $_FILES["failboxBannerImage"]["type"][$key];
			$fileTemp = $_FILES["failboxBannerImage"]["tmp_name"][$key];
			if($indice==0)
				move_uploaded_file($fileTemp, "../images/bannersHome/".$fileName);
			$indice++;
		}
		$query = "INSERT INTO BannersHome VALUES(null,'".$fileName."','".$formData['bannerUrl']."','".$formData['bannerName']."')";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());

	}

	function deleteBannerHome ($dataBanner) {

		$query = "DELETE FROM BannersHome WHERE idBannersHome = $dataBanner";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());

	}

	function scanear_string($string)
	{

	    $string = trim($string);

	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );

	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );

	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );

	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );

	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );

	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );

	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array('¨', 'º', '-', '~',
	             '#', '@', '|', '!', '"',
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "<", ";", ",", ":",
	             "."),
	        '',
	        $string
	    );


	    return $string;
	}

	function cargaMasivaProductos () {

		$fname = $_FILES['upload_products']['name'];

        $chk_ext = explode(".",$fname[0]);
        if(strtolower(end($chk_ext)) == "csv")
        {
          //si es correcto, entonces damos permisos de lectura para subir
          $filename = $_FILES['upload_products']['tmp_name'];
          $handle = fopen($filename[0], "r");
          $array_products = array();
          while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
          {
            array_push($array_products, $data);
          }
          date_default_timezone_set('UTC');
		  date_default_timezone_set("America/Mexico_City");
		  $datatime = date("Y-m-d H:i:s");

		  $array_id = array();
          for($i=1; $i < count($array_products); $i++){

   			// $convert_name = explode(' ', $array_products[$i][0]);
			// $convert_name = strtolower(implode('-', $convert_name));
			// $no_permitidas= array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","Ñ","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
			// $permitidas= array("a","e","i","o","u","A","E","I","O","U","N","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
			// $route_name = strtolower(str_replace($no_permitidas, $permitidas ,$convert_name));

			//Aqui estaba la funcion scanear_string_prod

			$nombre_prod = scanear_string(strtolower($array_products[$i][0]));
			$nombre_prod = explode(' ', $nombre_prod);
			$nombres_filters = array_filter($nombre_prod);
			$nombre_prod = implode('-', $nombres_filters);

			$query1 = "SELECT * FROM Categorias WHERE Categoria = '".$array_products[$i][14]."'";
			$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
			$num_row_cat = mysql_num_rows($resultado1);
			if ($num_row_cat == 0) {

				$category = $array_products[$i][14];
				$lower_category = strtolower($category);
				$capital_category = ucwords($lower_category);

				// $convert_name = explode(' ', $capital_category);
				// $convert_name = strtolower(implode('-', $convert_name));
				// $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","Ñ","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
				// $permitidas= array ("a","e","i","o","u","A","E","I","O","U","N","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
				// $route_name = strtolower(str_replace($no_permitidas, $permitidas ,$convert_name));



				$nombre_cat = scanear_string(strtolower($capital_category));
				$nombre_cat = explode(' ', $nombre_cat);
				$nombres_filters = array_filter($nombre_cat);
				$nombre_cat = implode('-', $nombres_filters);

				$sql = "INSERT INTO Categorias VALUES('', '".$capital_category."', '".$nombre_cat."')";
				$res = mysql_query($sql,Conectar::con()) or die(mysql_error());

			}

			$query6 = "SELECT * FROM Categorias WHERE Categoria = '".$array_products[$i][14]."'";
			$resultado6 = mysql_query($query6,Conectar::con()) or die(mysql_error());
			$fila = mysql_fetch_array($resultado6);

			$query2 = "SELECT * FROM Subcategoria WHERE Subcategoria = '".$array_products[$i][15]."' AND Categorias_IdCategoria = '".$fila[0]."'";
			$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
			$num_row_sub = mysql_num_rows($resultado2);

			if ($num_row_sub == 0) {

				$subcategory = $array_products[$i][15];
				$lower_subcategory = strtolower($subcategory);
				$capital_subcategory = ucwords($lower_subcategory);

				// $convert_name = explode(' ', $capital_subcategory);
				// $convert_name = strtolower(implode('-', $convert_name));
				// $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","Ñ","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
				// $permitidas= array ("a","e","i","o","u","A","E","I","O","U","N","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
				// $route_name = strtolower(str_replace($no_permitidas, $permitidas ,$convert_name));


				$nombre_subcat = scanear_string(strtolower($capital_subcategory));
				$nombre_subcat = explode(' ', $nombre_subcat);
				$nombres_filters = array_filter($nombre_subcat);
				$nombre_subcat = implode('-', $nombres_filters);

				$sql2 = "INSERT INTO Subcategoria VALUES('','".$capital_subcategory."','".$nombre_subcat."','".$fila[0]."')";
				$res2 = mysql_query($sql2,Conectar::con()) or die(mysql_error());

			}

			$query3 = "SELECT * FROM Marcas WHERE Marca = '".$array_products[$i][13]."'";
			$resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
			$num_row_brand = mysql_num_rows($resultado3);
			if ($num_row_brand == 0) {

				$brand = $array_products[$i][13];
				$lower_brand = strtolower($brand);
				$capital_brand = ucwords($lower_brand);

				// $convert_name = explode(' ', $capital_brand);
				// $convert_name = strtolower(implode('-', $convert_name));
				// $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","Ñ","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
				// $permitidas= array ("a","e","i","o","u","A","E","I","O","U","N","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
				// $route_name = strtolower(str_replace($no_permitidas, $permitidas ,$convert_name));


				$nombre_brand = scanear_string(strtolower($capital_brand));
				$nombre_brand = explode(' ', $nombre_brand);
				$nombres_filters = array_filter($nombre_brand);
				$nombre_brand = implode('-', $nombres_filters);

				$sql3 = "INSERT INTO Marcas VALUES('', '".$capital_brand."', '".$nombre_brand."')";
				$res3 = mysql_query($sql3,Conectar::con()) or die(mysql_error());

			}

			$sql4 = "SELECT * FROM Categorias WHERE Categoria = '".$array_products[$i][14]."'";
			$res4 = mysql_query($sql4,Conectar::con()) or die(mysql_error());
			$row1 = mysql_fetch_array($res4);

			$sql5 = "SELECT * FROM Subcategoria WHERE Subcategoria = '".$array_products[$i][15]."' AND Categorias_IdCategoria = '".$fila[0]."'";
			$res5 = mysql_query($sql5,Conectar::con()) or die(mysql_error());
			$row2 = mysql_fetch_array($res5);

			$sql6 = "SELECT * FROM Marcas WHERE Marca = '".$array_products[$i][13]."'";
			$res5 = mysql_query($sql6,Conectar::con()) or die(mysql_error());
			$row3 = mysql_fetch_array($res5);

			$array_images = explode('-', $array_products[$i][10]);
			$images = implode(',', $array_images);

            $query = "INSERT INTO Productos VALUES(null,'".$array_products[$i][16]."','".$array_products[$i][0]."','".$array_products[$i][1]."','".$nombre_prod."',
                    '".$array_products[$i][2]."','".$array_products[$i][3]."','".$array_products[$i][4]."','".$array_products[$i][5]."',
                    '".$array_products[$i][6]."','".$array_products[$i][7]."','".$array_products[$i][8]."','".(trim($array_products[$i][9]))."',
                    '".$images."','".$array_products[$i][11]."','".(strtoupper($array_products[$i][12]))."','".$datatime."',
                    '1','".$row3['IdMarca']."','".$row1['IdCategoria']."','".$row2['IdSubcategoria']."','2')";
	        $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

	        $rs = mysql_query("SELECT MAX(IdProducto) AS id FROM Productos",Conectar::con()) or die(mysql_error());
			if ($row = mysql_fetch_row($rs)) {
				$id = trim($row[0]);
				array_push($array_id, $id);

				$query4 = "SELECT IdProducto,Image FROM Productos WHERE IdProducto = '".$id."'";
	           	$resultado4 = mysql_query($query4,Conectar::con()) or die(mysql_error());
				while ($row4 = mysql_fetch_array($resultado4)) {
	           		$imagenes_prod = explode(',', $row4['Image']);
	           		for ($x=0; $x < count($imagenes_prod); $x++) {
	           			$query5 = "INSERT INTO Productos_has_Imagenes VALUES('".$row4['IdProducto']."','','".$imagenes_prod[$x]."')";
	           			$resultado5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
	           		}
	           	}
			}
          }
          	// var_dump($array_id);
          echo count($array_id);
          //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
          fclose($handle);
        } else {
          echo 0;
        }

	}

	function cargaMasivaCaracteristicas () {

		$fname = $_FILES['upload_char']['name'];

        // echo 'Cargando nombre del archivo: '.$fname[1].' <br>';
        $chk_ext = explode(".",$fname[1]);
        if(strtolower(end($chk_ext)) == "csv")
        {
          //si es correcto, entonces damos permisos de lectura para subir
          $filename = $_FILES['upload_char']['tmp_name'];
          $handle = fopen($filename[1], "r");
          $array_products = array();
          while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
          {
            array_push($array_products, $data);
          }
          for($i=1; $i < count($array_products); $i++){

          	$query1 = "SELECT * FROM Caracteristicas WHERE NombreCaracteristica = '".$array_products[$i][1]."'";
          	$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
          	$row = mysql_num_rows($resultado1);

          	if ($row == 0) {
          		$query2 = "INSERT INTO Caracteristicas VALUES ('','".$array_products[$i][1]."')";
          		$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
          		$query5 = "SELECT * FROM Caracteristicas WHERE NombreCaracteristica = '".$array_products[$i][1]."'";
          		$resultado5 = mysql_query($query5,Conectar::con()) or die(mysql_error());
          		$row5 = mysql_fetch_array($resultado5);
	            $query = "INSERT INTO Productos_has_Caracteristicas VALUES('".$array_products[$i][0]."','".$row5[0]."','".$array_products[$i][2]."')";
	            $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
          	} else {
          		$row2 = mysql_fetch_array($resultado1);
          		$query3 = "SELECT * FROM Productos_has_Caracteristicas WHERE Productos_IdProducto = '".$array_products[$i][0]."' AND Caracteristicas_IdCaracteristica = '".$row2[0]."' AND DetalleCaracteristica = '".$array_products[$i][2]."'";
          		$resultado3 = mysql_query($query3,Conectar::con()) or die(mysql_error());
          		$row3 = mysql_num_rows($resultado3);
          		if ($row3 == 0) {
          			$query4 = "INSERT INTO Productos_has_Caracteristicas VALUES('".$array_products[$i][0]."','".$row2[0]."','".$array_products[$i][2]."')";
	            	$resultado = mysql_query($query4,Conectar::con()) or die(mysql_error());
          		}
          	}

          }
          echo "<span style='color:blue'>Importación exitosa!</span>";
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
          fclose($handle);
        } else {
          echo '<span style="color:red">Formato de archivo incorrecto</span>';
        }

	}

	function addNewProvider () {

		parse_str($_POST['action'],$formData);

		$password = $formData['password'];
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);

		if (password_verify($formData['repeat_password'], $passwordhash)) {
		    // echo '¡La contraseña es válida!';

		    $fileNames = [];
			$indice = 0;
			foreach ($_FILES['profileImage']["error"]  as $key => $value) {
				$fileName = $_FILES["profileImage"]["name"][$key];
				$fileName = date("YmdHis").pathinfo($_FILES["profileImage"]["type"][$key], PATHINFO_EXTENSION);
				array_push($fileNames, $fileName);
				$fileType = $_FILES["profileImage"]["type"][$key];
				$fileTemp = $_FILES["profileImage"]["tmp_name"][$key];
				if($indice==0)
					move_uploaded_file($fileTemp, "../images/profileProvider/".$fileName);
				$indice++;
			}

			if ($formData['outstanding'] == 2) {

				date_default_timezone_set('UTC');
			  	date_default_timezone_set("America/Mexico_City");
			  	$datatime = date("Y-m-d H:i:s");

				$query = "INSERT INTO Proveedores
						VALUES('','".$formData['reason_social']."','".$formData['address']."','".$formData['colony']."','".$formData['cp']."',
						'".$formData['tel']."','".$formData['email']."','".$formData['outstanding']."','0','0','0','".$formData['code']."','".$datatime."','2',
						'".$fileName."','".$formData['user']."','".$passwordhash."','".$formData['status']."','".$formData['type_provider']."','".$formData['state']."','".$formData['city']."')";
				$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

				$query1 = "INSERT INTO Usuarios
						VALUES('','".$formData['user']."','".$formData['reason_social']."','','".$formData['email']."','".$passwordhash."','Proveedor','2','')";
				$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());

				echo "<span style='color:blue'>Proveedor Agregado.</span>";

			}else if ($formData['outstanding'] == 1) {

				date_default_timezone_set('UTC');
			  	date_default_timezone_set("America/Mexico_City");
			  	$datatime = date("Y-m-d H:i:s");

				$query = "INSERT INTO Proveedores
						VALUES('','".$formData['reason_social']."','".$formData['address']."','".$formData['colony']."','".$formData['cp']."',
						'".$formData['tel']."','".$formData['email']."','".$formData['outstanding']."','".$formData['priceSmall']."','".$formData['priceMedium']."',
						'".$formData['priceBig']."','".$formData['code']."','".$datatime."','2','".$fileName."',
						'".$formData['user']."','".$passwordhash."','".$formData['status']."','".$formData['type_provider']."','".$formData['state']."','".$formData['city']."')";
				$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

				$query1 = "INSERT INTO Usuarios
						VALUES('','".$formData['user']."','".$formData['reason_social']."','','".$formData['email']."','".$passwordhash."','Proveedor','2','')";
				$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());

				echo "<span style='color:blue'>Proveedor Agregado.</span>";

			}

		} else {

		    echo 1;

		}

	}

	function addNewTypeProvider () {

		parse_str($_POST['action'],$formData);

		$query = "SELECT * FROM TipoProveedor WHERE TipoProveedor = '".$formData['other_provider']."'";
		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row = mysql_num_rows($resultado);
		if ($row == 0) {
			$query1 = "INSERT INTO TipoProveedor VALUES('','".$formData['other_provider']."')";
			$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());
			echo 1;
		} else {
			echo -1;
		}
	}

	function getChangeCity($idState){

		$query = "SELECT * FROM Ciudades WHERE IdEstado = $idState ORDER BY Ciudad ASC";
		$result = mysql_query($query,Conectar::con()) or die(mysql_error());
			echo '<option disabled selected value="">Selecciona..</option>';
		while ($line = mysql_fetch_array($result)) {
			echo '<option value="'.$line["IdCiudad"].'" name="'.$line["IdCiudad"].'">'.$line["Ciudad"].'</option>';
		}

	}

	function editProvider () {

		parse_str($_POST['action'],$formData);

		    $fileNames = [];
			$indice = 0;
			foreach ($_FILES['profileImage']["error"]  as $key => $value) {
				$fileName = $_FILES["profileImage"]["name"][$key];
				// $fileName = date("YmdHis").pathinfo($_FILES["profileImage"]["type"][$key], PATHINFO_EXTENSION);
				array_push($fileNames, $fileName);
				$fileType = $_FILES["profileImage"]["type"][$key];
				$fileTemp = $_FILES["profileImage"]["tmp_name"][$key];
				if($indice==0)
					move_uploaded_file($fileTemp, "../images/profileProvider/".$fileName);
				$indice++;
			}

			if ($formData['outstanding'] == 2) {

				date_default_timezone_set('UTC');
			  	date_default_timezone_set("America/Mexico_City");
			  	$datatime = date("Y-m-d H:i:s");

			  	$query2 = "SELECT * FROM Proveedores WHERE idProveedor = '".$formData['idProveedor']."' AND ImageProfile = '".$fileName."'";
			  	$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
			  	$row2 = mysql_num_rows($resultado2);

			  	if ($row2 == 0) {

			  		$query = "UPDATE Proveedores SET RazonSocial='".$formData['reason_social']."', Direccion='".$formData['address']."', Colonia='".$formData['colony']."', CP='".$formData['cp']."',
			  					Telefono='".$formData['tel']."', Email='".$formData['email']."', CostoEnvio='".$formData['outstanding']."', PaqChico='0', PaqMediano='0',
			  					PaqGrande='0', FechaAlta='".$datatime."', IdPrivilegio='2', ImageProfile='".$fileName."', User='".$formData['user']."', EstatusProv='".$formData['status']."',
			  					TipoProveedor_idTipoProveedor='".$formData['type_provider']."', Estados_IdEstado='".$formData['state']."', Ciudades_IdCiudad='".$formData['city']."'
			  					WHERE idProveedor = '".$formData['idProveedor']."'";
			  		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

			  		echo "<span style='color:blue'>Proveedor Actualizado.</span>";

			  	} else {

			  		$query = "UPDATE Proveedores SET RazonSocial='".$formData['reason_social']."', Direccion='".$formData['address']."', Colonia='".$formData['colony']."', CP='".$formData['cp']."',
			  					Telefono='".$formData['tel']."', Email='".$formData['email']."', CostoEnvio='".$formData['outstanding']."', PaqChico='0', PaqMediano='0',
			  					PaqGrande='0', FechaAlta='".$datatime."', IdPrivilegio='2', User='".$formData['user']."', EstatusProv='".$formData['status']."',
			  					TipoProveedor_idTipoProveedor='".$formData['type_provider']."', Estados_IdEstado='".$formData['state']."', Ciudades_IdCiudad='".$formData['city']."'
			  					WHERE idProveedor = '".$formData['idProveedor']."'";
			  		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

			  		echo "<span style='color:blue'>Proveedor Actualizado.</span>";
			  	}


			} else if ($formData['outstanding'] == 1) {

				date_default_timezone_set('UTC');
			  	date_default_timezone_set("America/Mexico_City");
			  	$datatime = date("Y-m-d H:i:s");

			  	$query2 = "SELECT * FROM Proveedores WHERE idProveedor = '".$formData['idProveedor']."' AND ImageProfile = '".$fileName."'";
			  	$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
			  	$row2 = mysql_num_rows($resultado2);

			  	if ($row2 == 0) {

			  		$query = "UPDATE Proveedores SET RazonSocial='".$formData['reason_social']."', Direccion='".$formData['address']."', Colonia='".$formData['colony']."', CP='".$formData['cp']."',
			  					Telefono='".$formData['tel']."', Email='".$formData['email']."', CostoEnvio='".$formData['outstanding']."', PaqChico='".$formData['priceSmall']."',
			  					PaqMediano='".$formData['priceMedium']."', PaqGrande='".$formData['priceBig']."', FechaAlta='".$datatime."', IdPrivilegio='2',
			  					ImageProfile='".$fileName."', User='".$formData['user']."', EstatusProv='".$formData['status']."',
			  					TipoProveedor_idTipoProveedor='".$formData['type_provider']."', Estados_IdEstado='".$formData['state']."', Ciudades_IdCiudad='".$formData['city']."'
			  					WHERE idProveedor = '".$formData['idProveedor']."'";
			  		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

			  		echo "<span style='color:blue'>Proveedor Actualizado.</span>";

			  	} else {

			  		$query = "UPDATE Proveedores SET RazonSocial='".$formData['reason_social']."', Direccion='".$formData['address']."', Colonia='".$formData['colony']."', CP='".$formData['cp']."',
			  					Telefono='".$formData['tel']."', Email='".$formData['email']."', CostoEnvio='".$formData['outstanding']."', PaqChico='".$formData['priceSmall']."',
			  					PaqMediano='".$formData['priceMedium']."', PaqGrande='".$formData['priceBig']."', FechaAlta='".$datatime."', IdPrivilegio='2', User='".$formData['user']."', EstatusProv='".$formData['status']."',
			  					TipoProveedor_idTipoProveedor='".$formData['type_provider']."', Estados_IdEstado='".$formData['state']."', Ciudades_IdCiudad='".$formData['city']."'
			  					WHERE idProveedor = '".$formData['idProveedor']."'";
			  		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());

			  		echo "<span style='color:blue'>Proveedor Agregado.</span>";
			  	}

			}

	}

	function changePassProvider () {

		parse_str($_POST['action'],$formData);

		$query = "SELECT * FROM Proveedores WHERE idProveedor = '".$formData['idProveedor']."'";
		$resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
		$row = mysql_fetch_array($resultado);

		if (password_verify($formData['past_password'], $row['Password'])) {

			$new_passwordhash = password_hash($formData['new_password'], PASSWORD_DEFAULT);

			if (password_verify($formData['repeat_password'], $new_passwordhash)) {

				$query1 = "UPDATE Proveedores SET Password = '".$new_passwordhash."' WHERE idProveedor = '".$formData['idProveedor']."'";
				$resultado1 = mysql_query($query1,Conectar::con()) or die(mysql_error());

				$query2 = "UPDATE Usuarios SET Password = '".$new_passwordhash."' WHERE Nombre = '".$row['RazonSocial']."' AND NombreUser = '".$row['User']."'";
				$resultado2 = mysql_query($query2,Conectar::con()) or die(mysql_error());

				echo 1;

			} else {

				echo 0;

			}

		} else {

			echo -1;
		}

	}

	function actualizar_status_pedido() {

		if ($_POST['status'] == 1) {

			$query = "SELECT * FROM Pedidos WHERE IdPedido = '".$_POST['idPedido']."'";
			$result = mysql_query($query,Conectar::con()) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$query1 = "UPDATE Pedidos SET Status = 1 WHERE IdPedido = '".$row['IdPedido']."'";
			$result1 = mysql_query($query1);

		} else if ($_POST['status'] == 2){

			$query = "SELECT * FROM Pedidos p INNER JOIN Productos_has_Pedidos pp ON pp.Pedidos_IdPedido = p.IdPedido WHERE p.IdPedido = '".$_POST['idPedido']."'";
			$result = mysql_query($query,Conectar::con()) or die(mysql_error());
			while($row = mysql_fetch_array($result)){
				$query1 = "SELECT Stock FROM Productos WHERE IdProducto = '".$row['Productos_IdProducto']."'";
				$result1 = mysql_query($query1,Conectar::con()) or die (mysql_error());
				$row1 = mysql_fetch_array($result1);
				$stocks = ($row1['Stock'] + $row['Cantidad']);
				$query2 = "UPDATE Productos SET Stock = '".$stocks."' WHERE IdProducto = '".$row['Productos_IdProducto']."'";
				$result2 = mysql_query($query2,Conectar::con()) or die(mysql_error());
			}
			$query3 = "UPDATE Pedidos SET Status = 2 WHERE IdPedido = '".$_POST['idPedido']."'";
			$result3 = mysql_query($query3,Conectar::con()) or die(mysql_error());

		}
		// else {
		// 	echo "Pendiente";
		// 	echo "ID: ".$_POST['idPedido'];
		// }

	}
