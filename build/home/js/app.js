(function (){
	var app = angular.module('failboxStore', [
		'ngRoute',
		'failboxStore.controllers',
		'failboxStore.services',
		'failboxStore.directives',
		'failboxStore.filters'
	]);
	app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
		$routeProvider
		.when('/', {
			templateUrl: 'views/home.html'
		})
		.when('/productos/', {
			templateUrl: 'views/productos.html'
		})
		.when('/productos/:category/:subcategory/:brand', {
			templateUrl: 'views/productos.html'
		})
		.when('/productos/:category/:subcategory', {
			templateUrl: 'views/productos.html'
		})
		.when('/productos/:category', {
			templateUrl: 'views/productos.html'
		})
		.when('/articulo/:url', {
			templateUrl: 'views/articulo.html',
			controller: 'itemController'
		})
		.when('/contacto', {
			templateUrl: 'views/contacto.html'
		})
		.when('/faq', {
			templateUrl: 'views/faq.html'
		})
		.when('/aviso-de-privacidad', {
			templateUrl: 'views/privacidad.html'
		})
		.when('/carrito', {
			templateUrl: 'views/carrito/micarrito.html',
			controller: 'carrito'
		})
		.when('/datos-envio', {
			templateUrl: 'views/carrito/datosenvio.html',
			controller: ''
		})
		.when('/resumen-compra', {
			templateUrl: 'views/carrito/resumencompra.html',
			controller: ''
		})
		.when('/gracias/:id', {
			templateUrl: 'views/carrito/gracias.html',
			controller: ''
		})
		.when('/preguntas-frecuentes', {
			templateUrl: 'views/carrito/preguntas_frecuentes.html',
			controller: ''
		})
		.when('/cancelado', {
			templateUrl: 'views/carrito/cancelado.html',
			controller: ''
		})
		.otherwise({
			redirectTo: '/'
		});
		$locationProvider.html5Mode(true);
	}]);
	app.run(['$rootScope', '$window', function($rootScope, $templateCache, scope, $window){
		//This scope is used for defined if there's a user connected.
		$rootScope.loginUser = 0;
		$rootScope.pages = 1;
		$rootScope.$on('$routeChangeStart', function(event, next, current) {
			$rootScope.$destroy();
			$(document).find("*").off();
			$('.redes').hide();
			topheight = function(){
				var timeoutId = null;
				if (timeoutId) clearTimeout(timeout);
				var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
				if (!isMobile) {
					setTimeout(function(){
						var height =  document.getElementById('menutopmain').offsetHeight;
						$('.box-hidden').css('height', height+'px');
						var height2 = $('.gridSerives').height() + height+30;

						//$('.loadedView').css('padding-top', height+'px');
						$('.gridCategories').css('top', height+20+'px');
						$('.gridSerives2').css('top', height2+'px');
						$('.gridSerives').css('top', height+'px');
					}, 500);
				} else {
					var height =  document.getElementById('menutopmain').offsetHeight;
  				$('.buy-slide').css('margin-top', height+'px');
				}
			}
			window.addEventListener("load",function(){
				topheight();
			})
		});

		//This call to server will work to verify the session in the site.
		// $.ajax({
		// 	type: 'POST',
		// 	url : './php/user.php',
		// 	data : {
		// 		namefunction : 'verifySession'
		// 	},
		// 	success: function(result){
		// 		$rootScope.loginUser = result;
		// 	},
		// 	error: function(){
		// 		alert('Error');
		// 	},
		// 	timeout: 10000
		// });
	}])
})();
