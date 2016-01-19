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
	
	public function updateTown($data){
		/*$this->_system->pdo_update(
				"bd1",
				"carto.municipios", "sub_aqp,ap_data_ini,ap_data_fi,sub_cla,cla_data_ini,cla_data_fi",
				array($data['town_water_provider'],$data['town_w_contract_init'],$data['town_w_contract_end'],$data['town_sanity_provider'],$data['town_s_contract_init'],$data['town_s_contract_end']),
				null,"id='".$data['id_town']."'"
			);	*/
		return array("status"=>"Accepted","message"=>"Update successful","code"=>200);
	}
	

}
?>