<?php 
require_once "pos/util/sesion.php";

if (sesionCreada() && obtenerSession()["estado"] != false) {
	header("Location:/login");
}

?>
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
		</div>
		<br>
		<div class="row">
			<div class="mx-auto bg-light col-xl-4 col-lg-4 col-md-5 col-sm-10 col-10 col p-3 rounded ss-shadow text-center">
				<div class="alert alert-danger" id="alertdanger" style="display: none;">
					
				</div>
				<h3 class="text-center pt-3 pb-3 text-primary">VERIFICAR INFORMACION</h3>
				<div class="text-center">
					<p>Se envió un código de verificación de 6 dígitos  al correo <strong class="text-dark"><?php echo obtenerSession()["correo"]; ?></strong>, ingréselo para verificar su registro. </p>
				</div>
				<form class="row" id="formActivar" method="post">
					<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label for="codigo"><strong>Código de Verificación</strong></label>
						<input type="text" class="form-control" placeholder="Ingrese código de verificación" id="codigo" name="codigo" required>
						<small class="text-danger text-left" id="msj_codigo"></small>
					</div>
					<br/>
					<br/>
					<button type="submit" class="btn btn-primary btn-block mx-auto col-xl-5 col-lg-5 col-md-5 col-sm-6 col-8 col mt-5">VERIFICAR</button>
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

				$("#formActivar").submit(function(event) {

					event.preventDefault();
					
					$("#msj_codigo").text('');

					if (esVacio($("#codigo").val())) {
						$("#msj_codigo").text('* Código de verificación: obligatorio.');
					} else if (tieneEspacios($("#codigo").val())) {
						$("#msj_codigo").text('* Código de verificación: contiene espacios.');
					} else if ($("#codigo").val().length != 6) {
						$("#msj_codigo").text('* Código de verificación: De 6 digitos.');
					}

					if ($("#msj_codigo").text() == '') {
						 $.ajax({
		                    data: $("#formActivar").serialize(),
		                    type: "post",
		                    dataType: "json",
		                    url: "views/ajax/activar.php",
		                    success: function(resultado) {				
		                        if (resultado.message === "ok") {
		                            window.location.replace("pos/");
		                        } else {
		                        	$("#alertdanger").html(resultado.message);
		                        	$("#alertdanger").show();
		                        }
		                    },
		                    error: function(resultado) {
		                    	console.log("error");
		                    	console.log(resultado);
		                        $("#alertdanger").html(resultado.responseJSON.message);
		                        $("#alertdanger").show();
		                    }
		                });
					}

				});
				
			});
		</script>
	</body>
</html>