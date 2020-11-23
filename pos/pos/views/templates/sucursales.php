<?php
$conexion = conexion();
?>
<div class="container">
	<div class="row">
		<?php include_once '../views/fragmentos/alertas.php'; ?>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
			<!--h2 class="text-dark">Lista de Sucursales</h2-->
			<h4 class="text-dark" style="text-decoration: underline;"><strong>Lista de Sucursales</strong></h4>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12">
			<button type="button" class="btn btn-secondary btn-sm float-xl-right float-lg-right float-md-right float-sm-right float-right" name="sucursal" value="">Agregar sucursal</button>
		</div>
	</div>
	<br>
	<div class="table-responsive-sm">
		<table class="table table-hover table-striped table-sm" id="sucursales">
			<thead class="thead-dark">
				<tr>
					<th>Descripción</th>
					<th>Dirección</th>
					<th>Teléfono</th>
					<th>Correo</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				$where = esAdmin() ? " AND s.idsucursal = se.idsucursal AND se.idempresa = " . getEmpresa()["idempresa"] : "";
				$qry = "SELECT s.* FROM sucursal s, sucursal_empresa se WHERE 1 = 1 " . $where;
				$sucursales = $conexion->query($qry);
				if ($sucursales->num_rows > 0) {				
					while($sucursal = $sucursales->fetch_assoc()) {
						echo "<tr>";
							echo "<td>" . $sucursal["nombre"]  . "</td>";
							echo "<td>" . $sucursal["direccion"]  . "</td>";
							echo "<td>" . $sucursal["telefono"]  . "</td>";
							echo "<td>" . $sucursal["correo"]  . "</td>";
							echo "<td class='text-center'><button type='button' class='btn btn-secondary btn-sm' name='sucursal' value='" . $sucursal['idsucursal']  . "'>&#x1f589;</button></td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
			<tfoot class="thead-dark">
			<tr>
				<th>Descripción</th>
				<th>Dirección</th>
				<th>Teléfono</th>
				<th>Correo</th>
				<th>Acciones</th>
			</tr>
			</tfoot>
		</table>
		<br>
	</div>
	<form action="sucursal" method="post" id="form">
		<input type="hidden" name="idsucursal" value="" id="idsucursal">
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
	$("button[name='sucursal']").click(function() {
		$("#idsucursal").val($(this).val());
		$("#form").submit();
	});
</script>