<?php

class ControllerIndex{
	private $_system;
	private $_hat;
	private $_shoe;
	function __construct()
	{
		header('Content-Type: application/json');
		require_once 'libs/config.php'; //Archivo con configuraciones.
		$this->_system = System::singleton();//contiene objeto system
		$_POST 		= json_decode(file_get_contents('php://input'), true);
		require_once 'libs/apps/alerts/class.alerts.php';
		$alerts 	= new Alerts();
		
		$what   	= (empty($_POST['what'])) 			? null 		: $_POST['what'];
		$token   	= (empty($_POST['token'])) 			? null 		: $_POST['token'];

		if($token===session_id()){
			if($what==="LIST_ALERTS"){
				$period   	= (empty($_POST['period'])) 	? null 		: $_POST['period'];
				$type   	= (empty($_POST['type'])) 		? null 		: $_POST['type'];
				$data		= array(
								'period'		=> $period,
								'type'			=> $type
				);
				$current_alerts 	= $alerts->listAlerts($data);
				echo json_encode($current_alerts);
			}
		}else{
			echo json_encode(array("status"=>"Failed","message"=>"Cross site injection detected","code"=>501));
		}
	}
}
		
new ControllerIndex();

?>