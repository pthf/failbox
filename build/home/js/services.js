(function(){

	angular.module('failboxStore.services', [])

	.factory('failboxService', ['$http', '$q', '$filter', function ($http, $q, $filter) {

		function sliderHome(){
			var deferred = $q.defer();

			$http.get('./php/bannersHome.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function new_products(){
			var deferred = $q.defer();

			$http.get('./php/new_products.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function feactured_products(){
			var deferred = $q.defer();

			$http.get('./php/new_products_featured.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function products_cart(){
			var deferred = $q.defer();

			$http.get('./php/products_cart.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function idpedido_cart(){
			var deferred = $q.defer();

			$http.get('./php/idpedido_cart.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function summary_products_cart() {
			var deferred = $q.defer();

			$http.get('./php/products_cart.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function total_cart() {
			var deferred = $q.defer();

			$http.get('./php/total_cart.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function count_items_cart() {
			var deferred = $q.defer();

			$http.get('./php/count_items_cart.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function cost_shipping () {
			var deferred = $q.defer();

			$http.get('./php/cost_shipping.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function total_notprice () {
			var deferred = $q.defer();

			$http.get('./php/total_notprice.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function all(){
			var deferred = $q.defer();
			$http.get('./php/items.php')
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function byItem(url){
			var url = url;
			var deferred = $q.defer();
			all().then(function (data) {
				var results = data.filter(function(item){
					return item.url === url;
				});
				if(results.length > 0 ){
					deferred.resolve(results[0]);
				} else {
					deferred.reject();
				}
			});
			return deferred.promise;
		}

		function productFilteredThree(category, subcategory, brand){
			var deferred = $q.defer();
			$http.get('./php/products_filters.php?nameCategory='+category+'&nameSubcategory='+subcategory+'&nameBrand='+brand)
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function productFilteredTwo(category, subcategory){
			var deferred = $q.defer();
			$http.get('./php/products_filters.php?nameCategory='+category+'&nameSubcategory='+subcategory)
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function productFilteredOne(category){
			var deferred = $q.defer();
			$http.get('./php/products_filters.php?nameCategory='+category)
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function productFiltered(){
			var deferred = $q.defer();
			$http.get('./php/products_filters.php')
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function showMenuCategories(){
			var deferred = $q.defer();
			$http.get('./php/menu.php')
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function showMenuCategoriesLeft(){
			var deferred = $q.defer();
			$http.get('./php/menu_left.php')
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function cart_isset() {
			var deferred = $q.defer();
			$http.get('./php/cart_isset.php')
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function dates_pedido() {
			var deferred = $q.defer();

			$http.get('./php/dates_pedido.php')
			.success(function (data) {
				deferred.resolve(data);
			});

			return deferred.promise;
		}

		function getIdPedido(id){
			var deferred = $q.defer();

			$http.get('./php/services.php?namefunction=getIdPedido&id='+id)
			.success(function (data) {
				deferred.resolve(data);
			});
			return deferred.promise;
		}

		function verificar_existencia_session(idProduct, quantity) {
			var deferred = $q.defer();
			var xsrf = $.param({
				namefunction: 'verify_my_cart',
				idProduct: idProduct,
				quantity: quantity
			});

			$http({
				method: 'POST',
				url: './php/functions_cart.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: xsrf
			}).then(function(req){
				deferred.resolve(req);
			})

			return deferred.promise;
		}

		function verificar_existencias_global(idProduct, quantity) {
			var deferred = $q.defer();
			var xsrf = $.param({
				namefunction: 'verify_max_stock',
				idProduct: idProduct,
				quantity: quantity
			});

			$http({
				method: 'POST',
				url: './php/functions_cart.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: xsrf
			}).then(function(req){
				if(req.data == 0)
				deferred.reject({error: 666, msj: 'sin existencias'});
				else
				deferred.resolve(req);
			})
			return deferred.promise;
		}

		return {
			sliderHome: sliderHome,
			new_products: new_products,
			feactured_products: feactured_products,
			byItem:byItem,
			productFilteredThree: productFilteredThree,
			productFilteredTwo: productFilteredTwo,
			productFilteredOne: productFilteredOne,
			productFiltered: productFiltered,
			showMenuCategories: showMenuCategories,
			showMenuCategoriesLeft: showMenuCategoriesLeft,
			products_cart: products_cart,
			summary_products_cart: summary_products_cart,
			total_cart: total_cart,
			count_items_cart: count_items_cart,
			cost_shipping: cost_shipping,
			total_notprice: total_notprice,
			idpedido_cart: idpedido_cart,
			dates_pedido: dates_pedido,
			getIdPedido: getIdPedido,
			verificar_existencia_session: verificar_existencia_session,
			verificar_existencias_global: verificar_existencias_global,
			cart_isset: cart_isset
		}

	}]);

})();
