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
		$data['token']		= session_id();		//token for cross site injection
		
	
		$this->_system->fShow($this->_system->get('skin')."/tpl_index.php",$data);
		
	}
 
	
}
		
new ControllerIndex();

?>