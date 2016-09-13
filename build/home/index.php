<?php session_start();?>
<!DOCTYPE html>
<html ng-app="failboxStore">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=nos">
	<base href="http://localhost/www/failbox/failbox/build/home/">
	<title>FailBox - Lo que cuenta es lo de adentro.</title>
	<link rel="shortcut icon" type="image/png" href="./src/images/favicon.png">
	<link rel="stylesheet" type="text/css" href="./css/home.css">
	<link rel="stylesheet" type="text/css" href="./css/home_responsive.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
	<link rel="stylesheet" type="text/css" href="./css/carrito.css">
	<link rel="stylesheet" type="text/css" href="./css/new_characters.css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="./js/lib/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-81923103-1', 'auto');
	ga('send', 'pageview');
	</script>
</head>
<body ng-controller="connectFacebookController">
	<div class="contenedor" ng-controller="homeSliderController">

		<!-- This element is part form loading gif -->
		<div class="capaModalRun">
			<div class="imgLoading" style="width: 18%; height: auto;"><img src="./src/images/1.gif" style="width: 100%; height: auto;"></div>
		</div>
		<!-- This element will work like a popup to show information -->
		<div class="capa">
		  <div class="popupInformation">
				<div class="closepopup"><img src="./src/images/FAILBOX_POPUPS_800x500-04.png"></div>
				<div class="image" ng-show = "popupselected===1">
					<img src="./src/images/FAILBOX_POPUPS_800x500-01.png">
				</div>
				<div class="image" ng-show = "popupselected===2">
					<img src="./src/images/FAILBOX_POPUPS_800x500-02.png">
				</div>
				<div class="image" ng-show = "popupselected===3">
					<img src="./src/images/FAILBOX_POPUPS_800x500-03.png">
				</div>
				<div class="image" ng-show = "popupselected===4">
					<img src="./src/images/FAILBOX_POPUPS_800x500_web_5.jpg">
				</div>
				<div class="image" ng-show = "popupselected===5">
	 				<img src="./src/images/FAILBOX_POPUPS_800x500_web_5.jpg">
	 			</div>
		  </div>
		</div>

		<top-menu></top-menu>
		<buy-slide></buy-slide>
		<div class="margin-responsive"></div>
		<div class="loadedView" ng-view style="position:relative;"></div>
		<bottom-site></bottom-site>
		<show-modal-video></show-modal-video>

	</div>
	<script src="./js/lib/underscore-min.js"></script>
	<script src="./js/lib/angular.min.js"></script>
	<script src="./js/lib/angular-route.min.js"></script>
	<script src="./js/app.js"></script>
	<script src="./js/controllers.js"></script>
	<script src="./js/directives.js"></script>
	<script src="./js/services.js"></script>
	<script src="./js/filters.js"></script>
	<script src="./js/lib/slider.js"></script>

	<script>
		// Load the SDK asynchronously
		// (function(d, s, id) {
		// 		var js, fjs = d.getElementsByTagName(s)[0];
		// 		if (d.getElementById(id)) {return;}
		// 		js = d.createElement(s); js.id = id;
		// 		js.src = "//connect.facebook.net/en_US/sdk.js";
		// 		fjs.parentNode.insertBefore(js, fjs);
		// }(document, 'script', 'facebook-jssdk'));
	</script>
	<!-- Load PopUp first, before to load the home -->
	<script>
		function startup(){
			$('.continueDisabled').css({'display':'block'});
			setTimeout(function(){
					$('.capaModalRun').css({'opacity' : '0','z-index' : '-10'});
			},500);
		}
		window.onload = startup;
		$(document).on('click', '.continueDisabled', function(){
			$('.capaModalRun').css({'opacity' : '0','z-index' : '-10'});
			$('html,body').css({'overflow':'auto'});
		});
	</script>

	<!--<script type="text/javascript" src="http://localhost:35729/livereload.js"></script>-->
</body>
</html>
