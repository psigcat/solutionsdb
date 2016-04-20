<?php

class ControllerIndex{
	private $_system;
	function __construct()
	{


		require_once 'libs/config.php';
		$this->_system = System::singleton();
		
		
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data['env']		= $this->_system->getEnviroment();
		
		
	
		$this->_system->fShow($this->_system->get('skin')."/tpl_dbwater.php",$data);
		
	}
 
	
}
		
new ControllerIndex();

?>