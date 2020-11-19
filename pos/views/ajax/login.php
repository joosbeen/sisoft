<?php 

	require_once '../../pos/models/global.php';
	require_once '../../pos/models/conexion/conexion.php';
	require_once '../../pos/util/util.php';
	require_once '../../pos/util/sesion.php';

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: POST');

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$username = $_POST["username"];
		$password = $_POST["password"];

		$error = "";

		if (empty($username) || trim($username) == "") {
			$error .= "* Campo <strong>Usuario</strong> es obligatorio. ";
		} else if(strlen(str_replace(" ", "", $username)) != strlen($username)){
			$error .= "* Campo <strong>Usuario</strong> no debe contener espacios. ";
		}

		if (empty($password) || trim($password) == "") {
			$error .= "* Campo <strong>Contraseña</strong> es obligatorio. ";
		} else if(strlen(str_replace(" ", "", $password)) != strlen($password)){
			$error .= "* Campo <strong>Contraseña</strong> no debe contener espacios. ";
		}

		if ($error == "") {

			//Crear conexion
			$conexion = conexion();

			$sql = "SELECT u.*, r.rol FROM usuarios u, roles r WHERE u.idrol = r.id AND (UPPER(u.usuario)=UPPER('" . $username . "') OR UPPER(u.correo)=UPPER('" . $username . "') ) AND u.contrasena=MD5('" . $password  . "');";
			//$sql = "SELECT * FROM admin_empresa WHERE (UPPER(correo_empresa)=UPPER('" . $username . "') OR UPPER(nombre_usuario)=UPPER('" . $username . "')) AND contrasena=MD5('" . $password  . "');";
			

			$result = $conexion->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();

				if ($row["estado"] === true) {
					crearSesion($row);
					$conexion->close();
					$data = array('message' => 'ok');
					echo json_encode($data);					
				} else {
					http_response_code(403);
					$data = array('message' => "* El estado se encuentra inactivo, contacte a su administrador.");
					echo json_encode($data);
				}
				
			} else {
				http_response_code(403);
				$data = array('message' => "* Usuario/Contraseña incorrecto.");
				echo json_encode($data);
			}

			//Cerrar sesion
			$conexion->close();

		} else {
			http_response_code(403);
			$data = array('message' => $error);
			echo json_encode($data);
		}
		



	}  else {
		http_response_code(403);
		$data = array('message' => 'La peticion no puede ser respondida como la solicito');
		echo json_encode($data);
	}

 ?>