<?php 

/**
 * Clases donde se define el path de la vista
 */
class ViewMdl{


	public static function getViewMdl($view='') {
		
		$pathView = "views/templates/home.php";

		if ($view == "home" || $view == "activar" || $view == "login" || $view == "registrarse" || $view == "dashboard") {
			
			$pathView = "views/templates/" . $view . ".php";

		}

		return $pathView;
	}

	public static function getViewAdminMdl($view='') {
		
		$pathView = "views/templates/home.php";

		if ($view == "home" || $view == "dashboard" || 
			$view == "sucursales" || $view == "sucursal" || 
			$view == "usuarios" || $view == "usuario" || 
			$view == "proveedores" || $view == "proveedor") {
			
			$pathView = "views/templates/" . $view . ".php";

		}

		return $pathView;
	}

}

 ?>