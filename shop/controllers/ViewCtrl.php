<?php 

/**
 * @author JOSE BENITO <JOOSBEEN@GMAIL.COM>
 */
class ViewCtrl {
	
	public function getViewTemplateCtrl() {
		
		$action = isset($_GET["action"]) ? $_GET["action"] : "index";

		$template = ViewMdl::getViewTemplateMdl($action);

		include_once $template;
	}
}

 ?>