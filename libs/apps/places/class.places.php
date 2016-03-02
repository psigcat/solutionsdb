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
		$query		= "SELECT cmun5_ine,nmun_cc FROM carto.municipios WHERE LOWER(nmun_cc) LIKE LOWER('%".$town_name."%') ORDER BY nmun_cc ASC";
	//	echo $query;
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
	
	public function getTownInfo($cmun5_ine,$town_name){
		$query		= "SELECT cmun5_ine,ST_AsGeoJSON(ST_Envelope(geom)) as bbox, ST_AsGeoJSON(ST_Centroid(geom)) as coords FROM carto.municipios ";
		if($cmun5_ine===0){
			$town_name = str_replace("'","''",$town_name);
			$query.= "WHERE nmun_cc='".$town_name."'";
		}else{
			$query.= "WHERE cmun5_ine='".$cmun5_ine."'";
		}
	//echo $query;
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$item		= array();
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
	//*****************************                 TOWN MORE INFO	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function getExtraInfoFromTown($cmun5_ine){
		$query		= "SELECT prox_concurso,prox_prorroga,fut_prorroga,cartera,neg_2016,neg_2017,neg_2018,neg_resto,inv_2016,inv_2017,inv_2018,inv_resto,inv_total FROM carto.concesion WHERE cmun5_ine='".$cmun5_ine."'";	
		//echo $query;
		$rs 		= $this->_system->pdo_select("bd1",$query);
		

		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"prox_concurso"			=> $row['prox_concurso'],
						"prox_prorroga"			=> $row['prox_prorroga'],
						"fut_prorroga"			=> $row['fut_prorroga'],
						"cartera"				=> $row['cartera'],
						"neg_2016"				=> $row['neg_2016'],
						"neg_2017"				=> $row['neg_2017'],
						"neg_2018"				=> $row['neg_2018'],
						"neg_resto"				=> $row['neg_resto'],
						"inv_2016"				=> $row['inv_2016'],
						"inv_2017"				=> $row['inv_2017'],
						"inv_2018"				=> $row['inv_2018'],
						"inv_resto"				=> $row['inv_resto'],
						"inv_total"				=> $row['inv_total']		
				);
			}
		}else{
					$item 	= array(
						"prox_concurso"			=> null,
						"prox_prorroga"			=> null,
						"fut_prorroga"			=> null,
						"cartera"				=> null,
						"neg_2016"				=> null,
						"neg_2017"				=> null,
						"neg_2018"				=> null,
						"neg_resto"				=> null,
						"inv_2016"				=> null,
						"inv_2017"				=> null,
						"inv_2018"				=> null,
						"inv_resto"				=> null,
						"inv_total"				=> null				
				);
		}
		return array("status"=>"Accepted","message"=>$item,"code"=>200);	
	}
	

	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                END TOWN MORE INFO	          ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                  UPDATE TOWN 	              ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function updateTown($data,$id_town){
		//chapuza que suma un día antes de hacer el update
		if(!empty($data['ap_data_ini'])){
			$time 					= strtotime($data['ap_data_ini']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['ap_data_ini']	= date("Y-m-d",$nuevafecha);
		}
		if(!empty($data['ap_data_fi'])){
			$time 					= strtotime($data['ap_data_fi']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['ap_data_fi']		= date("Y-m-d",$nuevafecha);
		}
		if(!empty($data['cla_data_ini'])){
			$time 					= strtotime($data['cla_data_ini']);
			$nuevafecha 			= strtotime ('+1 day' ,$time);
			$data['cla_data_ini']	= date("Y-m-d",$nuevafecha);
		}
		if(!empty($data['cla_data_fi'])){
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
	
	public function updateConcesion($data,$cmun5_ine){
		if($this->_concesionExists($cmun5_ine)>0){
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
		
			$this->_system->pdo_update("bd1", "carto.concesion", $strData, $aData, null,"cmun5_ine='".$cmun5_ine."'");
			return array("status"=>"Accepted","message"=>"Update successful","code"=>200);
		}else{
			return $this->_insertConcesion($data,$cmun5_ine);
		}
	}
	
	private function _concesionExists($cmun5_ine){
		$query		= "SELECT cmun5_ine FROM carto.concesion WHERE cmun5_ine='".$cmun5_ine."'";	
		$rs 		= $this->_system->pdo_select("bd1",$query);
		return count($rs);
	}
	
	private function _insertConcesion($data,$cmun5_ine){
		$strData = '';
		$strValues = '';
		$data['cmun5_ine']	= $cmun5_ine;
		foreach ($data as $key => $value){
			$strData .= $key.',';
			$strValues .= "'".$value."',";
		}
		$strData = substr($strData, 0, -1);
		$strValues = substr($strValues, 0, -1);
/*echo $strData."\n";
print_r($aData);*/
		$this->_pgConnect();
		$query = "INSERT INTO carto.concesion (".$strData.") VALUES (".$strValues.")";
		//echo $query;
		$result 	= pg_query($query);
		return array("status"=>"Accepted","message"=>"Insert successful","code"=>200);
	}
	
	
	private function _pgConnect(){
		// Connecting, selecting database
		$dbconn = pg_connect("host=localhost dbname=".$this->_system->get('_database_bd1')." user=".$this->_system->get('_user_bd1')." password=".	$this->_system->get('_password_bd1')."") or die('Could not connect: ' . pg_last_error());
		return $dbconn;
	}

	public function addGeometry($data){
		$epsg 	= explode(":", $data['epsg']);
		$dbconn	= $this->_pgConnect();
		//perform the insert using pg_query
		$query = "INSERT INTO edicion.".$data['layer']." (geom,name) VALUES (ST_Transform(ST_GeomFromText('".$data['geometry']."', ".$epsg[1]."), 25831),'".$data['point_name']."') RETURNING id";
		//echo $query;
		$result 	= pg_query($query);
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		return array("status"=>"Accepted","message"=>$insert_id,"code"=>200);
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

	
	public function previewReport($data){
		$query		= "SELECT cmun5_ine, nmun_cc, sub_aqp, cla_data_fi, cla_data_ini,sub_cla,ap_data_ini,ap_data_fi,habitantes,area_km2 FROM carto.municipios WHERE 1=1 ";
		
		//municipios fields
		if($data['nmun_cc']){
			$query		.=	" AND nmun_cc='".$data['nmun_cc']."'";		
		} 
		if($data['cpro_dgc']){
			$query		.=	" AND cpro_dgc='".$data['cpro_dgc']."'";		
		}
		if($data['area_km2']){
			$query		.=	" AND area_km2>'".$data['area_km2']."'";		
		}
		if($data['habitantes']){
			$query		.=	" AND habitantes>'".$data['habitantes']."'";		
		}
		if($data['sub_aqp']){
			$query		.=	" AND sub_aqp='".$data['sub_aqp']."'";		
		}
		if($data['sub_cla']){
			$query		.=	" AND sub_cla='".$data['sub_cla']."'";		
		}
		//concesion fields
		
		/*if($data['prox_concurso']){
			$query		.=	" AND prox_concurso='".$data['prox_concurso']."'";		
		}
		if($data['fut_prorroga']){
			$query		.=	" AND fut_prorroga='".$data['fut_prorroga']."'";		
		}
		if($data['neg_2016']){
			$query		.=	" AND neg_2016='".$data['neg_2016']."'";		
		}
		if($data['neg_2017']){
			$query		.=	" AND neg_2017='".$data['neg_2017']."'";		
		}
		if($data['neg_2018']){
			$query		.=	" AND neg_2018='".$data['neg_2018']."'";		
		}
		if($data['neg_resto']){
			$query		.=	" AND neg_resto='".$data['neg_resto']."'";		
		}
		if($data['inv_2016']){
			$query		.=	" AND inv_2016='".$data['inv_2016']."'";		
		}
		if($data['inv_2017']){
			$query		.=	" AND inv_2017='".$data['inv_2017']."'";		
		}
		if($data['inv_2018']){
			$query		.=	" AND inv_2018='".$data['inv_2018']."'";		
		}
		if($data['inv_resto']){
			$query		.=	" AND inv_resto='".$data['inv_resto']."'";		
		}
		if($data['inv_total']){
			$query		.=	" AND inv_total='".$data['inv_total']."'";		
		}		*/
		


		$query		.= " ORDER BY nmun_cc ASC";
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
		return array("status"=>"Accepted","message"=>$retorno,"code"=>200,"query"=>$query);
		
	}
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