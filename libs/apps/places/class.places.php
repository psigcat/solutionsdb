<?php
class Places {

	private $_system;	
				
	public function __construct(){
		$this->_system = System::singleton();
	}
	
	public function listProvinces($data){
		$query		= "SELECT * FROM carto.provincias ORDER BY name ASC";
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$retorno	= array();
		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"id"			=> $row['id'],
						"name"			=> $row['name'],
						"delegation"	=> $row['delegation']
				);
				array_push($retorno, $item);
			}
		}
		return array("status"=>"Accepted","message"=>$retorno,"total"=>count($rs),"code"=>200);
	}
	
	public function listTowns($id_province){
		//$query		= "SELECT * FROM carto.municipios LIMIT 0 OFFSET 10";
		$query		= "SELECT cmun5_ine, nmun_cc FROM carto.municipios WHERE cpro_ine='".$id_province."' ORDER BY nmun_cc ASC";
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
	
	public function getTownInfo($id_town){
		$query		= "SELECT cmun5_ine,ST_AsGeoJSON(ST_Envelope(geom)) as bbox, ST_AsGeoJSON(ST_Centroid(geom)) as coords FROM carto.municipios WHERE cmun5_ine='".$id_town."'";
		$rs 		= $this->_system->pdo_select("bd1",$query);

		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"id"			=> $row['cmun5_ine'],
						"bbox"			=> $row['bbox'],
						"coords"		=> $row['coords']
				);
				
			}
		}
		return array("status"=>"Accepted","message"=>$item,"code"=>200);	
	}
	
	public function updateTown($data,$id_town){
		//chapuza que suma un día antes de hacer el update
		if($data['ap_data_ini']){
			$time 					= strtotime($data['ap_data_ini']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['ap_data_ini']	= date("Y-m-d",$nuevafecha);
		}
		if($data['ap_data_fi']){
			$time 					= strtotime($data['ap_data_fi']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['ap_data_fi']		= date("Y-m-d",$nuevafecha);
		}
		if($data['cla_data_ini']){
			$time 					= strtotime($data['cla_data_ini']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['cla_data_ini']	= date("Y-m-d",$nuevafecha);
		}
		if($data['cla_data_fi']){
			$time 					= strtotime($data['cla_data_fi']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['cla_data_fi']	= date("Y-m-d",$nuevafecha);
		}
	
		$strData = '';
		$aData = array();
		foreach ($data as $key => $value){
			$strData .= $key.',';
			array_push($aData, $value);
		}
		$strData = substr($strData, 0, -1);



/*echo $id_town."\n";
echo $strData."\n";
print_r($aData);*/
	
		$this->_system->pdo_update("bd1", "carto.municipios", $strData, $aData, null,"id='".$id_town."'");
		

		return array("status"=>"Accepted","message"=>"Update successful","code"=>200);
	}
	

}
?>