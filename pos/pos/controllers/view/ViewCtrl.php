<?php 

/**
 * Clase para especificar la vista que se mostrara.
 */
class ViewCtrl {
	
	public function getViewCtrl() {
		
		$view = (isset($_GET["action"]) ? $_GET["action"] : "login");

		$pathView = ViewMdl::getViewMdl($view);

		include_once $pathView;
	}

	public function getViewAdminCtrl() {
		
		$view = (isset($_GET["action"]) ? $_GET["action"] : "home");

		$pathView = ViewMdl::getViewAdminMdl($view);

		include_once $pathView;
		
	}
}



 ?>