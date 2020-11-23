<?php
require_once 'controllers/ViewCtrl.php';
require_once 'models/ViewMdl.php';
function liActive($action) {
	return (isset($_GET["action"]) && $_GET["action"] == $action) ? "active" : "";
}
function isAction($action)
{
	return (isset($_GET["action"]) && $_GET["action"]==$action);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Shop</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="views/img/util/logo.png" />
		<link rel="stylesheet" href="views/vendor/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"-->
		<!--link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"-->
		<link rel="stylesheet" type="text/css" href="views/vendor/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="views/vendor/jquery/3.3.1/jquery.min.js"></script>
		<script src="views/vendor/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="views/css/shop.css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header" id="btnToggle">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarShop" id="btnNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand btn-group" href="index" style="padding: 0px; margin: 0px;">
						<img src="views/img/util/logo-shop.png" width="80" height="45" style="padding: 0px; padding-top: 2px; margin: 0px;">
					</a>
				</div>
				<div class="collapse navbar-collapse" id="navbarShop">
					<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo (!isset($_GET["action"]) || (isset($_GET["action"]) && $_GET["action"] == "index"))  ? "active" : ""; ?>"><a href="index">HOME</a></li>
						<li class="<?php echo liActive("servicios"); ?>"><a href="servicios">SERVICIOS</a></li>
						<li class="<?php echo liActive("productos");  ?>"><a href="productos">PRODUCTOS</a></li>
						<!--li class="<?php //echo liActive("contacto"); ?>"><a href="contacto">CONTACTO</a></li-->
						<li class="<?php echo liActive("compras"); ?> carrito" style="padding: 0px; margin: 0px;">
							<a href="compras" style="padding: 0px; margin: 0px;">
								<?php
									$src = isAction("compras") ?
									'views/img/util/carrito-naranja.png' : 'views/img/util/carrito-blanco.png';
									echo '<img src="' . $src  . '" width="50" height="50" style="padding: 0px; margin: 0px;" id="imgCarrito">';
								?>
								<span class="badge">5</span>
							</a>
						</li>
						<!--li>
							<a data-toggle="modal" href="#mdlLogin">INGRESAR</a>							
						</li-->
						<?php if(!true){ ?>
						<li><a href="javascript:showMdlLogin();">LOGIN</a></li>
						<li class="<?php echo liActive("registrar"); ?>"><a href="registrar">REGISTRAR</a></li>
						<?php } else { ?>
						<li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> JOSE BENITO
					        <span class="caret"></span></a>
					        <ul class="dropdown-menu">
					          <li><a class="text-shop" href="#"><span class="text-shop">Perfil</span></a></li>
					          <li><a class="text-shop" href="#"><span class="text-shop">Salir</span></a></li>
					        </ul>
					    </li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		<?php
		$template = new ViewCtrl();
		$template->getViewTemplateCtrl();
		?>
		<footer class="container-fluid text-center">
			<p>Bootstrap Theme Made By <a href="https://www.w3schools.com/" title="Visit w3schools">www.w3schools.com</a></p>
		</footer>
		
		<!-- Modal -->
		<div class="modal fade" id="mdlLogin" role="dialog"  style="margin-top: 50px;">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">INGRESAR</h4>
					</div>
					<div class="modal-body">
						<form id="formLogin">
							<div class="form-group">
								<label for="email">Correo:</label>
								<input type="email" class="form-control" id="email">
							</div>
							<div class="form-group">
								<label for="pwd">Contrase&ntilde;a:</label>
								<input type="password" class="form-control" id="pwd">
							</div>
							<button type="submit" class="btn btn-default btn-block">Submit</button>
						</form>
					</div>
					<!--div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div-->
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				var actionCarrito = <?php echo isAction("compras") ? 'true' : 'false'; ?>;
				var menuCollapsing = false;
				//Sobre
				$(".carrito").mouseenter(function(){
					$("#imgCarrito").attr({
						src: 'views/img/util/carrito-naranja.png'
					});
				});
				//Fuera
				$(".carrito").mouseleave(function(){
					if (!actionCarrito) {
						$("#imgCarrito").attr({
							src: 'views/img/util/carrito-blanco.png'
						});
					}
				});
				window.showMdlLogin = function () {

					if(menuCollapsing){
						$("#btnNavbar").click();
						menuCollapsing = false;
					}
					$("#mdlLogin").modal();
				};
				$("#formLogin").submit(function(event){
					event.preventDefault();
					alert("Submit prevented");
				});

				$("#btnNavbar").click(function(event) {
					menuCollapsing = !menuCollapsing;
				});
			});
		</script>
	</body>
</html>