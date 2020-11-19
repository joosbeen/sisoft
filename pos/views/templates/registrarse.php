<!DOCTYPE html>
<html lang="es">
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
						<a class="nav-link active" href="#">Registrarse</a>
					</li>
					<li class="nav-item text-white">
						<a class="nav-link" href="login">Login</a>
					</li>
				</ul>
			</nav>
		</div>
		<br>
		<div class="row">
			<div class="mx-auto bg-light col-xl-8 col-lg-8 col-md-8 col-sm-10 col-10 col p-3 rounded ss-shadow">
				<div class="alert alert-danger" id="alertdanger" style="display: none;">
					
				</div>
				<form class="row" id="formRegistrarse" method="post">
					
					<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h5 class="text-left text-info"><strong>Datos de Empresa</strong></h5>
					</div>

					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="empresa"><strong>Nombre:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese nombre de la empresa" id="empresa" name="empresa" required>
						<small class="text-danger text-left" id="msj_empresa"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="rfc"><strong>RFC:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese RFC de la empresa" id="rfc" name="rfc" required>
						<small class="text-danger text-left" id="msj_rfc"></small>
					</div>
					<div class="form-grou col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="telefono"><strong>Teléfono:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese Teléfono de la empresa" id="telefono" name="telefono" required>
						<small class="text-danger text-left w-100" id="msj_telefono"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="correo"><strong>Correo:</strong></label>
						<input type="email" class="form-control" placeholder="Ingrese Correo de la empresa" id="correo" name="correo" required>
						<small class="text-danger text-left w-100" id="msj_correo"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="direccion"><strong>Dirección:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese Correo de la empresa" id="direccion" name="direccion" required>
						<small class="text-danger text-left w-100" id="msj_direccion"></small>
					</div>

					<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h5 class="text-left text-info"><strong>Datos de Usuario</strong></h5>
					</div>

					<div class="form-group input-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label class="w-100" for="password"><strong>Contrase&ntilde;a:</strong></label>
						<input type="password" class="form-control" placeholder="Ingrese contrase&ntilde;a" id="password" name="password" required>
						<div class="input-group-append">
							<span class="input-group-text pointer" id="showPass">
								<i class="fa fa-eye-slash" aria-hidden="true"></i>
							</span>
						</div>
						<small class="text-left text-danger w-100" id="msj_password"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="usuario"><strong>Usuario:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese Nombre de usuario" id="usuario" name="usuario" required>
						<small class="text-danger text-left w-100" id="msj_usuario"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="empresa"><strong>Nombre:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese nombre de usuario" id="unombre" name="unombre" required>
						<small class="text-danger text-left" id="msj_unombre"></small>
					</div>
					<div class="form-grou col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="telefono"><strong>Teléfono:</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese Teléfono de usuario" id="utelefono" name="utelefono" required>
						<small class="text-danger text-left w-100" id="msj_utelefono"></small>
					</div>
					<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<label for="correo"><strong>Correo:</strong></label>
						<input type="email" class="form-control" placeholder="Ingrese Correo de usuario" id="ucorreo" name="ucorreo" required>
						<small class="text-danger text-left w-100" id="msj_ucorreo"></small>
					</div>
					<div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<button type="submit" class="btn btn-primary btn-block mx-auto col-xl-5 col-lg-5 col-md-5 col-sm-6 col-8 col mt-3">REGISTRARSE</button>						
					</div>
				</form>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$("#showPass").click(function(event) {
					mostrarContrsena("password", "showPass")
				});
				$("#rfc").keypress(function(event) {
					
					let telefono = $(this).val() + String.fromCharCode(event.keyCode);
					
					if (event.keyCode == 32 || ( (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode<65 || event.keyCode>90) && (event.keyCode<97 || event.keyCode>122))) {
												return false;
					}
					var rfc = $(this).val() + String.fromCharCode(event.keyCode);
					$(this).val(rfc.toUpperCase());
					return false;
				});
				$("#telefono").keypress(function(event) {
					
					let telefono = $(this).val() + String.fromCharCode(event.keyCode);
					
					if (event.keyCode == 32 || (event.keyCode < 48 || event.keyCode > 57)) {
												return false;
					} else if(telefono.length>12){
						return false;
					}
				});
				$("#password, #usuario").keypress(function(event) {
					$("#msj_username").text('');
					$("#msj_password").text('');
					if ( (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode<65 || event.keyCode>90) && (event.keyCode<97 || event.keyCode>122) && event.keyCode != 35 && event.keyCode != 42 ) {
						return false;
					}
					let user_pass = $(this).val() + String.fromCharCode(event.keyCode);
					if(user_pass.length == 12){
						return false;
					} else if (user_pass.length < 6 || user_pass.length> 12) {
						var id = $(this).attr('id');
						$("#msj_" + id).text('Solo adminite de 6 a 12 caracteres.');
						
					}
					
				});
				$("#formRegistrarse").submit(function(event) {
					event.preventDefault();
					
					$("#msj_rfc").text('');
					$("#msj_telefono").text('');
					$("#msj_correo").text('');
					$("#msj_password").text('');
					$("#msj_usuario").text('');

					if (esVacio($("#empresa").val())) {
						$("#msj_empresa").text('* Campo obligatorio.');
					}

					if (esVacio($("#rfc").val())) {
						$("#msj_rfc").text('* Campo obligatorio.');
					} else if (tieneEspacios($("#rfc").val())) {
						$("#msj_rfc").text('* No debe contener espacios.');
					}

					if (esVacio($("#telefono").val())) {
						$("#msj_telefono").text('* Campo obligatorio.');
					} else if (tieneEspacios($("#telefono").val())) {
						$("#msj_telefono").text('* No debe contener espacios.');
					}

					if (esVacio($("#correo").val())) {
						$("#msj_correo").text('* Campo obligatorio.');
					} else if (!esEmail($("#correo").val())) {
						$("#msj_correo").text('* Correo invalido.');
					}

					if (esVacio($("#direccion").val())) {
						$("#msj_direccion").text('* Campo obligatorio.');
					}

					if (esVacio($("#password").val())) {
						$("#msj_password").text('* Contrseña obligatorio.');
					} else if (tieneEspacios($("#password").val())) {
						$("#msj_password").text('* Contrseña invalido.');
					} else if ($("#password").val().length < 6 || $("#password").val().length > 12) {
						$("#msj_password").text('* Contrseña: De 6 a 12 caracteres.');
					}

					if (esVacio($("#usuario").val())) {
						$("#msj_usuario").text('* Usuario:  obligatorio.');
					} else if (tieneEspacios($("#usuario").val())) {
						$("#msj_usuario").text('* Usuario:  invalido.');
					} else if ($("#usuario").val().length < 6 || $("#usuario").val().length > 12) {
						$("#msj_usuario").text('* Usuario: De 6 a 12 caracteres.');
					}

					if (esVacio($("#unombre").val())) {
						$("#msj_unombre").text('* Campo obligatorio.');
					}

					if (esVacio($("#utelefono").val())) {
						$("#msj_utelefono").text('* Campo obligatorio.');
					} else if (tieneEspacios($("#utelefono").val())) {
						$("#msj_utelefono").text('* No debe contener espacios.');
					}

					if (esVacio($("#ucorreo").val())) {
						$("#msj_ucorreo").text('* Campo obligatorio.');
					} else if (!esEmail($("#ucorreo").val())) {
						$("#msj_ucorreo").text('* Correo invalido.');
					}

					if ($("#msj_rfc").text() == '' && $("#msj_telefono").text() == '' && $("#msj_correo").text() == '' && $("#msj_password").text() == '' && $("#msj_usuario").text() == '') {
						$.ajax({
							data: $("#formRegistrarse").serialize(),
							type: "post",
							dataType: "json",
							url: "views/ajax/registrarse.php",
							success: function(resultado) {
								if (resultado.message === "ok") {									
									window.location.replace("activar");
								} else {
									$("#alertdanger").html(resultado.message);
								}
							},
							error: function(resultado) {
								$("#alertdanger").html(resultado.message);
							}
						});
					}
				});
				
			});
		</script>
	</body>
</html>