<?php
class Alerts {

	private $_system;	
				
	public function __construct(){
		$this->_system = System::singleton();
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                     LISTS 	                  ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function listAlerts($data){
		$days		= (int)$data['period']*30;
		//$data['type']: manager_grup or dbmanager_sane
		if($data['type']==="dbmanager_sane"){
			$query		= "SELECT municipios.cmun5_ine, municipios.nmun_cc, cla_data_fi FROM carto.municipios WHERE cla_data_fi < current_date + ".$days." ORDER BY cla_data_fi";
		}else{
			$query		= "SELECT municipios.cmun5_ine, municipios.nmun_cc, ap_data_fi FROM carto.municipios WHERE ap_data_fi < current_date + ".$days." ORDER BY ap_data_fi";
		}
		//echo $query;		
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$retorno	= array();
		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"id"			=> $row['cmun5_ine'],
						"name"			=> $row['nmun_cc']
				);
				array_push($retorno, $item);
			}
		}
		return array("status"=>"Accepted","message"=>$retorno,"total"=>count($rs),"code"=>200);
	}
		
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                  END LISTS 	                  ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************	
}
?>