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
		$password = $_POST["password"];
		$usuario = $_POST["usuario"];
		$unombre = $_POST["unombre"];
		$direccion = $_POST["direccion"];
		$utelefono = $_POST["utelefono"];
		$ucorreo = $_POST["ucorreo"];

		$mensaje = "";
		//*********************************
		//****** DATOS DE LA EMPRESA ******
		//*********************************
		if (esVacio($empresa)) {
			$mensaje .= "* <strong>Datos de Empresa</strong> Campo nombre: es obligatorio. <br />";
		}
		if (esVacio($rfc)) {
			$mensaje .= "* <strong>Datos de Empresa</strong> Campo rfc: es obligatorio. <br />";
		}
		if (esVacio($telefono)) {
			$mensaje .= "* <strong>Datos de Empresa</strong> Campo télefono: es obligatorio. <br />";
		}
		if (esVacio($correo)) {
			$mensaje .= "* <strong>Datos de Empresa</strong> Campo correo: es obligatorio. <br />";
		} else if(!esEmail($correo)){
			$mensaje .= "* <strong>Datos de Empresa</strong> Campo correo: formato incorrecto. <br />";
		}

		//*********************************
		//******* DATOS DEL USUARIO *******
		//*********************************
		if (esVacio($password)) {
			$mensaje .= "* <strong>Datos de Usuario</strong> Campo contraseña: es obligatorio. <br />";
		}
		if (esVacio($usuario)) {
			$mensaje .= "* <strong>Datos de Usuario</strong> Campo usuario: es obligatorio. <br />";
		}
		if(esVacio($unombre)){
			$mensaje .= "* <strong>Datos de Usuario</strong> Campo nombre: es obligatorio. <br />";
		}
		if(esVacio($utelefono)){
			$mensaje .= "* <strong>Datos de Usuario</strong> Campo télefono: es obligatorio. <br />";
		}
		if(esVacio($ucorreo)){
			$mensaje .= "* <strong>Datos de Usuario</strong> Campo correo: es obligatorio. <br />";
		}

		if ($mensaje == "") {

			$codigo = generarCodigoVerificacion();

			//Crear conexion
			$conexion = conexion();

			$sql = "SELECT * FROM admin_empresa WHERE UPPER(rfc_empresa)=UPPER('$empresa') OR UPPER(telefono_empresa)=UPPER('$telefono') OR UPPER(correo_empresa) = UPPER('$correo');";
			
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

					$insertEmpresa = "INSERT INTO admin_empresa(nombre_empresa, rfc_empresa, telefono_empresa, correo_empresa, estado) 
							VALUES ('$empresa', '$rfc', '$telefono', '$correo', false);";
							
					if ($conexion->query($insertEmpresa) === TRUE) {

						$idempresa = $conexion->insert_id;

						$insertSucursal = "INSERT INTO sucursal(direccion, telefono, correo, admin_empresa_idadmin_empresa) VALUES('$direccion', '$telefono', '$correo', $idempresa);";

						if ($conexion->query($insertSucursal) === TRUE) {
									
							$idsucursal = $conexion->insert_id;
							$codigo_verificacion = generarCodigoVerificacion();

							$insertUsuario = "INSERT INTO usuarios(nombre, usuario, contrasena, telefono, correo, sucursal_idsucursal, estado, fecha_creacion, idrol, codigo_verificacion) VALUES ('$unombre', '$usuario', '$password', '$utelefono', '$ucorreo', $idsucursal, false ,NOW(), 1, '$codigo_verificacion');";

							if ($conexion->query($insertUsuario) === TRUE) {
									
								$idusuario = $conexion->insert_id;

								$qryUsuario = "SELECT u.*, ae.nombre_empresa, ae.rfc_empresa, ae.telefono_empresa, ae.estado AS 'estado_empresa', s.direccion AS 'direccion_empresa', r.rol FROM usuarios u, admin_empresa ae, sucursal s, roles r WHERE u.idrol = r.id AND s.admin_empresa_idadmin_empresa = ae.idadmin_empresa AND u.idusuario=$idusuario;";

								$result = $conexion->query($qryUsuario);

								if ($result->num_rows > 0) {										    
									$row = $result->fetch_assoc();
									crearSesion($row);
									httpResponseCode_Mensaje(200, 'ok');
								}

							} else {
								$conexion->query("DELETE FROM admin_empresa WHERE idadmin_empresa=$idempresa;");
								$conexion->query("DELETE FROM sucursal WHERE idsucursal=$idsucursal;");
								httpResponseCode_Mensaje(403, 'No se logro registrarse, intentelo mas tarde.');
							}
											
						} else {
							$conexion->query("DELETE FROM admin_empresa WHERE idadmin_empresa=$idempresa;");
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