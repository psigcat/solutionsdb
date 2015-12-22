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
	
		$pedo="contenido de una variable";
		$data['unavariable']=$pedo;
		$this->_system->fShow("shoe.php",$data);
	}
}
?>