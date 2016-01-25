<?php
/****************************************************
 * CLASS Hat
 * 22/1/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
 * gestiona el hat (metatags, etc..)

 * FUNCIONES +
 - fDameBase() -> devuelve la url actual para el meta base href, para que cargue los css/img y js con urls modificadas por mod_rewrite
***************************************************/

class Hat{
	private $_ruta;
	private $_system;
	private $_detect;
	function __construct(){
		$this->_system = System::singleton();//contiene objeto system
	   	$this->_ruta=$this->_system->GetBaseRef();
	   	
	   	$this->_detect = new Mobile_Detect();
   	}
	public function fDameBase(){

		return $this->_ruta;
			
	}
	public function pintaHat($page){
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data["env"]		= $this->_system->getEnviroment();
		$data["lang"]		= $_SESSION['lang'];
		$data['isMobile']	= $this->_detect->isMobile();
		
		$data['nooverflow'] = ($page == 'login' || $page == 'home') ? false : true;
		
		$this->_system->fShow($this->_system->get('skin')."/hat.php",$data);
	}
}
?>