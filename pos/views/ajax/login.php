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
			

			$usuarios = $conexion->query($sql);

			if ($usuarios->num_rows > 0) {
				$usuario = $usuarios->fetch_assoc();

				if ($usuario["estado"] == true) {

					if ((strtolower($usuario["rol"] ) == strtolower("administrador")) || 
						(strtolower($usuario["rol"] ) == strtolower("master"))){
						//echo "rol: administrador, master";
						$qry = "SELECT em.* FROM empresa em, admin_empresa ae 
						WHERE em.idempresa = ae.idempresa AND ae.idusuario = " . $usuario["idusuario"];
					} else {
						//echo "rol: cajero, encargado";
						$qry = "SELECT su.*, em.rfc FROM usuario_sucursal usu, empresa em, sucursal su 
						WHERE usu.idsucursal = su.idsucursal AND usu.idempresa = em.idempresa AND usu.idusuario = " . $usuario["idusuario"];
					}

					$empresas = $conexion->query($qry);
					$empresa = $empresas->fetch_assoc();
					setUsuario($usuario);
					setEmpresa($empresa);

					http_response_code(200);
					$data = array('message' => "ok");
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