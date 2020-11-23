<?php
$idsucursal = filter_input(INPUT_POST, "idsucursal");
$nombre = filter_input(INPUT_POST, "nombre");
$direccion = filter_input(INPUT_POST, "direccion");
$telefono = filter_input(INPUT_POST, "telefono");
$correo = filter_input(INPUT_POST, "correo");
$crud = filter_input(INPUT_POST, "crud");

$error = "";
$success = "";
$conexion = conexion();

if (!esVacio($crud) && $crud == "1") { // acciones de insert y update

	// Validar Campos
	if (esVacio($nombre)) {
		$error .= "* Nombre: es obligatorio.<br />";
	}
	if (esVacio($direccion)) {
		$error .= "* Dirección: es obligatorio.<br />";
	}
	if (esVacio($telefono)) {
		$error .= "* Télefono: es obligatorio.<br />";
	}
	if (esVacio($correo)) {
		$error .= "* Correo: es obligatorio.<br />";
	} else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		$error .= "* Correo: formato invalido.<br />";
	}

	if (esVacio($error)) { // Si $error esta estavio, los campos son validos.

		$qry = "";

		if (esVacio($idsucursal)) { // si $idsucursal esta vacio es insert
			$qry = "INSERT INTO sucursal(nombre, direccion, telefono, correo) VALUES (
				'$nombre',
				'$direccion',
				'$telefono',
				'$correo'
			);";
		} else { //Caso contrario es un update
			$qry = "UPDATE sucursal SET 
				nombre='$nombre',
				direccion='$direccion',
				telefono='$telefono',
				correo='$correo'
			WHERE idsucursal=".$idsucursal;
		}

		if ($conexion->query($qry) === TRUE) { // ejecucion exitosa

			if (esVacio($idsucursal)) { // preceos de un insert
				$idsucursal = $conexion->insert_id;
				$qry = "INSERT INTO sucursal_empresa(idempresa, idsucursal) VALUES (" . getEmpresa()["idempresa"] . ", " . $idsucursal . ");";


				if ($conexion->query($qry) === TRUE) { // preceso de insert exitoso
					$success = "La sucursal se registro exitosamente.";
				} else { // preceso de insert fallido
					$qry = "DELETE FROM sucursal WHERE idsucursal=" . $idsucursal;
					$conexion->query($qry);
		    		$error = "Error en el proceso: " . $conexion->error;
				}

			} else { // preceso de update exisoto
				$success = "La sucursal se actualizo exitosamente.";
			}
		    
		} else { // ejecucion error
		    $error = "Error en el proceso: " . $conexion->error;
		}
		
	} else {
		$error = '<strong>Ingrese los siguientes datos:</strong><br>' . $error;
	}

} else if(!esVacio($idsucursal)){ // cargar datos de sucursal para editar

	$sql = "SELECT * FROM sucursal WHERE idsucursal = " . $idsucursal . ";";
	
	$sucursales = $conexion->query($sql);
	$sucursal = $sucursales->fetch_assoc();

	$nombre = $sucursal["nombre"];
	$direccion = $sucursal["direccion"];
	$telefono = $sucursal["telefono"];
	$correo = $sucursal["correo"];
}

$conexion->close();

?>
<div class="container">
	<div class="row">
		<?php include_once '../views/fragmentos/alertas.php'; ?>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
			<h4 class="text-dark" style="text-decoration: underline;"><strong>Detalle Sucursal</strong></h4>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12">
			<!--a href="#" class="btn btn-info" role="button">Link Button</a-->
			<a href="sucursales" role="button" class="btn btn-secondary btn-sm float-xl-right float-lg-right float-md-right float-sm-right float-right" name="sucursal" value="">Lista Sucursales</a>
		</div>
	</div>
	<br>
	<!-- alerta error -->
	<?php if(!esVacio($success)){ ?>
	<div class="alert alert-success">
    	<?php echo $success; ?>
  	</div>
  	<?php } ?>
  	<!-- alerto exitoso -->
	<?php if(!esVacio($error)){ ?>
	<div class="alert alert-danger">    	
    	<?php echo $error; ?>
  	</div>
  	<?php } ?>
	<form class="row border border-secondary shadow-lg rounded" method="post">
		<input type="hidden" name="crud" value="1">
		<input type="hidden" name="idsucursal" value="<?php echo $idsucursal; ?>">
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="nombre">Nombre: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="nombre" id="campo_nombre" value="<?php echo $nombre; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="direccion">Dirección: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="direccion" id="campo_direccion" value="<?php echo $direccion; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="telefono">Télefono: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="telefono" id="campo_telefono" value="<?php echo $telefono; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="correo">Correo: <span class="text-danger">*</span></label>
			<input type="email" class="form-control" name="correo" id="campo_correo" value="<?php echo $correo; ?>">
		</div>
		<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-3 pb-3">
			<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12"></div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<button type="submit" class="btn btn-secondary btn-block">GUARDAR</button>				
			</div>
			<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12"></div>
		</div>
	</form>
	
</div>