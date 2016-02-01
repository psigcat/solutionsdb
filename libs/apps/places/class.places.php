<?php
class Places {

	private $_system;	
				
	public function __construct(){
		$this->_system = System::singleton();
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                     LISTS 	                  ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
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
	
	public function listTownsFromName($town_name){
		$query		= "SELECT cmun5_ine,nmun_cc FROM carto.municipios WHERE nmun_cc LIKE '".ucfirst($town_name)."%' ORDER BY nmun_cc ASC";
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
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                     GET TOWN 	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function getTownInfo($id_town,$town_name){
		$query		= "SELECT cmun5_ine,ST_AsGeoJSON(ST_Envelope(geom)) as bbox, ST_AsGeoJSON(ST_Centroid(geom)) as coords FROM carto.municipios ";
		if($id_town===0){
			$query.= "WHERE nmun_cc='".$town_name."'";
		}else{
			$query.= "WHERE cmun5_ine='".$id_town."'";
		}

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
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                 END GET TOWN 	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                  UPDATE TOWN 	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
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
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************              END UPDATE TOWN 	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************            EXPORT PROVINCE TO CSV	          ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	/*'id'			: result[0].G.id,
								'cmun_inem'		: result[0].G.cmun_inem,
								'sub_aqp'		: result[0].G.sub_aqp,
								'nmun_cc'		: result[0].G.nmun_cc,
								'cla_data_fi'	: result[0].G.cla_data_fi,
								'cla_data_ini'	: result[0].G.cla_data_ini,
								'cpro_ine'		: result[0].G.cpro_ine,
								'sub_cla'		: result[0].G.sub_cla,
								'ap_data_ini'	: result[0].G.ap_data_ini,
								'ap_data_fi'	: result[0].G.ap_data_fi,
								'sub_cla'		: result[0].G.sub_cla,
								'habitantes'	: result[0].G.habitantes,
								'area_km2'		: result[0].G.area_km2*/
	
	
	public function createReport($id_province){
		
		$query		= "SELECT cmun5_ine, nmun_cc, sub_aqp, cla_data_fi, cla_data_ini,sub_cla,ap_data_ini,ap_data_fi,habitantes,area_km2 FROM carto.municipios WHERE cpro_ine='".$id_province."' ORDER BY nmun_cc ASC";
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$retorno	= array();
		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"cmun5_ine"			=> $row['cmun5_ine'],
						"nmun_cc"			=> $row['nmun_cc'],
						"sub_aqp"			=> $row['sub_aqp'],
						"cla_data_ini"		=> $row['cla_data_ini'],
						"cla_data_fi"		=> $row['cla_data_fi'],	
						"sub_cla"			=> $row['sub_cla'],
						"ap_data_ini"		=> $row['ap_data_ini'],
						"ap_data_fi"		=> $row['ap_data_fi'],
						"habitantes"		=> $row['habitantes'],
						"area_km2"			=> $row['area_km2']
				);
				array_push($retorno, $item);
			}
		}
		$this->_eraseOldFIles();
		$file 	= $this->_createCSV($retorno,$id_province);	
		return array("status"=>"Accepted","message"=>$file,"code"=>200);
		
	}
	
	private function _createCSV($data,$province){

		$headers 	= array(
						"cmun5_ine"			=> "Código INE del municipio",
						"nmun_cc"			=> "Municipio",
						"sub_aqp"			=> "Entidad suministradora agua potable",
						"cla_data_ini"		=> "Fecha de inicio de contrato saneamiento",
						"cla_data_fi"		=> "Fecha de fin de contrato",	
						"sub_cla"			=> "Entidad suministradora de saneamiento",
						"ap_data_ini"		=> "Fecha de inicio de contrato agua",
						"ap_data_fi"		=> "Fecha de fin de contrato",
						"habitantes"		=> "habitantes",
						"area_km2"			=> "Superfície (km²)",
						""					=> ""
					);
		array_unshift($data, $headers);
		$csv_data = $this->_array_2_csv($data);
		header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
		$file_name = $this->_system->get('basedirContenidos')."csv/".$province."_".time().".csv";
		$fp = fopen($file_name, 'w');
		fputs($fp, ";".$csv_data);
		fclose($fp);
		return $file_name;
	}
	
	private function _array_2_csv($array) {
	    $csv = array();
	   
	    foreach ($array as $item) {

	        if (is_array($item)) {
		
	            $csv[] = $this->_array_2_csv($item)."\n";
	        } else {

	            $csv[] = '"'.$item.'"';
	        }
	    }
	    //echo $csv[0];
		//print_r($csv);
	    return implode(';', $csv);

	} 
	
	private function _eraseOldFIles(){
		$retorno 	= array();
		if ($handle = opendir($this->_system->get('basedirContenidos')."csv")) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." ) {
					@unlink($this->_system->get('basedirContenidos')."csv/".$entry);	
				}
		    }
			closedir($handle);
		}
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************        END EXPORT PROVINCE TO CSV	          ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************

}
?>