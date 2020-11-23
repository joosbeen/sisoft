<?php
$conexion = conexion();
?>
<div class="container">
	<div class="row">
		<?php include_once '../views/fragmentos/alertas.php'; ?>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
			<!--h2 class="text-dark">Lista de Sucursales</h2-->
			<h4 class="text-dark" style="text-decoration: underline;"><strong>Lista de Usuarios</strong></h4>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12">
			<button type="button" class="btn btn-secondary btn-sm float-xl-right float-lg-right float-md-right float-sm-right float-right" name="usuario" value="">Agregar usuario</button>
		</div>
	</div>
	<br>	<div class="table-responsive-sm">
		<table class="table table-hover table-striped table-sm" id="sucursales">
			<thead class="thead-dark">
				<tr>
					<th>Nombre</th>
					<th>Usuario</th>
					<th>Teléfono</th>
					<th>Correo</th>
					<th>Activo</th>
					<th>Rol</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				//$where = esAdmin() ? " AND s.idsucursal = se.idsucursal AND se.idempresa = " . getEmpresa()["idempresa"] : "";
				$qry = "SELECT u.*, r.rol FROM usuarios u, roles r, admin_empresa ae 
				WHERE ae.idusuario = u.idusuario AND u.idrol = r.id  AND UPPER(r.rol) != UPPER('ADMINISTRADOR') AND ae.idempresa = " . getEmpresa()["idempresa"] ;
				
				$usuarios = $conexion->query($qry);
				if ($usuarios->num_rows > 0) {				
					while($usuario = $usuarios->fetch_assoc()) {
						echo "<tr>";
							echo "<td>" . $usuario["nombre"]  . "</td>";
							echo "<td>" . $usuario["usuario"]  . "</td>";
							echo "<td>" . $usuario["telefono"]  . "</td>";
							echo "<td>" . $usuario["correo"]  . "</td>";
							echo "<td>" . $usuario["estado"]  . "</td>";
							echo "<td>" . $usuario["rol"]  . "</td>";
							echo "<td class='text-center'><button type='button' class='btn btn-secondary btn-sm' name='usuario' value='" . $usuario['idusuario']  . "'>&#x1f589;</button></td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
			<tfoot class="thead-dark">
			<tr>
				<th>Nombre</th>
				<th>Usuario</th>
				<th>Teléfono</th>
				<th>Correo</th>
				<th>Activo</th>
				<th>Rol</th>
				<th>Acciones</th>
			</tr>
			</tfoot>
		</table>
		<br>
	</div>
	<form action="usuario" method="post" id="form">
		<input type="hidden" name="idusuario" value="" id="idsucursal">
	</form>
</div>
<?php $conexion->close(); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#sucursales').DataTable({
			lengthMenu: [10, 20, 50],
			language: {
				decimal: "",
				emptyTable: "No hay información",
				info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
				infoEmpty: "Mostrando 0 to 0 of 0 registros",
				infoFiltered: "(Filtrado de _MAX_ total registros)",
				infoPostFix: "",
				lengthMenu: "Mostrar _MENU_ registros",
				loadingRecords: "Cargando...",
				processing: "Procesando...",
				search: "Buscar:",
				thousands: ",",
				zeroRecords: "No se han encontrado resultados",
				paginate: {
					first: "Primero",
					last: "Último",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});
	});
	$("button[name='usuario']").click(function() {
		$("#idsucursal").val($(this).val());
		$("#form").submit();
	});
</script>