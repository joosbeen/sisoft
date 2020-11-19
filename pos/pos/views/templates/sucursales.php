<div class="row">
	<?php include_once '../views/fragmentos/alertas.php'; ?>
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
		<h2 class="text-dark">Lista de Sucursales</h2>
	</div>
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12">
		<button type="button" class="btn btn-secondary btn-sm float-xl-right float-lg-right float-md-right float-sm-right float-right">Agregar sucursal</button>
	</div>
</div>
<div class="table-responsive-sm">
	<table class="table table-hover table-striped table-sm">
		<thead class="thead-dark">
			<tr>
				<th>Descripción</th>
				<th>Dirección</th>
				<th>Teléfono</th>
				<th>Correo</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody id="tbody">
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
	<ul class="pagination justify-content-center">
		<li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
		<li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
		<li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
		<li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
	</ul>
</div>
<script>
	$(document).ready(function() {

		window.paginationTable = function(page,limit) {

			$.ajax({
		        type: "get",
		        dataType: "json",
		        url: "views/ajax/sucursal/crud.php?action=paginacion&page="+page+"&limit="+limit,
		        success: function(resultado) {
		        	console.log("<----- success ----->");
		        	console.log(resultado);
		        	var filas = "";
		        	
		        },
		        error: function(resultado) {
		        	console.log("<----- error ----->");
		        	console.log(resultado);
		            //$("#alertdanger").html(resultado.responseJSON.message);
		            //$("#alertdanger").show();
		        }
		    });

		}

		window.filasTable = function(action,page,limit) {
			$.ajax({
		        type: "get",
		        dataType: "json",
		        url: "views/ajax/sucursal/crud.php?action="+action+"&page="+page+"&limit="+limit,
		        success: function(resultado) {
		        	console.log("<----- success ----->");
		        	console.log(resultado);
		        	paginationTable(page,limit);
		        	var filas = "";
		        	//for (x in resultado) {
		        	//
		        	for (x = 0; x < resultado.length; x++) { 
						filas += "<tr>";
						filas += "<td>" + resultado[x].descripcion + "</td>";
						filas += "<td>" + resultado[x].direccion + "</td>";
						filas += "<td>" + resultado[x].telefono + "</td>";
						filas += "<td>" + resultado[x].correo + "</td>";
						filas += "<td><button type='button' class='btn btn-sm'><i class='fas fa-car'></i></button></td>";
						filas += "</tr>";
					}
					if (filas == "") {
						filas = "<tr><td colspan='5'></td></tr>";
					}
					$("#tbody").empty();
					$("#tbody").html(filas);


		        },
		        error: function(xhr,status,error) {
		        	console.log("<----- xhr ----->");
		        	console.log(xhr);
		        	console.log("<----- status ----->");
		        	console.log(status);
		        	console.log("<----- error ----->");
		        	console.log(error);
		            //$("#alertdanger").html(resultado.responseJSON.message);
		            //$("#alertdanger").show();
		        }
		    });
		}

		filasTable('filas',0,10);
		
	});
</script>