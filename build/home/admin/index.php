<?php
  session_start();
  if(isset($_SESSION['idAdmin']))
    header("Location: listProducts.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FailBox - Lo que cuenta es de adentro.</title>
	<link rel="shortcut icon" type="image/png" href="../src/images/favicon.png">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/home_responsive.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">

	<link href="../css/animate.min.css" rel="stylesheet">
	<!-- Custom styling plus plugins -->
	<link href="../css/custom.css" rel="stylesheet">
	<!-- Bootstrap -->
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  
</head>

<body style="background:#F7F7F7;">
	<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>
    <?php
    $host= $_SERVER["HTTP_HOST"];
  	$url= $_SERVER["REQUEST_URI"];
  	$base_url = "http://" . $host . $url;
  	?>
    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <!--<form action="control.php" method="POST">-->
          <form id="loginAdmin">
            <h1 class="titleLogin" style="margin: 0px 95px 29px;">INICIA SESION</h1>
            <div style="display: block; width: 80%; margin: 0 auto;">
              <input type="text" class="form-control" placeholder="Username" required="" name="username" id="username"/>
            </div>
            <div style="display: block; width: 80%; margin: 0 auto;">
              <input type="password" class="form-control" placeholder="Password" required="" name="password" id="password"/>
            </div>
            <tr> 
              <td colspan="2" align="center"> 
                <div class="alert alert-success welcome" role="alert" style="display:none;width:80%; margin: 0 auto;">Bienvenido</div>
                <div class="alert alert-danger not_pass" role="alert" style="display:none;width:80%; margin: 0 auto;">Contraseña invalida.</div>
                <div class="alert alert-danger not_name" role="alert" style="display:none;width:80%; margin: 0 auto;">Usuario invalido.</div>
              </td> 
            </tr> 
            <div style="display: block; width:93%; margin: 0 auto;">
              <input type="submit" class="btn btn-success" value="Inicia sesión"> 
              <!--<button type="submit" class="btn btn-success submit">Entrar</button>-->
              <a class="" href="#">Olvidaste tu contraseña?</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator" style="margin: 25px 62px 0px;">
              <div class="clearfix"></div>
              <br />
              <div>
                <h1 class="bottomLogin"><i class="fa fa-paw" style="font-size: 26px;"></i> FAILBOX!</h1>
                <p class="bottomLogin">©2016 FAILBOX - Website by PTHF</p>
              </div>
            </div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
    </div>
  </div>
   <script src="js/login.js"></script>
</body>
</html>