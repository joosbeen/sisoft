<?php 

	require_once '../../pos/util/validar.php';
	require_once '../../pos/models/conexion/conexion.php';
	require_once '../../pos/util/util.php';
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

		$empresa = $_POST["empresa"];
		$rfc = $_POST["rfc"];
		$telefono = $_POST["telefono"];
		$correo = $_POST["correo"];
		$direccion = $_POST["direccion"];

		$password = $_POST["password"];
		$usuario = $_POST["usuario"];
		$unombre = $_POST["unombre"];
		$utelefono = $_POST["utelefono"];
		$ucorreo = $_POST["ucorreo"];

		//*********************************
		//****** DATOS DE LA EMPRESA ******
		//*********************************
		$mensajeEmpresa = "";
		if (esVacio($empresa)) {
			$mensajeEmpresa .= "* Nombre: es obligatorio. <br />";
		}
		if (esVacio($rfc)) {
			$mensajeEmpresa .= "* RFC: es obligatorio. <br />";
		}
		if (esVacio($telefono)) {
			$mensajeEmpresa .= "* Télefono: es obligatorio. <br />";
		}
		if (esVacio($correo)) {
			$mensajeEmpresa .= "* Correo: es obligatorio. <br />";
		} else if(!esEmail($correo)){
			$mensajeEmpresa .= "* Correo: formato incorrecto. <br />";
		}
		if (esVacio($direccion)) {
			$mensajeEmpresa .= "* Dirección: es obligatorio. <br />";
		}

		if (!esVacio($mensajeEmpresa)) {
			$mensajeEmpresa = "Datos de Empresa <br /><br />" . $mensajeEmpresa;
			
		}

		//*********************************
		//******* DATOS DEL USUARIO *******
		//*********************************
		$mensajeUsuario = "";
		if (esVacio($password)) {
			$mensajeUsuario .= "* <strong>Datos de Usuario</strong> Campo contraseña: es obligatorio. <br />";
		}
		if (esVacio($usuario)) {
			$mensajeUsuario .= "* <strong>Datos de Usuario</strong> Campo usuario: es obligatorio. <br />";
		}
		if(esVacio($unombre)){
			$mensajeUsuario .= "* <strong>Datos de Usuario</strong> Campo nombre: es obligatorio. <br />";
		}
		if(esVacio($utelefono)){
			$mensajeUsuario .= "* <strong>Datos de Usuario</strong> Campo télefono: es obligatorio. <br />";
		}
		if(esVacio($ucorreo)){
			$mensajeUsuario .= "* <strong>Datos de Usuario</strong> Campo correo: es obligatorio. <br />";
		}

		if (!esVacio($mensajeUsuario)) {
			$mensajeUsuario = "Datos de Usuario <br /><br />" . $mensajeUsuario;
			
		}

		$mensaje = $mensajeEmpresa . $mensajeUsuario;

		if ($mensaje == "") {

			$codigo = generarCodigoVerificacion();

			//Crear conexion
			$conexion = conexion();

			$sql = "SELECT * 
			FROM empresa 
			WHERE UPPER(rfc)=UPPER('$empresa') OR UPPER(telefono)=UPPER('$telefono') OR UPPER(correo) = UPPER('$correo');";
			
			$result = $conexion->query($sql);
			
			if ($result->num_rows > 0) {

				$empresa = $result->fetch_assoc();

				if ($empresa["rfc_empresa"] != "") {
					$mensaje .= "* <strong>RFC de la empresa</strong> ya se encuentra registrado. ";
				}
				if ($empresa["telefono_empresa"] != "") {
					$mensaje .= "* <strong>Télefono de la empresa</strong> ya se encuentra registrado. ";
				}
				if ($empresa["correo_empresa"] != "") {
					$mensaje .= "* <strong>Correo de la empresa</strong> ya se encuentra registrado. ";
				}
				httpResponseCode_Mensaje(403, $mensaje);				

			} else {

				$sql = "SELECT * FROM usuarios WHERE UPPER(correo)=UPPER('$ucorreo') OR UPPER(telefono)=UPPER('$utelefono');";
				$selectUsuario = $conexion->query($sql);
				if ($selectUsuario->num_rows > 0) {

					$usuarioVO = $result->fetch_assoc();

					if ($usuarioVO["correo"] != "") {
						$mensaje .= "* <strong>Correo de la usuario</strong> ya se encuentra registrado. ";
					}
					if ($usuarioVO["telefono"] != "") {
						$mensaje .= "* <strong>Télefono de la empresa</strong> ya se encuentra registrado. ";
					}
					httpResponseCode_Mensaje(403, $mensaje);

				} else {

					$insertEmpresa = "INSERT INTO empresa(nombre, direccion, rfc, correo, telefono, estado, fecha_creada) 
					VALUES ('$empresa', '$direccion', '$rfc', '$correo', '$telefono', true, now());";
							
					if ($conexion->query($insertEmpresa) === TRUE) {

						$idempresa = $conexion->insert_id;

						$codigo_verificacion = generarCodigoVerificacion();

						$insertUsuario = "INSERT INTO usuarios(nombre, usuario, contrasena, telefono, correo, estado, fecha_creacion, idrol, codigo_verificacion) VALUES ('$unombre', '$usuario', MD5('$password'), '$utelefono', '$ucorreo', false, NOW(), 1, '$codigo_verificacion');";

						if ($conexion->query($insertUsuario) === TRUE) {
								
							$idusuario = $conexion->insert_id;

							$insertAdmin_empresa = "INSERT INTO admin_empresa(idusuario, idempresa) VALUES ($idusuario, $idempresa);";
							
							if ($conexion->query($insertAdmin_empresa) === TRUE) {

								$selectDatos = "SELECT us.*, ro.rol 
								FROM usuarios us, roles ro 
								WHERE us.idrol = ro.id AND us.idusuario = " . $idusuario;

								$selectUsuario = $conexion->query($selectDatos);
								$usuarioVO = $selectUsuario->fetch_assoc();

								$selectDatos = "SELECT ae.* 
								FROM usuarios us, admin_empresa ae, empresa em 
								WHERE ae.idusuario = us.idusuario AND ae.idempresa = em.idempresa AND ae.idusuario = $idusuario AND ae.idempresa = $idempresa";

								$selectEmpresa = $conexion->query($selectDatos);
								$empresaVO = $selectEmpresa->fetch_assoc();

								crearSesion($usuarioVO);
								setEmpresa($empresaVO);
								
								httpResponseCode_Mensaje(200, 'ok');

							}

						} else {
							$conexion->query("DELETE FROM empresa WHERE idempresa=$idempresa;");
							httpResponseCode_Mensaje(403, 'No se logro registrarse, intentelo mas tarde.');
						}

					} else {
						httpResponseCode_Mensaje(403, 'No se logro registrarse, intentelo mas tarde.');
					}
				}

			}
			$conexion->close();
				
		} else {
			httpResponseCode_Mensaje(403, $mensaje);
		}

	} else {
		httpResponseCode_Mensaje(403, 'La peticion no puede ser respondida como la solicito');
	}

 ?>