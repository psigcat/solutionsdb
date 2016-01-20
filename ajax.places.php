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
		require_once 'libs/apps/places/class.places.php';
		$places 	= new Places();
		$what   	= (empty($_POST['what'])) 			? null 		: $_POST['what'];
		$token   	= (empty($_POST['token'])) 			? null 		: $_POST['token'];

		if($token===session_id()){
			if($what==="LIST_PROVINCES"){
				$data		= array();
			  	$provinces 	= $places->listProvinces($data);
			  	echo json_encode($provinces);
			}else if($what==="LIST_TOWNS"){
				$id_province      = (empty($_POST['id'])) 			? 0 	: $this->_system->nohacker($_POST['id']);
			  	$towns 			= $places->listTowns($id_province);
			  	echo json_encode($towns);
			}else if($what==="TOWN_INFO"){
				$id_town     =	 (empty($_POST['id'])) 				? 0 	: $this->_system->nohacker($_POST['id']);
				$town			= $places->getTownInfo($id_town);
			  	echo json_encode($town);		
			}else if($what==="UPDATE_TOWN"){
				$id_town    			= (empty($_POST['id_town'])) 				? null : $this->_system->nohacker($_POST['id_town']);
				$town_water_provider	= (empty($_POST['town_water_provider'])) 	? null : $this->_system->nohacker($_POST['town_water_provider']);
				$town_w_contract_init   = (empty($_POST['town_w_contract_init'])) 	? null : $this->_system->nohacker($_POST['town_w_contract_init']);
				$town_w_contract_end    = (empty($_POST['town_w_contract_end'])) 	? null : $this->_system->nohacker($_POST['town_w_contract_end']);
				$town_sanity_provider   = (empty($_POST['town_sanity_provider'])) 	? null : $this->_system->nohacker($_POST['town_sanity_provider']);
				$town_s_contract_init	= (empty($_POST['town_s_contract_init'])) 	? null : $this->_system->nohacker($_POST['town_s_contract_init']);
				$town_s_contract_end    = (empty($_POST['town_s_contract_end'])) 	? null : $this->_system->nohacker($_POST['town_s_contract_end']);
				
				$data					= array(
											'sub_aqp'		=> $town_water_provider,
											'sub_cla'		=> $town_sanity_provider
				);
				if($town_w_contract_init){
					$data['ap_data_ini']	= $town_w_contract_init;
				}
				if($town_w_contract_end){
					$data['ap_data_fi']	= $town_w_contract_end;
				}
				if($town_s_contract_init){
					$data['cla_data_ini']	= $town_s_contract_init;
				}
				if($town_s_contract_end){
					$data['cla_data_fi']	= $town_s_contract_end;
				}
				if($id_town){
					$town			= $places->updateTown($data,$id_town);
					echo json_encode($town);
				}else{
					echo json_encode(array("status"=>"Failed","message"=>"id_town can't be null","code"=>501));
				}
				
			}	
		}else{
			echo json_encode(array("status"=>"Failed","message"=>"Cross site injection detected","code"=>501));
		}
	}
}
		
new ControllerIndex();

?>