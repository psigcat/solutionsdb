<?php
class ControllerIndex{
	private $_system;
	function __construct()
	{
		require_once 'libs/config.php';
		$this->_system = System::singleton();
		if($_SESSION['consumerdb']){
			$data["baseHref"]	= $this->_system->GetBaseRef();
			$data["skin"]		= $this->_system->get('skin');
			$data['env']		= $this->_system->getEnviroment();
			$this->_system->fShow($this->_system->get('skin')."/tpl_demo_map.php",$data);
		}else{
			echo "No access to this page";
		}
	}	
}	
new ControllerIndex();
?>