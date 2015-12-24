<?php

class ControllerIndex{
	private $_system;
	function __construct()
	{


		require_once 'libs/config.php';
		$this->_system = System::singleton();
		new Check();
		
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data['env']		= $this->_system->getEnviroment();
		
		$data['consumerdb']	= $_SESSION['consumerdb'];
		$data['dbmanager']	= $_SESSION['dbmanager'];
		$data['dbquality']	= $_SESSION['dbquality'];
		$data['dbwater']	= $_SESSION['dbwater'];
		$data['dbbnergy']	= $_SESSION['dbbnergy'];

		$this->_system->fShow($this->_system->get('skin')."/tpl_home.php",$data);
		
	}
 
	
}
		
new ControllerIndex();

?>