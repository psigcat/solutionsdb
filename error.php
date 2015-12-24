<?php

class ControllerIndex{
	private $_system;
	function __construct()
	{

		require_once 'libs/config.php'; //Archivo con configuraciones.
		$this->_system = System::singleton();//contiene objeto system
		
		echo "render error page";
	}
 	
}
		
new ControllerIndex();
?>