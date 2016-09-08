
	$("#formProduct").submit(function(){

		// e.preventDefault();
		if($("#name_product").val().length < 1) {
          	alert("El nombre es obligatorio");
          return false;
        }
        if($("#name_product").val().length < 10) {
          alert("El nombre debe tener como mínimo 30 caracteres");
          return false;
        }
        if($("#name_product").val().length > 50) {
          alert("El nombre debe tener como máximo 50 caracteres");
          return false;
        }
	        var ajaxData = new FormData();
			ajaxData.append("action", $(this).serialize());
			ajaxData.append("namefunction", "addNewProduct");

			$.ajax({
				url: "../php/functions.php",
				type: "POST",
				data: ajaxData,
				processData: false,
				contentType: false,
				success: function(result){
					// alert(result);
					var id = result;
					window.location.href = "../create/createProducts.php?id="+id;
				},
				error: function(error){
					alert(error);
				}
			})
         return false;

	})

	$("#formCharacteristics").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addNewCharacteristics");

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				//alert(result);
				 var id = result;
				 window.location.href = "../create/createProducts.php?id="+id;
			},
			error: function(error){
				alert(error);
			}
		})
	})


	$("#formEditProduct").submit(function(){

		// e.preventDefault();
		if($("#name_product").val().length < 1) {
          	alert("El nombre es obligatorio");
          return false;
        }
        if($("#name_product").val().length < 10) {
          alert("El nombre debe tener como mínimo 30 caracteres");
          return false;
        }
        if($("#name_product").val().length > 50) {
          alert("El nombre debe tener como máximo 50 caracteres");
          return false;
        }
			var ajaxData = new FormData();
			ajaxData.append("action", $(this).serialize());
			ajaxData.append("namefunction", "editProduct");

			$.ajax({
				url: "../php/functions.php",
				type: "POST",
				data: ajaxData,
				processData: false,
				contentType: false,
				success: function(result){
					// alert(result);
					var id = result;
					window.location.href = "../create/createCharacteristics.php?id="+id;
				},
				error: function(error){
					alert(error);
				}
			})
		return false;
	})

	$("#formNewSubcategory").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addNewSubcategory");

		$.ajax({
			//url: "../class/functions.php",
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				location.reload();
				// $('.result_subcategory').html(result);
				// $('.result_subcategory').hide(4000);
				$('#formNewSubcategory')[0].reset();
			},
			error: function(error){
				alert(error);
			}
		})
	})

	$("#formNewCategory").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addNewCategory");

		$.ajax({
			//url: "../class/functions.php",
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				location.reload();
				// $('.result_subcategory').html(result);
				// $('.result_subcategory').hide(4000);
				$('#formNewCategory')[0].reset();
			},
			error: function(error){
				alert(error);
			}
		})
	})

	$("#insertBannerImage").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addImageBanner");

		$.each($("input[type=file]"), function(i, obj) {
			$.each(obj.files, function(j,file) {
				ajaxData.append('failboxBannerImage['+i+']', file);
			})
		});

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				location.reload();
			},
			error: function(error){
				alert(error);
			}
		})
	});

	$("#formCargaProductos").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "cargaMasivaProductos");

		$.each($("input[type=file]"), function(i, obj) {
			$.each(obj.files, function(j,file) {
				ajaxData.append('upload_products['+i+']', file);
			})
		});

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				// alert(result);
				if (result == 0) {
					$('.result_products').html('<span style="color:red">Formato de archivo incorrecto</span>');
					$('.result_products').hide(6000);
					$('#formCargaProductos')[0].reset();
				} else {
					$('.result_products').html('<span style"color:blue;">Importacón exitosa!</span>');
					$('.result_products').hide(6000);
					$('#formCargaProductos')[0].reset();
					window.location.href = "../create/carga_masiva.php?total_ids="+result;
				};
			},
			error: function(error){
				alert(error);
			}
		})
	});

	$("#formCargaCaracteristicas").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "cargaMasivaCaracteristicas");

		$.each($("input[type=file]"), function(i, obj) {
			$.each(obj.files, function(j,file) {
				ajaxData.append('upload_char['+i+']', file);
			})
		});

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				$('.result_chars').html(result);
				$('.result_chars').hide(6000);
				$('#formCargaCaracteristicas')[0].reset();
			},
			error: function(error){
				alert(error);
			}
		})
	});

	$("#formNewProvider").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addNewProvider");

		$.each($("input[type=file]"), function(i, obj) {
			$.each(obj.files, function(j,file) {
				ajaxData.append('profileImage['+i+']', file);
			})
		});

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				if (result == 1) {
					alert('Las contraseñas no coinciden.');
				} else {
					$('.result_provider').html(result);
					$('.result_provider').hide(6000);
					$('#formNewProvider')[0].reset();
				};
			},
			error: function(error){
				alert(error);
			}
		})
	})

	$("#formNewTypeProvider").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "addNewTypeProvider");

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				if (result == -1) {
					alert('El tipo de proveedor ya existe.');
					$('#formNewTypeProvider')[0].reset();
				} else if (result == -1) {
					alert('Tipo de proveedor agregado.');
					location.reload();
				};
			},
			error: function(error){
				alert(error);
			}
		})
	})

	$("#formEditProvider").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "editProvider");

		$.each($("input[type=file]"), function(i, obj) {
			$.each(obj.files, function(j,file) {
				ajaxData.append('profileImage['+i+']', file);
			})
		});

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				// alert(result);
				window.location.href = "../proveedores/list_providers.php";
			},
			error: function(error){
				alert(error);
			}
		})
	})

	$("#formChangePassProvider").submit(function(e){

		e.preventDefault();

		var ajaxData = new FormData();
		ajaxData.append("action", $(this).serialize());
		ajaxData.append("namefunction", "changePassProvider");

		$.ajax({
			url: "../php/functions.php",
			type: "POST",
			data: ajaxData,
			processData: false,
			contentType: false,
			success: function(result){
				if (result == -1) {
					// $('.result_change_pass').html("<span style='color:red'>La contraseña anterior es incorrecta.</span>");
					// $('.result_change_pass').hide(6000);
					alert("La contraseña anterior es incorrecta.");
					$('#formChangePassProvider')[0].reset();
				} else if (result == 0) {
					// $('.result_change_pass').html("<span style='color:red'>No coinciden las contraseñas, repitelas de nuevo.</span>");
					// $('.result_change_pass').hide(6000);
					alert("No coinciden las contraseñas, repitelas de nuevo");
					$('#formChangePassProvider')[0].reset();
				} else if (result == 1) {
					alert("Contraseña modificada correctamente.");
					location.reload();
				};
			},
			error: function(error){
				alert(error);
			}
		})
	})
