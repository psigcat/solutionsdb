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
		$query		= "SELECT municipios.cmun5_ine, municipios.nmun_cc, fecha_venc FROM carto.concesion INNER JOIN carto.municipios ON concesion.cmun5_ine = carto.municipios.cmun5_ine WHERE fecha_venc < current_date + ".$days." ORDER BY fecha_venc";
		//$query		= "SELECT cmun5_ine, nmun_cc FROM carto.municipios WHERE cpro_ine='08' ORDER BY nmun_cc ASC";
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