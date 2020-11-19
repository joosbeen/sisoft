<!DOCTYPE html>
<html>
	<head>
		<title>Si Soft - POS</title>
		<?php include_once 'views/fragmentos/vendor.php'; ?>
		
	</head>
	<body>
		<div class="jumbotron-fluid text-center bg-primary mb-0 text-white">
			<h1>SI-SOFT POS</h1>
			<p>descripcion....</p>
			<br>
			
			<nav class="navbar navbar-expand bg-dark navbar-dark justify-content-center mt-0">
				<ul class="navbar-nav">
					<li class="nav-item text-white">
						<a class="nav-link" href="home">Home</a>
					</li>
					<li class="nav-item text-white">
						<a class="nav-link" href="registrarse">Registrarse</a>
					</li>
					<li class="nav-item text-white">
						<a class="nav-link active" href="#">Login</a>
					</li>
				</ul>
			</nav>
		</div>
		<br>
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-1"></div>
			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-10 p-3 rounded ss-shadow bg-light ">
				<?php include_once 'views/fragmentos/alertas.php'; ?>
				<form id="formLogin" autocomplete="off">
					<div class="form-group">
						<label for="username"><strong>Usuario:</strong> <span class="badge badge-dark" data-toggle="tooltip" title="Caracteres permitidos: a-z, A-Z, 0-9, *, #.">?</span></label>
						<input type="text" class="form-control" placeholder="Ingrese usuario o correo" id="username" name="username">
						<small class="text-left text-danger w-100" id="msj_username"></small>
					</div>
					<div class="form-group">
						<label for="password"><strong>Contrase&ntilde;a:</strong> <span class="badge badge-dark" data-toggle="tooltip" title="Caracteres permitidos: a-z, A-Z, 0-9, *, #.">?</span></label>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Ingrese contrase&ntilde;a" id="password" name="password">
						<div class="input-group-append">
							<span class="input-group-text pointer" id="showPass">
								<i class="fa fa-eye-slash" aria-hidden="true"></i>
								
							</span>
						</div>
						<small class="text-left text-danger w-100" id="msj_password"></small>
					</div>
					<button type="submit" class="btn btn-primary btn-block">LOGIN</button>
				</form>
				<h6 class="text-right text-info w-100 pointer pt-3 pb-3" data-toggle="modal" data-target="#resetPass"><small>No recuerdo mi contraseña.</small></h6>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-1"></div>
		</div>
		<!-- recuperar contraseña -->
		<div class="modal fade" id="resetPass">
			<div class="modal-dialog modal-sm modal-dialog-centered">
				<div class="modal-content">
					
					<!-- Modal Header -->
					<div class="modal-header bg-primary rounded">
						<h4 class="modal-title text-white text-center">Modal Heading</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					
					<!-- Modal body -->
					<div class="modal-body">
						<h6 for="email" class="mr-sm-2 text-center">Ingresa tu correo</h6>
						<input type="email" class="form-control mb-2 mr-sm-2" placeholder="" name="email_reset">
					</div>
					
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-primary mb-2 btn-block" id="btnEmail_reset">Aceptar</button>
						<!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button-->
					</div>
					
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				
				$("#showPass").click(function(event) {
					mostrarContrsena("password", "showPass")
				});
				$("#username, #password").keypress(function(event) {
					$("#msj_username").text('');
					$("#msj_password").text('');
					if ( (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode<65 || event.keyCode>90) && (event.keyCode<97 || event.keyCode>122) && event.keyCode != 35 && event.keyCode != 42 ) {
						return false;
					}
					let user_pass = $(this).val() + String.fromCharCode(event.keyCode);
					if(user_pass.length == 50){
						return false;
					} else if (user_pass.length < 6 || user_pass.length> 50) {
						var id = $(this).attr('id');
						$("#msj_" + id).text('Solo adminite de 6 a 50 caracteres.');
						
					}
					
				});
				$("#btnEmail_reset").click(function(event) {
					
				});
				$("#formLogin").submit(function(event) {
					
					event.preventDefault();
					$("#msj_username").text('');
					$("#msj_password").text('');
					var username = $("#username").val();
					var password = $("#password").val();

					if (esVacio(username)) {
						$("#msj_username").text('* Campo obligatorio.');
					} else if(tieneEspacios(username)){
						$("#msj_username").text('* Campo no debe contener espacios.');
					} else if(username.length>50){
						$("#msj_username").text('* Campo debe contener 50 caracteres como máximo.');
					}

					if (esVacio(password)) {
						$("#msj_password").text('* Campo obligatorio.');
					} else if(tieneEspacios(password)){
						$("#msj_password").text('* Campo no debe contener espacios.');
					} else if(password.length>50){
						$("#msj_password").text('* Campo debe contener 50 caracteres como máximo.');
					}

					if ($("#msj_username").text() == "" && $("#msj_password").text() == "") {
						var json=$(this).serializeArray()
						.reduce(function(a, z) { a[z.name] = z.value; return a; }, {});

						$.ajax({
							url: "views/ajax/login.php",
							data: json,
							type: "post",
							success: function(result){
								if (result.startsWith("ok") || result.endsWith("ok")) {
									window.location.replace("pos/");
								} else {
									showAlertExitoso("Success!","* Ocurrio un error al tratar de iniciar sesión.");
								}
									
							},
							error: function(result) {
								showAlertError('Error!', result.responseJSON.message);
							}
						});
					}
				});
			});
		</script>
	</body>
</html>