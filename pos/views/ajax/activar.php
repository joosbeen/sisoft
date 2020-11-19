<?php 

	require_once '../../pos/models/conexion/conexion.php';
	require_once '../../pos/util/sesion.php';
	require_once '../../pos/models/global.php';

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: POST');

	function httpResponseCode_Mensaje($codigo, $mensaje) {		
		http_response_code($codigo);
		$data = array('message' => $mensaje);
		echo json_encode($data);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$codigo = $_POST["codigo"];

		$error = "";

		if (empty($codigo)) {
			$error .= "* Campo <strong>Código de Verificación</strong> es obligatorio.";
		} else if (!is_numeric($codigo)) {
			$error .= "* Campo <strong>Código de Verificación</strong> debe ser numérico.";
		} else if (strlen($codigo) != 6) {
			$error .= "* Campo <strong>Código de Verificación</strong> 6 dígitos.";
		}

		if ($error == "") {
			
			$conexion = conexion();

			$sql = "SELECT * FROM usuarios WHERE correo='" . obtenerSession()["correo"] . "' LIMIT 1;" ;

			$result = $conexion->query($sql);

			if ($result->num_rows > 0) {
				
				$row = $result->fetch_assoc();

				if ($row["estado"] == true) {
					httpResponseCode_Mensaje(403, 'La cuenta ya se encuentra activada. Inicie sesión.');
				} else {

					if ($row["codigo_verificacion"] == $codigo) {

						$sql = "UPDATE admin_empresa SET estado=true WHERE idadmin_empresa=" . $row["idadmin_empresa"] . ";";
						$sql = "UPDATE admin_empresa SET estado=true WHERE idadmin_empresa=" . $row["idadmin_empresa"] . ";";

						if ($conexion->query($sql) === TRUE) {
							httpResponseCode_Mensaje(200, 'ok');						    
						} else {
							httpResponseCode_Mensaje(403, 'No se pudo activar la cuenta, inténtelo de nuevo.');						    
						}

					} else {	
						httpResponseCode_Mensaje(403, 'El código de verificación incorrecto.');
					}

				}

			} else {
				httpResponseCode_Mensaje(403, 'La peticion no puede ser respondida como la solicito');
			}

			$conexion->close();

		} else {
			httpResponseCode_Mensaje(403, $error);
		}


	} else {
		httpResponseCode_Mensaje(403, 'La peticion no puede ser respondida como la solicito');
	}

 ?>