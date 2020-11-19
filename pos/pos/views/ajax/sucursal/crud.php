<?php 

	require_once '../../../models/global.php';
	require_once '../../../models/conexion/conexion.php';
	require_once '../../../util/sesion.php';

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: POST, GET');

	function httpResponseCode_Mensaje($codigo, $mensaje) {		
		http_response_code($codigo);
		$data = array('message' => $mensaje);
		echo json_encode($data);
	}

	function httpResponseCode_Data($data) {
		echo json_encode($data);
	}

	function validarCampos(){



	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$datos = array(
			'idsucursal' => $_POST[""] , 
			'descripcion' => $_POST[""] , 
			'direccion' => $_POST[""] , 
			'telefono' => $_POST[""] , 
			'correo' => $_POST[""] , 
			'acciones' => $_POST[""] , 
			'admin_empresa_idadmin_empresa');
		
	} else if ($_SERVER['REQUEST_METHOD'] == "GET") {

		$conexion = conexion();
		
		$pagina = (isset($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] :  0;		
		$limite = (isset($_GET["limit"]) && $_GET["limit"] != "") ? $_GET["limit"] : 10;

		if($_GET["action"] == "paginacion") {

			$sql = "SELECT count(*) AS 'filas' FROM sucursal;";
			$result = $conexion->query($sql);
			$row = $result->fetch_assoc();

			$paginas = $row["filas"] / $limite;

			$pagina_actual = $paginas - ($pagina + 1);

			$pagina_restante = $paginas - $pagina_actual;

			$datos = array('paginas' => ceil($paginas), 'restante' => $pagina_restante);

			echo json_encode($datos);


		} else if($_GET["action"] == "filas"){
			$pagina = (isset($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] :  0;
			$limite = (isset($_GET["limit"]) && $_GET["limit"] != "") ? $_GET["limit"] : 10;

			$sql = "SELECT * FROM sucursal LIMIT " . ($pagina * $limite) . ", " . $limite . ";";
			$result = $conexion->query($sql);
			$data = array();
			
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $data[] = $row;
			    }
			} else {
			    $data;
			}
			echo json_encode($data);
		}
		$conexion->close();		
	} else {
		httpResponseCode_Mensaje(403, 'Petición invalida.');
	}