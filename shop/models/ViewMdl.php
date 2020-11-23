<?php 
/**
 * @author JOSE BENITO GARCIA SOLANO <JOOSBEEN@GMAIL.COM>
 */
class ViewMdl {
	
	public static function getViewTemplateMdl($action) {

		$template = "views/templates/index.php";

		if ($action == "index"  || $action == "servicios" || $action == "contacto" || 
			$action == "productos" || $action == "registrar" || $action == "compras") {
			$template = "views/templates/" . $action . ".php";
		}

		return $template;
		
	}
}

 ?>