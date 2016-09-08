(function(){

	angular.module('failboxStore.directives', [])

	.directive('topMenu', ['$rootScope', function($rootScope){
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
								if(resultElemets.length > 0){
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

				$(document).on('change', '#formNewUser div input[name=firstname]', function(e){
					var value = $(this).val();
					if(value.length==0){
						$(this).css({'border' : '2px solid red'});
						$(this).siblings('.msgError').text("Por favor escriba un nombre.");
						$(this).attr('data-status', 'denied');
					}else{
						var expresion = new RegExp("^[a-zA-Z]* ?[a-zA-Z]*$");
						if(expresion.test(value)){
							$(this).css({ 'border' : '2px solid #6EB153'});
							$(this).siblings('.msgError').text("");
							$(this).attr('data-status', 'acepted');
						}else{
							$(this).css({'border' : '2px solid red'});
							$(this).siblings('.msgError').text("Introduce un nombre valido.");
							$(this).attr('data-status', 'denied');
						}
					}
				});

				$(document).on('change', '#formNewUser div input[name=lastname]', function(e){
					var value = $(this).val();
					if(value.length==0){
						$(this).css({'border' : '2px solid red'});
						$(this).siblings('.msgError').text("Por favor escribe un apellido.");
						$(this).attr('data-status', 'denied');
					}else{
						var expresion = new RegExp("^[a-zA-Z]* ?[a-zA-Z]*$");
						if(expresion.test(value)){
							$(this).css({ 'border' : '2px solid #6EB153'});
							$(this).siblings('.msgError').text("");
							$(this).attr('data-status', 'acepted');
						}else{
							$(this).css({'border' : '2px solid red'});
							$(this).siblings('.msgError').text("Introduce un apellido valido.");
							$(this).attr('data-status', 'denied');
						}
					}
				});

				$(document).on('change', '#formNewUser div input[name=email]', function(e){
					var value = $(this).val();
					if(value.length==0){
						$(this).css({'border' : '2px solid red'});
						$(this).siblings('.msgError').text("Por favor escribe un correo.");
						$(this).attr('data-status', 'denied');
					}else{
						var expresion = new RegExp("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$");
						if(expresion.test(value)){
							var inputaux = $(this);
							$.ajax({
								url : './php/user.php',
								type: 'POST',
								data: {
									email: value,
									namefunction : 'verifyEmail'
								},
								success: function(result){
									if(result=='1'){
										inputaux.css({'border' : '2px solid red'});
										inputaux.siblings('.msgError').text("Lo sentimos, ese correo ya está registrado.");
										inputaux.attr('data-status', 'denied');
									}else{
										inputaux.css({ 'border' : '2px solid #6EB153'});
										inputaux.siblings('.msgError').text("");
										inputaux.attr('data-status', 'acepted');
									}
								},
								error: function(){
									alert('Error');
								},
								timeout: 10000
							});
						}else{
							$(this).css({'border' : '2px solid red'});
							$(this).siblings('.msgError').text("La dirección de email que proporcionaste no es válida.");
							$(this).attr('data-status', 'denied');
						}
					}
				});

				$(document).on('change', '#formNewUser div input[name=password]', function(e){
					var value = $(this).val();
					var password = $('#formNewUser div input[name=confirmpassword]').val();
					if(value.length==0){
						$(this).css({'border' : '2px solid red'});
						$(this).siblings('.msgError').text("Por favor escribe una contraseña.");
						$(this).attr('data-status', 'denied');
					}else{
						if(value.length<6){
							$(this).css({'border' : '2px solid red'});
							$(this).siblings('.msgError').text("Tu contraseña es muy corta.");
							$(this).attr('data-status', 'denied');
						}else{
							$(this).css({ 'border' : '2px solid #6EB153'});
							$(this).siblings('.msgError').text("");
							$(this).attr('data-status', 'acepted');
						}
					}
					if(password.length > 0){
						var input_2do_pass = $('#formNewUser div input[name=confirmpassword]');
						if(value == password){
							input_2do_pass.css({ 'border' : '2px solid #6EB153'});
							input_2do_pass.siblings('.msgError').text("");
							input_2do_pass.attr('data-status', 'acepted');
						}else{
							input_2do_pass.css({'border' : '2px solid red'});
							input_2do_pass.siblings('.msgError').text("La contraseña no coincide.");
							input_2do_pass.attr('data-status', 'denied');
						}
					}
				});

				$(document).on('change', '#formNewUser div input[name=confirmpassword]', function(e){
					var value = $(this).val();
					var password = $('#formNewUser div input[name=password]').val();
					if(value.length==0){
						$(this).css({'border' : '2px solid red'});
						$(this).siblings('.msgError').text("Por favor escribe una contraseña.");
						$(this).attr('data-status', 'denied');
					}else{
						if(value == password){
							$(this).css({ 'border' : '2px solid #6EB153'});
							$(this).siblings('.msgError').text("");
							$(this).attr('data-status', 'acepted');
						}else{
							$(this).css({'border' : '2px solid red'});
							$(this).siblings('.msgError').text("La contraseña no coincide.");
							$(this).attr('data-status', 'denied');
						}
					}
				});

				$(document).on('submit', '#formNewUser', function(e){
					e.preventDefault();
					var status_firstname = $('#formNewUser div input[name=firstname]').attr('data-status');
					var status_lastname = $('#formNewUser div input[name=lastname]').attr('data-status');
					var status_email = $('#formNewUser div input[name=email]').attr('data-status');
					var status_password = $('#formNewUser div input[name=password]').attr('data-status');
					var status_confirmpassword = $('#formNewUser div input[name=confirmpassword]').attr('data-status');

					if(status_firstname == 'acepted' && status_lastname == 'acepted' && status_email == 'acepted' && status_password == 'acepted' && status_confirmpassword == 'acepted'){
						$.ajax({
							type: 'POST',
							url : './php/user.php',
							data : {
								formData : $(this).serialize(),
								namefunction : 'addUser'
							},
							success: function(result){
								$rootScope.loginUser = result;
								$('.modal-header button.close').trigger('click');
							},
							error: function(){
								alert('Error');
							},
							timeout: 10000
						});
					}else{
						alert('No enviamos');
					}
				});

			}
		};
	}])

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
					$('.background-blur').css('z-index','9');
					$('.background-blur').css('opacity','.6');
					$('.video-modal').css('z-index','9');
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
					mySwiper = new Swiper('.swiper-container.swiper-home', conf)
				}, 80);

				var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
				if (!isMobile) {
					//Funcion para recargar cada vez que cambie de tamaño la ventana del navegador
					$(window).resize(function(){
						location.reload();
					});
				}
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
					'z-index' : '2'
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

			$(".buttonAddCart").click(function(e){
				e.preventDefault();
			});

		};
	})

	.directive('sliderCartFeactured', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/slider-cart-feactured.html'
		};
	})

	.directive('avisoPrivacidad', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/aviso-privacidad.html'
		}
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
					'z-index' : '2'
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

	.directive('loadSearchProductsByFilters', ['$rootScope', function($rootScope){
		return function(){
			//Paginacion dinamica
			if($rootScope.pages != 1){
				var pag = $('.sliderCat .itemSelecteds .itemsContend span').attr('name', $rootScope.pages);
				$('.sliderCat .itemSelecteds .itemsContend span').removeClass('selected')
				pag.addClass('selected');
				handlerShow($rootScope.pages);

			}
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

			var itemSelecteds = '<div class="wrap-arrow-a wrap-page"><span class="first" style="display:none; z-index: -10;"><img src="./src/images/first.png" style="width: .9em;"></span>';
			itemSelecteds+= '<span class="before" style="display:none; z-index: -10;"><img src="./src/images/before.png" style="width: .9em;"></span></div>';
			itemSelecteds+= '<div style="display: inline-block;" class="itemsContend">';
			for(var i=0; i<tam_items; i++){
				if(i==0)
				itemSelecteds+= '<span class="selected" name="'+(i+1)+'">'+(i+1)+'</span>';
				else
				itemSelecteds+= '<span name="'+(i+1)+'">'+(i+1)+'</span>';
			}
			itemSelecteds+= '</div>';
			itemSelecteds+= '<div class="wrap-arrow-b wrap-page"><span class="next"><img src="./src/images/next.png" style="width: .9em;"></span>';
			itemSelecteds+= '<span class="last"><img src="./src/images/last.png" style="width: .9em;"></span></div>';
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
	}])

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
					mySwiper = new Swiper('.swiper-container.swiper-general-item',{
						pagination: '.pagination',
						loop:false,
						grabCursor: false,
						paginationClickable: true,
						calculateHeight: true,
						speed:800,
						debugger: false
					})
				}, 80);
				//reinicia el slider al hacer resize a la ventana
				$(window).resize(function(){
					mySwiper.reInit() // or mySwiper.resizeFix()
				});
				$('.returnSpan').click(function(){
					parent.history.back();
					return false;
				});
				$('.informacion-producto .titulo').click(function(){
					if($('.informacion-producto .contenedor').is(':visible')){
						$('i').removeClass('glyphicon-chevron-up');
						$('i').addClass('glyphicon-chevron-down');
					}else{
						$('i').removeClass('glyphicon-chevron-down');
						$('i').addClass('glyphicon-chevron-up');
					}

					$('.informacion-producto .contenedor').slideToggle('')
				})
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
				$(document).on('click', '.groupAllItems img', function(e){
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

	.directive('datosEnvio', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/datos-envio.html',
			controller: function($document){
				setTimeout(function(){
					valueCart = $("#cart").attr('cart');
					// alert(valueCart);
					if (valueCart == 1) {
						$('.nocupon').hide();
						$('.cuponvalido').hide();
						idpedido = $("#idpedido_resumen").attr('pedido');
						totalCart = $("#total").attr('total');
						totalNotCart = $("#totalnot").attr('totalnot');
						if (idpedido == '') {
							$('.form1').remove();

							$(document).on('change', '#formDatesSend div input[name=typeAddress]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red !important'});
									$(this).siblings('.msgError').text("Agrega un tipo de dirección.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=state]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un estado.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=city]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una ciudad.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=address]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una dirección completa.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=colony]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una colonia.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=cp]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un código postal.");
									$(this).attr('data-status', 'denied');
								}else{
									var expresion = new RegExp("^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$");
									if(expresion.test(value)){
										$(this).css({ 'border' : '2px solid #6EB153'});
										$(this).siblings('.msgError').text("");
										$(this).attr('data-status', 'acepted');
									}else{
										$(this).css({'border' : '2px solid red'});
										$(this).siblings('.msgError').text("Introduce un código postal válido.");
										$(this).attr('data-status', 'denied');
									}
								}
							});

							$(document).on('change', '#formDatesSend div input[name=name]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agregar nombres.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=lastname]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega apellidos.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend div input[name=email]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega dirección de correo electrónico.");
									$(this).attr('data-status', 'denied');
								}else{
									var expresion = new RegExp("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$");
									if(expresion.test(value)){
										$(this).css({ 'border' : '2px solid #6EB153'});
										$(this).siblings('.msgError').text("");
										$(this).attr('data-status', 'acepted');
									}else{
										$(this).css({'border' : '2px solid red'});
										$(this).siblings('.msgError').text("La dirección de email que proporcionaste no es válida.");
										$(this).attr('data-status', 'denied');
									}
								}
							});

							// $(document).on('change', '#formDatesSend div input[name=tel]', function(e){
							// 	var value = $(this).val();
							// 	if(value.length==0){
							// 		$(this).css({'border' : '2px solid red'});
							// 		$(this).siblings('.msgError').text("Agrega un número de teléfono.");
							// 		$(this).attr('data-status', 'denied');
							// 	}else{
							// 		// var expresion = new RegExp("/[^0-9]/");
							// 		// if(expresion.test(value)){
							// 			$(this).css({ 'border' : '2px solid #6EB153'});
							// 			$(this).siblings('.msgError').text("");
							// 			$(this).attr('data-status', 'acepted');
							// 		// }else{
							// 		// 	$(this).css({'border' : '2px solid red'});
							// 		// 	$(this).siblings('.msgError').text("Introduce un número válido.");
							// 		// 	$(this).attr('data-status', 'denied');
							// 		// }
							// 	}
							// });

							$(document).on('change', '#formDatesSend div input[name=cel]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un número de celular.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$('#formDatesSend').submit(function(){
								// e.preventDefault();
								var status_typeAddress = $('#formDatesSend div input[name=typeAddress]').attr('data-status');
								var status_state = $('#formDatesSend div input[name=state]').attr('data-status');
								var status_city = $('#formDatesSend div input[name=city]').attr('data-status');
								var status_address = $('#formDatesSend div input[name=address]').attr('data-status');
								var status_colony = $('#formDatesSend div input[name=colony]').attr('data-status');
								var status_cp = $('#formDatesSend div input[name=cp]').attr('data-status');
								var status_name = $('#formDatesSend div input[name=name]').attr('data-status');
								var status_lastname = $('#formDatesSend div input[name=lastname]').attr('data-status');
								var status_email = $('#formDatesSend div input[name=email]').attr('data-status');
								// var status_tel = $('#formDatesSend div input[name=tel]').attr('data-status');
								var status_cel = $('#formDatesSend div input[name=cel]').attr('data-status');

								if(status_typeAddress == 'acepted' && status_state == 'acepted' && status_city == 'acepted' && status_address == 'acepted' && status_colony == 'acepted'
								&& status_cp == 'acepted' && status_name == 'acepted' && status_lastname == 'acepted' && status_email == 'acepted' && status_cel == 'acepted'){
									var ajaxData = new FormData();
									ajaxData.append("action", $(this).serialize());
									ajaxData.append("namefunction", "registrar_datos_pago");
									ajaxData.append("total_cart", totalCart);
									ajaxData.append("total_not_cart", totalNotCart);
									$.ajax({
										type: 'POST',
										url: './php/functions_cart.php',
										data: ajaxData,
										processData: false,
										contentType: false,
										success : function(result){
											if (result == -1) {
												$('.result_cart').html('Agrega productos al carrito para realizar el pedido.');
												$('.result_cart').css({'opacity' : '1'});
												setTimeout(function () {
													$('.result_cart').css({'opacity' : '0'});
													$('.result_cart').text('');
												}, 5000);
												$('#formDatesSend')[0].reset();
											}else {
												// alert(result);
												$('#formDatesSend')[0].reset();
												window.location.href = "resumen-compra";
											};
										},
										error: function(){
											alert('error');
										},
										timeout: 10000
									});
								} else {
									$('.msgErrorNoSend').html('"Verifica que todos los campos esten completos, para continuar con tu compra."');
								}

							});
						} else if(idpedido){
							$('.form2').remove();
							$(document).on('change', '#formDatesSend_ div input[name=typeAddress]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red !important'});
									$(this).siblings('.msgError').text("Agrega un tipo de dirección.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=state]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un estado.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=city]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una ciudad.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=address]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una dirección completa.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=colony]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega una colonia.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=cp]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un código postal.");
									$(this).attr('data-status', 'denied');
								}else{
									var expresion = new RegExp("^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$");
									if(expresion.test(value)){
										$(this).css({ 'border' : '2px solid #6EB153'});
										$(this).siblings('.msgError').text("");
										$(this).attr('data-status', 'acepted');
									}else{
										$(this).css({'border' : '2px solid red'});
										$(this).siblings('.msgError').text("Introduce un código postal válido.");
										$(this).attr('data-status', 'denied');
									}
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=name]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agregar nombres.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=lastname]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega apellidos.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});

							$(document).on('change', '#formDatesSend_ div input[name=email]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega dirección de correo electrónico.");
									$(this).attr('data-status', 'denied');
								}else{
									var expresion = new RegExp("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$");
									if(expresion.test(value)){
										$(this).css({ 'border' : '2px solid #6EB153'});
										$(this).siblings('.msgError').text("");
										$(this).attr('data-status', 'acepted');
									}else{
										$(this).css({'border' : '2px solid red'});
										$(this).siblings('.msgError').text("La dirección de email que proporcionaste no es válida.");
										$(this).attr('data-status', 'denied');
									}
								}
							});

							// $(document).on('change', '#formDatesSend_ div input[name=tel]', function(e){
							// 	var value = $(this).val();
							// 	if(value.length==0){
							// 		$(this).css({'border' : '2px solid red'});
							// 		$(this).siblings('.msgError').text("Agrega un número de teléfono.");
							// 		$(this).attr('data-status', 'denied');
							// 	}else{
							// 		// var expresion = new RegExp("/[^0-9]/");
							// 		// if(expresion.test(value)){
							// 			$(this).css({ 'border' : '2px solid #6EB153'});
							// 			$(this).siblings('.msgError').text("");
							// 			$(this).attr('data-status', 'acepted');
							// 		// }else{
							// 		// 	$(this).css({'border' : '2px solid red'});
							// 		// 	$(this).siblings('.msgError').text("Introduce un número válido.");
							// 		// 	$(this).attr('data-status', 'denied');
							// 		// }
							// 	}
							// });

							$(document).on('change', '#formDatesSend_ div input[name=cel]', function(e){
								var value = $(this).val();
								if(value.length==0){
									$(this).css({'border' : '2px solid red'});
									$(this).siblings('.msgError').text("Agrega un número de celular.");
									$(this).attr('data-status', 'denied');
								}else{
									$(this).css({ 'border' : '2px solid #6EB153 !important'});
									$(this).siblings('.msgError').text("");
									$(this).attr('data-status', 'acepted');
								}
							});
							$('#formDatesSend_').submit(function(){
								var status_typeAddress = $('#formDatesSend_ div input[name=typeAddress]').attr('data-status');
								var status_state = $('#formDatesSend_ div input[name=state]').attr('data-status');
								var status_city = $('#formDatesSend_ div input[name=city]').attr('data-status');
								var status_address = $('#formDatesSend_ div input[name=address]').attr('data-status');
								var status_colony = $('#formDatesSend_ div input[name=colony]').attr('data-status');
								var status_cp = $('#formDatesSend_ div input[name=cp]').attr('data-status');
								var status_name = $('#formDatesSend_ div input[name=name]').attr('data-status');
								var status_lastname = $('#formDatesSend_ div input[name=lastname]').attr('data-status');
								var status_email = $('#formDatesSend_ div input[name=email]').attr('data-status');
								// var status_tel = $('#formDatesSend_ div input[name=tel]').attr('data-status');
								var status_cel = $('#formDatesSend_ div input[name=cel]').attr('data-status');

								if(status_typeAddress == 'acepted' && status_state == 'acepted' && status_city == 'acepted' && status_address == 'acepted' && status_colony == 'acepted'
								&& status_cp == 'acepted' && status_name == 'acepted' && status_lastname == 'acepted' && status_email == 'acepted' && status_cel == 'acepted'){
									var ajaxData = new FormData();
									ajaxData.append("action", $(this).serialize());
									ajaxData.append("namefunction", "registrar_datos_pago");
									ajaxData.append("total_cart", totalCart);
									ajaxData.append("total_not_cart", totalNotCart);
									$.ajax({
										type: 'POST',
										url: './php/functions_cart.php',
										data: ajaxData,
										processData: false,
										contentType: false,
										success : function(result){
											if (result == -1) {
												$('.result_cart').html('Agrega productos al carrito para realizar el pedido.');
												$('.result_cart').css({'opacity' : '1'});
												setTimeout(function () {
													$('.result_cart').css({'opacity' : '0'});
													$('.result_cart').text('');
												}, 5000);
												$('#formDatesSend_')[0].reset();
											}else {
												// alert(result);
												$('#formDatesSend_')[0].reset();
												window.location.href = "resumen-compra";
											};
										},
										error: function(){
											alert('error');
										},
										timeout: 10000
									});
								} else {
									$('.msgErrorNoSend').html('"Verifica que todos los campos esten completos, para continuar con tu compra."');
								}
							});
						};
						$(document).ready(function(){
	                       $('#alternar-form-cupon').click(function(){
	                            if($("#formCuponInput").is(":visible"))
	                            {
	                                $("#formCuponInput").slideUp()
	                            }else{
	                                $("#formCuponInput").slideDown()
	                            }
	                        });
	                    });

	                    $('#formCupon').submit(function(){
	                    	// alert('Entramos');
	                    	var ajaxData = new FormData();
	                    	ajaxData.append("action", $(this).serialize());
							ajaxData.append("namefunction", "registrar_cupon");
	                    	$.ajax({
								type: 'POST',
								url: './php/functions_cart.php',
								data: ajaxData,
								processData: false,
								contentType: false,
								success : function(result){
									if (result == 0) {
				                    	$('.nocupon').html('Código de cupón no válido.');
				                    	$('.nocupon').slideDown(250);
				                    	$('.nocupon').hide(4000);
				                    	$('.cuponvalido').hide();
				                    	$('#formCupon')[0].reset();
									}else if (result == -1){
				                    	$('.nocupon').html('El código ha expirado.');
				                    	$('.nocupon').slideDown(250);
				                    	$('.nocupon').slideUp(4000);
				                    	$('.cuponvalido').hide();
				                    	$('#formCupon')[0].reset();
									} else if (result == 1){
										$('.cuponvalido').html('Código aplicado en tu compra.');
				                    	$('.cuponvalido').slideDown(250);
				                    	$('.cuponvalido').slideUp(4000);
				                    	$('.nocupon').hide();
				                    	$('#formCupon')[0].reset();
				                    	location.reload();
									};
								},
								error: function(){
									alert('error');
								},
								timeout: 10000
							});
	                    });
					} else if(valueCart == 0){
						window.location.href = "carrito";
					};
				}, 250);
			}
		}
	})

	.directive('resumenCompra', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/resumen-compra.html',
			controller: function($document){

				$(document).on('mouseover', '.buttonPaypal', function(){
                    $(this).css({ 'cursor' : 'pointer' });
                    $('input', this).attr('src', './src/images/carrito/button_paypal03.png');
                });

                $(document).on('mouseout', '.buttonPaypal', function(){
                    $(this).css({ 'cursor' : 'normal' });
                    $('input', this).attr('src', './src/images/carrito/button_paypal02.png');
                });

				setTimeout(function(){
					idpedido = $("#idpedido_resumen").attr('pedido');
					// alert(idpedido);
					if (idpedido == '') {
						window.location.href = "carrito";
					};
				}, 250);
				$(document).on('click', '.formPaypal', function(){
					$.ajax({
						beforeSend: function(){
						},
						url: "./php/functions_cart.php",
						type: "POST",
						data: {
							namefunction:'actualizar_carrito_confirmar'
						},
						success: function(data){
							if (data == 1) {
								// alert('Comprar en Paypal');
								$( "#target" ).submit();
							} else if(data == -1){
								alert('El numero de existencias excede de algunos productos, se ajustaran de acuerdo a las existencias del producto');
								location.reload();
							} else {
								alert('Algunos productos se agotaron, serán eliminados del carrito');
								location.reload();
							};
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

	.directive('buySlide', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/buy-slide.html',
			controller: function($document){
			}
		}
	})

	.directive('agradecimiento', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/agradecimiento.html',
			controller: function($document){
				 setTimeout(function(){
				 	idpedido = $("#idpedido_resumen").attr('pedido');
				 	if (idpedido == '') {
				 		window.location.href = "productos";
				 	}
				// 	// else{
				// 	// 	$.ajax({
				//  //          	beforeSend: function(){
				//  //      		},
				//  //          	url: "./php/functions_cart.php",
				//  //          	type: "POST",
				//  //          	data: {
				//  //              	namefunction:'verify_idpedido',
				//  //              	idpedido: idpedido
				//  //          	},
				//  //          	success: function(data){
				//  //          		alert(data);
				//  //          		// window.location.href = "datos-envio";
				//  //          		// $('.g_cart_cont').html(data);
				//  //          	},
				//  //          	error: function(){
				//  //          	},
				//  //          	complete: function(){
				//  //          	},
				//  //          	timeout: 10000
				//  //      	});
				// 	// };
				 }, 250);
			}
		}
	})

	.directive('cancelado', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/cancelado.html',
			controller: function($document){
			}
		}
	})

	.directive('productsMyCart', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/products-my-cart.html',
			controller: function($document){
				//Reduciremos el numero de cantidad a menos uno, eso cuando el usuario de click en el boton less.
				$(document).on('click', '.menos_', function(){
					var idItemCart = $(this).attr('name');
					disminuir_item_cart(idItemCart);
					actualizar_carrito();
				});

				$(document).on('click', '.mas_', function(){

					var idItemCart = $(this).attr('name');
					var quantity = $(this).attr('data-quantity');
					$.ajax({
						url: "./php/functions_cart.php",
						type: "POST",
						data: {
							namefunction: 'verify_stocks',
							idProduct: idItemCart,
							quantity: quantity
						},
						success: function(result){
							// alert(result);
							if(result==1 || result==-1){
								incrementar_item_cart(idItemCart);
								actualizar_carrito();
								// actualizar_carrito_confirmar(idItemCart,quantity);
							} else if(result == 0){
								alert('No hay existencias');
								// $('.result_products').html('No hay existencias.');
								// $('.result_products').css({'opacity' : '1'});
								// setTimeout(function () {
								// 	$('.result_products').css({'opacity' : '0'});
								// 	$('.result_products').text('');
								// }, 5000);
							}
						},
						error: function(error){
							alert(error);
						}
					});
				});

				$(document).on('click', '.buttonBuyNow', function(){
					$.ajax({
						beforeSend: function(){
						},
						url: "./php/functions_cart.php",
						type: "POST",
						data: {
							namefunction:'actualizar_carrito_confirmar'
						},
						success: function(data){
							// alert(data);
							window.location.href = "datos-envio";
							// $('.g_cart_cont').html(data);
						},
						error: function(){
						},
						complete: function(){
						},
						timeout: 10000
					});
				});

				$(document).on('click', '.deleteItemCart', function(e){
					var idItemCart = $(this).attr('name');
					// alert(idItemCart);
					$.ajax({
						beforeSend: function(){
						},
						url: "./php/functions_cart.php",
						type: "POST",
						data: {
							namefunction:'eliminar_item_cart',
							idItemCart: idItemCart
						},
						success: function(data){
							// alert(data);
							//location.reload();
							if($('.productos').find('.producto:visible').length != 0){
								$(e.target).closest('.producto').fadeOut('', function(){
									$(this).remove();
									$('.productos').find('.producto:first-child').css('border', '1px solid #58595b');
									if($('.productos:visible').find('.producto').length == 0 ){
										location.reload();
									}
								});
							}

						},
						error: function(){
						},
						complete: function(){
						},
						timeout: 10000
					});

				});
			}
		};
	})

	.directive('buttonAddCart', ['$rootScope', 'failboxService', '$timeout', function($rootScope, failboxService, $timeout) {
		return {
			restrict: 'C',
			replace : false,
			transclude: false,
			link: function(scope, element, attrs) {

				element.bind('click', function() {

					$timeout(function(){
						failboxService.products_cart().then(function(data){

							$rootScope.$emit('shopping:add', data);
						}).then(function(){
							failboxService.total_cart().then(function(data){

								$rootScope.$emit('shopping:price', data);
							});
						})
						failboxService.count_items_cart().then(function(data){

							$rootScope.$emit('shopping:count', data);
						})
					}, 500)

				})
			}
		}
	}])

	.directive('deleteItemCart', ['$rootScope', 'failboxService', '$timeout', function($rootScope, failboxService, $timeout) {
		return {
			restrict: 'C',
			replace : false,
			link: function(scope, element, attrs) {
				element.bind('click', function() {
					$timeout(function(){
						failboxService.products_cart().then(function(data){
							$rootScope.$emit('shopping:add', data);
						}).then(function(){
							failboxService.total_cart().then(function(data){
								$rootScope.$emit('shopping:price', data);
							});
						})
						failboxService.count_items_cart().then(function(data){
							$rootScope.$emit('shopping:count', data);
						})
					}, 500)

				})
			}
		}
	}])

	.directive('mas', ['$rootScope', 'failboxService', '$timeout', function($rootScope, failboxService, $timeout) {
		return {
			restrict: 'C',
			replace : false,
			transclude: false,
			link: function(scope, element, attrs) {
				element.bind('click', function() {
					failboxService.verificar_existencia_session(scope.item.id, scope.quantity).then(function(req){
						scope.stock_session = req.data;
					})
				})
			}
		}
	}])

	.directive('menos', ['$rootScope', 'failboxService', '$timeout', function($rootScope, failboxService, $timeout) {
		return {
			restrict: 'C',
			replace : false,
			transclude: false,
			link: function(scope, element, attrs) {

				element.bind('click', function() {
					failboxService.verificar_existencia_session(scope.item.id, scope.quantity).then(function(req){
						scope.stock_session = req.data;
					})
				})
			}
		}
	}])

	.directive('elementsFloat', function(){
		return{
			restrict: 'E',
			templateUrl: './partials/elements-float.html',
			controller: function($document){
				var open = true;
				var open1 = true;
				var open2 = true;
				$('.open_close').click(function(){
					var cant = $('.gridCategories').width();
					if(open){
						$('.gridCategories').css({ 'margin-left' : "-"+cant+"px"});
					}else{
						$('.gridCategories').css({ 'margin-left' : "0px"});
					}
					open = !open;
				});
				$('.view_hiden').click(function(){
					var cant = $('.gridSerives').width();
					if(open1){
						$('.gridSerives').css({ 'margin-right' : "-"+cant+"px"});
					}else{
						$('.gridSerives').css({ 'margin-right' : "0px"});
					}
					open1 = !open1;
				});
				$('.view_hiden2').click(function(){
					var cant = $('.gridSerives2').width();
					if(open2){
						$('.gridSerives2').css({ 'margin-right' : "-"+cant+"px"});
					}else{
						$('.gridSerives2').css({ 'margin-right' : "0px"});
					}
					open2 = !open2;
				});
				setTimeout(function(){
					var cant = $('.gridCategories').width();
					$('.gridCategories').css({ 'margin-left' : "-"+cant+"px"});
					open = false;
					var cant = $('.gridSerives2').width();
					$('.gridSerives2').css({ 'margin-right' : "-"+cant+"px"});
					open2 = false;
				},250);
				var opened = false;
				$(window).scroll(function(){
					var pos = $(this).scrollTop();
					if(!opened){
						if(pos>$('.titleDiv').position().top){
							var cant = $('.gridCategories').width();
							$('.gridCategories').css({ 'margin-left' : "0px"});
							open = true;
							var cant = $('.gridSerives2').width();
							$('.gridSerives2').css({ 'margin-right' : "0px"});
							open2 = true;
							var cant = $('.gridSerives').width();
							$('.gridSerives').css({ 'margin-right' : "-"+cant+"px"});
							open1 = false;
							opened = true;
						}
					}
				});
			}
		}
	});

	$(document).on('click', '.cartBar', function(e){
		var height =  document.getElementById('menutopmain').offsetHeight;
		$('.buy-slide').css('margin-top', height+'px');
		$('.buy-slide').slideToggle('fast');
	})

	$(document).on('click', '.buttonAddCart', function(e){
		e.preventDefault();
		var idProduct = $(this).attr('data-id');
		var name = $(this).attr('data-name');
		var notprice = $(this).attr('data-notprice');
		var quantity = $(this).attr('data-quantity');
		var stocks = $(this).attr('data-stocks');
		var sub_total = notprice*quantity;
		// var namefunction = 'verify_max_stock';
		$.ajax({
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
				namefunction: 'verify_max_stock',
				idProduct: idProduct,
				quantity: quantity
			},
			success: function(result){

				if(result==1 || result==-1){
					agregar_producto(idProduct,notprice,quantity,sub_total);
					actualizar_carrito();
					if($('.buy-slide:hidden')){
						var height =  document.getElementById('menutopmain').offsetHeight;
						$('.buy-slide').css('margin-top', height+'px');
						$('.buy-slide').slideDown('fast');
					}
				} else if(result == 0){
					alert('No hay existencias');
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

	function agregar_producto(idProduct,notprice,quantity,sub_total){
		// alert('Agregar Producto');
		var namefunction = "agregar_producto";
		$.ajax({
			beforeSend: function(){
				//location.reload();
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
			},
			error: function(error){
				alert("error");
			},
			complete: function(){
			},
			timeout: 10000
		});
	}

	function actualizar_carrito(){
		// alert('Actualizar Carrito');
		$.ajax({
			beforeSend: function(){
				//location.reload();
			},
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
				namefunction:'actualizar_carrito'
			},
			success: function(data){

				// alert(data);
				// $('.cart_').html(data);
			},
			error: function(){
			},
			complete: function(){
			},
			timeout: 10000
		});
	}

	function actualizar_carrito_confirmar(idProduct,quantity){
		// alert('Actualizar Carrito Confirmar');
		$.ajax({
			beforeSend: function(){
				location.reload();
			},
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
				namefunction:'actualizar_carrito_confirmar',
				idProduct: idProduct,
				quantity: quantity
			},
			success: function(data){
				alert('Añadido a carrito');
				// $('.g_cart_cont').html(data);
			},
			error: function(){
			},
			complete: function(){
			},
			timeout: 10000
		});

	}

	function disminuir_item_cart(idItemCart){
		// alert('Disminuir Item Cart');
		$.ajax({
			beforeSend: function(){
				location.reload();
			},
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
				idItemCart: idItemCart,
				namefunction:'disminuir_item_cart'
			},
			success: function(data){
				// alert(data);
				location.reload();
				// $('.g_cart_cont').html(data);
			},
			error: function(){
			},
			complete: function(){
			},
			timeout: 10000
		});

	}

	function incrementar_item_cart(idItemCart){
		// alert('Incrementar Item Cart');
		$.ajax({
			beforeSend: function(){
				location.reload();
			},
			url: "./php/functions_cart.php",
			type: "POST",
			data: {
				idItemCart: idItemCart,
				namefunction:'incrementar_item_cart'
			},
			success: function(data){
				// alert(data);
				location.reload();
			},
			error: function(){
			},
			complete: function(){
			},
			timeout: 10000
		});

	}

})();
