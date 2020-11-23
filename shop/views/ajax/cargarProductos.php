<?php 

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: POST');

	function echoJson($http=200,$json) {		
		http_response_code($http);
		echo json_encode($json);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {


		$categoria = empty($_POST["categoria"]) ? "" : " AND categoria = '" . $_POST["categoria"] . "'";
		$marca = empty($_POST["marca"]) ? "" : " AND marca = '" . $_POST["marca"] . "'";
		$modelo = empty($_POST["modelo"]) ? "" : " AND modelo = '" . $_POST["modelo"] . "'";

		$opcion = "";

		switch ($_POST["opcion"]) {
		    case "1":
		        $opcion = " AND ";
		        break;
		    case "2":
		        $opcion = " AND ";
		        break;
		    case "3":
		        $opcion = " AND ";
		        break;
		}

		$sql = "SELECT * FROM productos WHERE 1=1 " . $categoria . $marca . $modelo . $opcion;


		$json = array( 
			"productos" => array(
				array('nombre' => 'Producto 1', 'precio' => 200, "imagen" => 'views/img/productos/1/th.jpg' ),
				array('nombre' => 'Producto 1', 'precio' => 100, "imagen" => 'views/img/productos/2/login.php')
			)
		);
		echoJson($http=200,$json);
	} else {
		$json = array('message' => 'La peticion no puede ser respondida como la solicito');
		echoJson($http=403,$json);
	}


 ?>