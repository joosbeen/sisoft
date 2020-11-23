<?php 
	$idusuario = filter_input(INPUT_POST, "idusuario");
	$nombre = filter_input(INPUT_POST, "nombre");
	$usuario = filter_input(INPUT_POST, "usuario");
	$contrasena = filter_input(INPUT_POST, "contrasena");
	$telefono = filter_input(INPUT_POST, "telefono");
	$correo = filter_input(INPUT_POST, "correo");
	$estado = filter_input(INPUT_POST, "estado");
	$idrol = filter_input(INPUT_POST, "idrol");
	$crud = filter_input(INPUT_POST, "crud");

	$error = "";
	$success = "";

	$conexion = conexion();

	if (!esVacio($crud) && $crud == "1") {

	} elseif (!esVacio($idusuario)){

		$qry = "SELECT * FROM usuarios WHERE idusuario=" . $idusuario;

		$usuarios = $conexion->query($qry);
		$user = $usuarios->fetch_assoc();

		$nombre = $user["nombre"];
		$usuario = $user["usuario"];
		$contrasena = $user["contrasena"];
		$telefono = $user["telefono"];
		$correo = $user["correo"];
		$estado = $user["estado"];
		$idrol = $user["idrol"];

	}
 ?>
<div class="container">
	<div class="row">
		<?php include_once '../views/fragmentos/alertas.php'; ?>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
			<h4 class="text-dark" style="text-decoration: underline;"><strong>Detalle Usuario</strong></h4>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12">
			<!--a href="#" class="btn btn-info" role="button">Link Button</a-->
			<a href="usuarios" role="button" class="btn btn-secondary btn-sm float-xl-right float-lg-right float-md-right float-sm-right float-right" value="">Lista Usuarios</a>
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
		<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="nombre">Nombre: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="nombre" id="campo_nombre" value="<?php echo $nombre; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="usuario">Usuario: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="usuario" id="campo_usuario" value="<?php echo $usuario; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="contrasena">Télefono: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="contrasena" id="campo_contrasena" value="<?php echo $contrasena; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="telefono">Télefono: <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="telefono" id="campo_telefono" value="<?php echo $telefono; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="correo">Correo: <span class="text-danger">*</span></label>
			<input type="email" class="form-control" name="correo" id="campo_correo" value="<?php echo $correo; ?>">
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="sel1">Rol: <span class="text-danger">*</span></label>
		    <select class="form-control custom-select" id="campo_idrol" name="idrol">
		    	<option value="">Seleccione...</option>
		        <?php 
		        	$qry = "SELECT * FROM roles WHERE upper(rol) != upper('master')";

		        	$roles = $conexion->query($qry);

					while($rol = $roles->fetch_assoc()) {
						echo '<option value="' . $rol["id"] . '">' . $rol["rol"] . '</option>';
					}			

		         ?>
		    </select>
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label for="sel1">Sucursal: <span class="text-danger">*</span></label>
		    <select class="form-control custom-select" id="campo_idsucursal" name="idsucursal">
		    	<option value="">Seleccione...</option>
		        <?php 
		        	$qry = "SELECT su.* FROM sucursal_empresa se, sucursal su WHERE se.idsucursal = su.idsucursal AND se.idempresa = " . getEmpresa()["idempresa"];

		        	$roles = $conexion->query($qry);

					while($rol = $roles->fetch_assoc()) {
						echo '<option value="' . $rol["idsucursal"] . '">' . $rol["nombre"] . '</option>';
					}			

		         ?>
		    </select>
		</div>
		<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<labe class="w-100">Activo:</label>
			<div class="custom-control custom-switch">
			    <input type="checkbox" class="custom-control-input" id="switch1">
			    <label class="custom-control-label" for="switch1"></label>
			</div>
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
<?php $conexion->close(); ?>