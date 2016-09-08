(function(){

	angular.module('failboxStore.directives', [])

	.directive('topMenu', function(){
		return {
			restrict: 'E',
			templateUrl: './partials/top-menu.html',
			controller: function($document){
				$('input.barNav').keyup(function(){
					var textKey = $(this).val();
					if(textKey.length>1){
						$.ajax({
							type: 'GET',
							url: './php/search.php',
							data: {
								search : textKey
							},
							success : function(result){
								result = jQuery.parseJSON(result);
								var resultElemets = "";
								$('.contElements div').html('');
								$.each(result, function(key, data){
									var price = parseInt(data.price);
									var not_price = parseInt(data.not_price);
									resultElemets += '<a href="articulo/'+data.url+'"><div class="itemSearched"><img style="width: 4vw; height: 4vw; " src="./admin/images/products/'+data.image+'"><div><span style="display: block; text-align: center; font-weight: bold; font-size: 1.2em;">'+data.name+'</span><span style="display: block; text-align: center; margin-top: 2px"><span style="text-decoration: line-through">$'+price.toFixed(2)+'</span> - <span style="font-weight: bold; color: red;">$'+not_price.toFixed(2)+'</span></span></div></div></a>';
								});
								if(resultElemets.length>0){
									$('.contElements div').html(resultElemets);
								}else{
									$('.contElements div').html('<div class="itemSearched"><div><span style="display: block; text-align: center; font-weight: bold; font-size: 1.2em;">Ningún resultado encontrado.</span></div></div>')
								}
							},
							error : function(){
								alert('Error');
							},
							timeout: 10000
						});
					}else{
						$('.contElements div').html('');
					}
				});
				$(document).on('click', '.itemSearched', function(){
					$('input.barNav').val('');
					$('input.barNav').keyup();
				});
			}
		};
	})

	.directive('questionsList', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/questions-list.html',
			controller: function($document){
				$('.faqs li div.answer').slideUp(0);
				$('.faqs li div.question').click(function(){
					$('.faqs li div.answer').slideUp(250);
					$(this).siblings('div.answer').slideDown(250);
					$('.faqs li div.question').removeClass('questionSelected');
					$(this).addClass('questionSelected');
				});

				$('.faqs .g-subs .sub').click(function(e){
					var id = $(e.currentTarget).attr('id');
					var change = $('.faqs').find('ul.'+id)
					var $ul = $('.faqs').find('ul');
					if(!change.is(':visible')){
						$ul.fadeOut('slow');
						$ul.addClass('hide');
						$ul.removeClass('show');
						change.removeClass('hide');
						change.fadeIn('slow');
						change.addClass('show');
					}
				})
			}
		}
	})

	.directive('showModalVideo', function(){
		return {
			restrict: 'E',
			templateUrl: './partials/show-modal-video.html',
			controller: function($document){

				$( ".titleNav" ).click(function() {
					$(".video-modal-wrapper").append( '<iframe id="player" type="text/html" src="https://www.youtube.com/embed/MNwd2aQlXUA?version=3&enablejsapi=1&controls=0&&showinfo=0&rel=0&amp"> </iframe>' );
					$('.background-blur').css('z-index','8');
					$('.background-blur').css('opacity','.6');
					$('.video-modal').css('z-index','8');
					$('.video-modal').css('opacity','1');
				});

				$( ".close-blur,.background-blur,.video-modal" ).click(function() {
					$('.background-blur').css('z-index','-10');
					$('.background-blur').css('opacity','0');
					$('.video-modal').css('z-index','-10');
					$('.video-modal').css('opacity','0');
					$('iframe').get(0).remove();
				});
			}
		};
	})

	.directive('sliderHome', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/slider-home.html',
			controller: function($document){
				var mySwiper;




				var conf =  {
								pagination: '.pagination',
								loop:true,
								grabCursor: false,
								paginationClickable: true,
								autoplay:5500,
								speed:1000,
								calculateHeight: true,
								debugger: false,
								resizeReInit: true,
								observer: true,
								observeParents: true
							}
				setTimeout(function(){
					mySwiper = new Swiper('.swiper-container', conf)
				}, 80);

				$(window).resize(function(){
					//mySwiper.update();
					location.reload();
				});
			}
		};
	})

	.directive('loadHomeSlider', function(){
		return function(){
			var tam_items = $('.slider .contenedor li').length-1;
			if(tam_items==0){
				$('.itemsSelecteds').css({
					'display' : 'none'
				});
			}else{
				$('.itemsSelecteds').css({
					'display' : 'block'
				});
			}
			$('.slider .contenedor').css({
				'width' : (tam_items+1)*100+"%"
			});
			$('.slider .contenedor li').css({
				'width' : 100/(tam_items+1)+"%"
			});
		};
	})

	.directive('sliderCartNew', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/slider-cart-new.html'
		};
	})

	.directive('loadSliderCartNew', function(){
		return function(){

			$(document).on('mouseover', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('.imgInfo', this).css({ 'opacity' : '1' });
				$('.divCapa', this).css({ 'opacity' : '1' });
			});

			$(document).on('mouseout', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('.imgInfo', this).css({ 'opacity' : '0' });
				$('.divCapa', this).css({ 'opacity' : '0' });
			});

			$(document).on('mouseover', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('img', this).attr('src', './src/images/cartimageOver.png');
			});

			$(document).on('mouseout', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('img', this).attr('src', './src/images/cartimage.png');
			});

			var tam_items = $('#slide1 .contItemsPosition div.groupItems').length-1;
			if(tam_items==0){
				$('#slide1 .rightItem, #slide1 .leftItem').css({
					'opacity' : '0',
					'z-index' : '-1'
				});
			}else{
				$('#slide1 .rightItem, #slide1 .leftItem').css({
					'opacity' : '1',
					'z-index' : '9'
				});
			}

			$('#slide1 .contendItems .contItemsPosition').css({
				'width' : (tam_items+1)*100+"%"
			});

			$('#slide1 .contItemsPosition .groupItems').css({
				'width' : 100/(tam_items+1)+"%"
			});

			var item_selected = 0;
			$('#slide1 .rightItem').click(function(){
				if(item_selected==tam_items)
				item_selected=0;
				else
				item_selected++;
				$('#slide1 .contendItems .contItemsPosition').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			});

			$('#slide1 .leftItem').click(function(){
				if(item_selected==0)
				item_selected=tam_items;
				else
				item_selected--;
				$('#slide1 .contendItems .contItemsPosition').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			});

		};
	})

	.directive('sliderCartFeactured', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/slider-cart-feactured.html'
		};
	})

	.directive('loadSliderCartFeactured', function(){
		return function(){

			$(document).on('mouseover', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('.imgInfo', this).css({ 'opacity' : '1' });
				$('.divCapa', this).css({ 'opacity' : '1' });
			});

			$(document).on('mouseout', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('.imgInfo', this).css({ 'opacity' : '0' });
				$('.divCapa', this).css({ 'opacity' : '0' });
			});

			$(document).on('mouseover', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('img', this).attr('src', './src/images/cartimageOver.png');
			});

			$(document).on('mouseout', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('img', this).attr('src', './src/images/cartimage.png');
			});

			var tam_items = $('#slide2 .contItemsPosition div.groupItems').length-1;
			if(tam_items==0){
				$('#slide2 .rightItem, #slide2 .leftItem').css({
					'opacity' : '0',
					'z-index' : '-1'
				});
			}else{
				$('#slide2 .rightItem, #slide2 .leftItem').css({
					'opacity' : '1',
					'z-index' : '10'
				});
			}

			$('#slide2 .contendItems .contItemsPosition').css({
				'width' : (tam_items+1)*100+"%"
			});

			$('#slide2 .contItemsPosition .groupItems').css({
				'width' : 100/(tam_items+1)+"%"
			});

			var item_selected = 0;
			$('#slide2 .rightItem').click(function(){
				if(item_selected==tam_items)
				item_selected=0;
				else
				item_selected++;
				$('#slide2 .contendItems .contItemsPosition').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			});

			$('#slide2 .leftItem').click(function(){
				if(item_selected==0)
				item_selected=tam_items;
				else
				item_selected--;
				$('#slide2 .contendItems .contItemsPosition').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			});

		};
	})

	.directive('serchProductsByFilter', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/serch-products-by-filters.html',
			controller: function($document){
				$('.returnSpan').click(function(){
					parent.history.back();
					return false;
				});
			}
		};
	})

	.directive('loadSearchProductsByFilters', function(){
		return function(){

			//Funcionalidad hover y unhover.
			$(document).on('mouseover', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('.imgInfo', this).css({ 'opacity' : '1' });
				$('.divCapa', this).css({ 'opacity' : '1' });
			});

			$(document).on('mouseout', '.contItemsPosition .item .imgBox', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('.imgInfo', this).css({ 'opacity' : '0' });
				$('.divCapa', this).css({ 'opacity' : '0' });
			});

			$(document).on('mouseover', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('img', this).attr('src', './src/images/cartimageOver.png');
			});

			$(document).on('mouseout', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('img', this).attr('src', './src/images/cartimage.png');
			});

			//Se genera los items de navegacion del contenido.
			var tam_items = $('#slide2 .contItemsPosition div.groupItems').length;

			var itemSelecteds = '<span class="first" style="display:none; z-index: -10;"><img src="./src/images/first.png" style="width: .9em;"></span>';
			itemSelecteds+= '<span class="before" style="display:none; z-index: -10;"><img src="./src/images/before.png" style="width: .9em;"></span>';
			itemSelecteds+= '<div style="display: inline-block;" class="itemsContend">';
			for(var i=0; i<tam_items; i++){
				if(i==0)
				itemSelecteds+= '<span class="selected" name="'+(i+1)+'">'+(i+1)+'</span>';
				else
				itemSelecteds+= '<span name="'+(i+1)+'">'+(i+1)+'</span>';
			}
			itemSelecteds+= '</div>';
			itemSelecteds+= '<span class="next"><img src="./src/images/next.png" style="width: .9em;"></span>';
			itemSelecteds+= '<span class="last"><img src="./src/images/last.png" style="width: .9em;"></span>';
			$('.itemSelecteds').html(itemSelecteds);

			//Ajusta tamaño de los divs.
			$('#slide2 .contendItems .contItemsPosition').css({
				'width' : (tam_items+1)*100+"%"
			});

			$('#slide2 .contItemsPosition .groupItems').css({
				'width' : 100/(tam_items+1)+"%"
			});

			//Cuando das click en los elementos items, para poder visualizar.
			var item_selected = 0;

			$('.first').click(function(){
				itemSelected = 1;
				handlerShow(itemSelected);
				$('.itemsContend span').removeClass('selected');
				$('.itemsContend span[name='+itemSelected+']').addClass('selected');
			});

			$('.before').click(function(){
				itemSelected = item_selected;
				handlerShow(itemSelected);
				$('.itemsContend span').removeClass('selected');
				$('.itemsContend span[name='+itemSelected+']').addClass('selected');
			});

			$('.next').click(function(){
				itemSelected = item_selected+2;
				handlerShow(itemSelected);
				$('.itemsContend span').removeClass('selected');
				$('.itemsContend span[name='+itemSelected+']').addClass('selected');
			});

			$('.last').click(function(){
				itemSelected = tam_items;
				handlerShow(itemSelected);
				$('.itemsContend span').removeClass('selected');
				$('.itemsContend span[name='+itemSelected+']').addClass('selected');
			});

			$('.itemsContend span').click(function(){
				var itemSelected = $(this).attr('name');
				$('.itemsContend span').removeClass('selected');
				$(this).addClass('selected');
				handlerShow(itemSelected);
			});

			function handlerShow(itemSelected){
				item_selected = itemSelected - 1;

				if(item_selected == (tam_items-1))
				$('.next, .last').css({'display':'none'});
				else
				$('.next, .last').css({'display':'inline-block'});

				if(item_selected == 0)
				$('.first, .before').css({'display':'none'});
				else
				$('.first, .before').css({'display':'inline-block'});

				$('#slide2 .contendItems .contItemsPosition').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			}

			if(tam_items==1){
				$('.first, .before, .next, .last').css({'display':'none'});
			}

		};
	})

	.directive('bottomSite', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/bottom-site.html',
			controller: function($document){
				$('form#newsletterForm').submit(function(e){
					e.preventDefault();
					var email = $('.texti', this).val();
					$.ajax({
						beforeSend: function(){},
						url: './php/newletter.php',
						type: 'POST',
						data: {
							email : email
						},
						success: function(result){
							$('form#newsletterForm')[0].reset();
							$('.correctSusc').css({
								'opacity' : '1'
							});
							setTimeout(function(){
								$('.correctSusc').css({
									'opacity' : '0'
								});
							}, 2000);
						},
						error: function(){
							alert('Error');
						},
						timeout: 10000
					});
				});

				$('a.ancla').click(function(e){
					e.preventDefault();
					enlace  = $(this).attr('href');
					$('html, body').animate({
						scrollTop: $(enlace).offset().top-160
					}, 1000);
				});

			}
		};
	})

	.directive('descGeneralItem', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/desc-general-item.html',
			controller: function($document){
				var mySwiper;
				setTimeout(function(){
					mySwiper = new Swiper('.swiper-container',{
						pagination: '.pagination',
						loop:false,
						grabCursor: false,
						paginationClickable: true,
						calculateHeight: true,
						speed:800,
						debugger: false
				  	})
				}, 80)
				$(window).resize(function(){
				  mySwiper.reInit() // or mySwiper.resizeFix()
				});
				$('.returnSpan').click(function(){
					parent.history.back();
					return false;
				});

				// Decrementar valor del input sobre la cantidad de stocks a comprar
				var i = 1;
				$(document).on('click', '.menos', function(){
				    if(i>=2){
				        i = i - 1;
				        var idProduct = $(this).attr('data-id-product');
					    var name = $(this).attr('data-name');
					    var notprice = $(this).attr('data-notprice');
				        var cant = document.getElementById("cantidad");
				        cant.value = i;
				        if(cant.value == 1){
				            i=1;
				            cant.value="1";
				        }
				        $('.test_stock').remove();
				    	$('.test_stock_').html('<div class="buttonAddCart" data-id="'+idProduct+'" data-name="'+name+'" data-price="" data-notprice="'+notprice+'" data-quantity="'+cant.value+'" data-stocks=""><img style="width: 50px; cursor:pointer;" src="./src/images/cartimage.png"></div>');
				    }

				});

				// Incrementar valor del input sobre la cantidad de stocks a comprar
				var i = 1;
				$(document).on('click', '.mas', function(){
				    i = i + 1;
				    var idProduct = $(this).attr('data-id-product');
				    var name = $(this).attr('data-name');
				    var notprice = $(this).attr('data-notprice');
				    var cant = document.getElementById("cantidad");
				    cant.value = i;

				    if(cant.value == 1){
			            i=1;
			            cant.value="1";
				    }
				    $('.test_stock').remove();
				    $('.test_stock_').html('<div class="buttonAddCart" data-id="'+idProduct+'" data-name="'+name+'" data-price="" data-notprice="'+notprice+'" data-quantity="'+cant.value+'" data-stocks=""><img style="width: 50px; cursor:pointer;" src="./src/images/cartimage.png"></div>');
				});


				  //Reduciremos el numero de cantidad a menos uno, eso cuando el usuario de click en el boton less.
			  	$(document).on('click', '.menos_', function(){

				  	var idItemCart = $(this).attr('name');
				  	$.ajax({
			          	beforeSend: function(){
			      		},
			          	url: "./php/functions_cart.php",
			          	type: "POST",
			          	data: {
			          		idItemCart: idItemCart,
			              	namefunction:'disminuir_item_cart'
			          	},
			          	success: function(data){
			          		$.ajax({
					          	beforeSend: function(){
					      		},
					          	url: "./php/functions_cart.php",
					          	type: "POST",
					          	data: {
					              	namefunction:'actualizar_carrito'
					          	},
					          	success: function(data){
					          		alert(data);
					          		// $('.g_cart_cont').html(data);
					          	},
					          	error: function(){
					          	},
					          	complete: function(){
					          	},
					          	timeout: 10000
					      	});
			          		location.reload();
			          		// $('.g_cart_cont').html(data);
			          	},
			          	error: function(){
			          	},
			          	complete: function(){
			          	},
			          	timeout: 10000
			      	});
				});

				$(document).on('click', '.mas_', function(){
					// $('.itemCartStock').hide();
				  	var idItemCart = $(this).attr('name');
				  	$.ajax({
		          		beforeSend: function(){
				      	},
			          	url: "./php/functions_cart.php",
			          	type: "POST",
			          	data: {
			          		idItemCart: idItemCart,
			              	namefunction:'incrementar_item_cart'
			          	},
			          	success: function(data){
			          		$.ajax({
					          	beforeSend: function(){
					      		},
					          	url: "./php/functions_cart.php",
					          	type: "POST",
					          	data: {
					              	namefunction:'actualizar_carrito'
					          	},
					          	success: function(data){
					          		alert(data);
					          		// $('.g_cart_cont').html(data);
					          	},
					          	error: function(){
					          	},
					          	complete: function(){
					          	},
					          	timeout: 10000
					      	});
			          		// actualizar_carrito();
			          		// actualizar_carrito_confirmar();
			          		location.reload();
			          	},
			          	error: function(){
			          	},
			          	complete: function(){
			          	},
			          	timeout: 10000
			     	});
				});

			}
		}
	})

	.directive('loadDescGenItem', function(){
		return function(){

			$(document).on('mouseover', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'pointer' });
				$('img', this).attr('src', './src/images/cartimageOver.png');
			});

			$(document).on('mouseout', '.buttonAddCart', function(){
				$(this).css({ 'cursor' : 'normal' });
				$('img', this).attr('src', './src/images/cartimage.png');
			});

			var tam_items = $('.sliderContenido li').length-1;

			$('.sliderContenido').css({
				'width' : (tam_items+1)*100+"%"
			});

			$('.sliderContenido li').css({
				'width' : 100/(tam_items+1)+"%"
			});

			var item_selected = 0;
			$('.itemSliderConten ul li').click(function(){

				$('.itemSliderConten li img').attr("src", "./src/images/seitemnot.png");
				$('img', this).attr("src", "./src/images/seitem.png");

				item_selected = $(this).index();
				$('.sliderContenido').css({
					'margin-left' : '-'+(item_selected*100)+'%'
				});
			});
		};
	})

	.directive('groupProductsItems', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/group-products-item.html'
		};
	})

	.directive('listProductsFiltered', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/list-products-filtered.html',
			controller: function($document){
				$(document).on('click', '.groupAllItems img', function(){
					$('.groupAllItems img').attr('src','./src/images/viewmore-aside.png');
					$(this).attr('src','./src/images/viewmore.png');
				});
				// //$(document).on('click', 'span.category', function(){
				// $('span.category').click(function(){
				// 	$('ul.subcategoryList').slideUp();
				// 	$(this).siblings('ul.subcategoryList').slideDown();
				// });
				//
				// //$(document).on('click', 'span.subcategory', function(){
				// $('span.subcategory').click(function(){
				// 	$('ul.brandList').slideUp();
				// 	$(this).siblings('ul.brandList').slideDown();
				// });
			}
		};
	})

	.directive('loadGroupProductsItems', function(){
		return function(){
			$('ul.brandList').slideUp(0);
			$('ul.subcategoryList').slideUp(0);

			// //$(document).on('click', 'span.category', function(){
			// $('span.category').click(function(){
			// 	$('ul.subcategoryList').slideUp();
			// 	$(this).siblings('ul.subcategoryList').slideDown();
			// });
			//
			// //$(document).on('click', 'span.subcategory', function(){
			// $('span.subcategory').click(function(){
			// 	$('ul.brandList').slideUp();
			// 	$(this).siblings('ul.brandList').slideDown();
			// });

		}
	})

	.directive('formContactoFailbox', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/form-contacto-failbox.html',
			controller: function($document){
				$('#formContact').submit(function(e){
					var data = $(this).serialize();
					$.ajax({
						type: 'POST',
						url: 'php/sendEmail.php',
						data: data,
						success : function(result){
							$('#successMail').css('display', 'block');
							setTimeout(function(){
								$('#formContact')[0].reset();
								$('#successMail').css('display', 'none');
							}, 1500);
						},
						error: function(){
							alert('error');
						},
						timeout: 10000
					});
					e.preventDefault();
				});
			}
		}
	})

	$(document).on('click', '.buttonAddCart', function(){

	  	var idProduct = $(this).attr('data-id');
	  	var name = $(this).attr('data-name');
	  	var notprice = $(this).attr('data-notprice');
	  	var quantity = $(this).attr('data-quantity');
	  	var stocks = $(this).attr('data-stocks');
	  	var sub_total = notprice*quantity;
	  	var namefunction = 'verify_max_stock';
	  	$.ajax({
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
	            namefunction: 'verify_max_stock',
	            idProduct: idProduct,
	            quantity: quantity
	    	},
			success: function(result){
				// alert(result);
				if(result==1 || result==-1){
					var namefunction = "agregar_producto";
					$.ajax({
						beforeSend: function(){
						},
						url: "./php/functions_cart.php",
						type: "POST",
						data: {
							idProduct:idProduct,
							notprice:notprice,
							quantity:quantity,
							sub_total:sub_total,
							namefunction:namefunction
						},
						success: function(result){
							// alert(result);
							// actualizar_carrito(
					  		$.ajax({
					          	beforeSend: function(){
					      		},
					          	url: "./php/functions_cart.php",
					          	type: "POST",
					          	data: {
					              	namefunction:'actualizar_carrito'
					          	},
					          	success: function(data){
					          		alert(data);
					          		$('.cart_').html(data);
					          	},
					          	error: function(){
					          	},
					          	complete: function(){
					          	},
					          	timeout: 10000
					      	});
						},
						error: function(error){
							alert("error");
						},
						complete: function(){
						},
						timeout: 10000
					});
				} else if(result == 0){
					$('.result_products').html('No hay existencias.');
					$('.result_products').css({'opacity' : '1'});
					setTimeout(function () {
						$('.result_products').css({'opacity' : '0'});
						$('.result_products').text('');
					}, 5000);
				}
			},
			error: function(error){
				alert(error);
			}
		});
	});

})();
