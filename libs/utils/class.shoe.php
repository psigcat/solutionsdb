<?php
/****************************************************
 * CLASS shoe
 * 22/1/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
 * gestiona el shoe 


***************************************************/

class Shoe{
	private $_system;
	function __construct(){
		$this->_system = System::singleton();//contiene objeto system
   	}
	
	public function pintaShoe(){
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data["env"]		= $this->_system->getEnviroment();
		
		$this->_system->fShow($this->_system->get('skin')."/shoe.php",$data);
	}
}
?>