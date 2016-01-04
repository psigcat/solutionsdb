<?php

class ControllerIndex{
	private $_system;
	private $_hat;
	private $_shoe;
	function __construct()
	{


		require_once 'libs/config.php';
		$this->_system = System::singleton();
		
		$this->_hat = new Hat();
		$this->_shoe = new Shoe();
		
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data["env"]		= $this->_system->getEnviroment();
		
		$this->_hat->pintaHat();
	
		$this->_system->fShow($this->_system->get('skin')."/tpl_maqueta.php",$data);
		
		$this->_shoe->pintaShoe();
		
	}
 
	
}
		
new ControllerIndex();

?>