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
		
		$notes		= $this->readNotes($cmun5_ine);
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
						"inv_total"				=> $row['inv_total'],
						"notes"					=> $notes['message']			
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
						"inv_total"				=> null,
						"notes"					=> $notes['message']			
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
	//*****************************                  SEGUIMIENTO	               *****************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function addNote($data){
		$fecha		= date("Y-m-d H:i:s");
		$dbconn		= $this->_pgConnect();
		//perform the insert using pg_query
		$query 		= "INSERT INTO carto.seguimiento (municipio_id,user_id,fecha_seg,mensaje) VALUES ('".$data['municipio_id']."','".$data['user_id']."','".$fecha."','".$data['mensaje']."') RETURNING id";
		//echo $query;
		$result 	= pg_query($query);
		$insert_row = pg_fetch_row($result);
		$insert_id 	= $insert_row[0];
		$retorno 	= array(
							"id"				=> $insert_id,
							"mensaje"			=> $data['mensaje'],
							"nick"				=> $_SESSION['nick'],
							"fecha_seg"			=> date("Y-m-d H:i:s")
							);
		return array("status"=>"Accepted","message"=>$retorno,"code"=>200);
	}
	
	public function readNotes($cmun5_ine){
		$query		= "SELECT a.mensaje as mensaje, a.fecha_seg as fecha_seg, b.nick as nick FROM carto.seguimiento as a, var.users as b WHERE a.municipio_id='".$cmun5_ine."' AND b.id=a.user_id ORDER BY a.fecha_seg ASC";
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$retorno	= array();
		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"mensaje"			=> $row['mensaje'],
						"fecha_seg"			=> $row['fecha_seg'],
						"nick"				=> $row['nick'],
				);
				array_push($retorno, $item);
			}
		}
		return array("status"=>"Accepted","message"=>$retorno,"code"=>200);
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                END SEGUIMIENTO	               *****************************
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

	
	public function previewReport($data,$createFile,$limit){
	//	$query		= "SELECT a.cpro_dgc,a.cmun5_ine,a.nmun_cc, a.sub_aqp, a.cla_data_fi, a.cla_data_ini,a.sub_cla,a.ap_data_ini,a.ap_data_fi,a.habitantes,a.area_km2,b.fut_prorroga,b.prox_concurso,b.neg_2016,b.neg_2017,b.neg_2018,b.neg_resto,b.inv_2016,b.inv_2017,b.inv_2018,b.inv_resto,b.inv_total,b.gestor,b.tipo,b.cartera,c.zona,c.delegation,c.unidad_gestion,b.prox_prorroga FROM carto.municipios as a, carto.concesion as b, carto.provincias as c WHERE a.cmun5_ine=b.cmun5_ine AND a.cpro_ine=c.id";
	$query ="SELECT
a.cpro_ine,a.cpro_dgc,a.cmun5_ine,a.nmun_cc, a.sub_aqp, a.cla_data_fi, a.cla_data_ini,a.sub_cla,a.ap_data_ini,a.ap_data_fi,a.habitantes,a.area_km2,
b.fut_prorroga,b.prox_concurso,b.neg_2016,b.neg_2017,b.neg_2018,b.neg_resto,b.inv_2016,b.inv_2017,b.inv_2018,b.inv_resto,b.inv_total,b.gestor,b.tipo,b.cartera,
c.zona,c.delegation,c.unidad_gestion,b.prox_prorroga
FROM carto.municipios as a LEFT JOIN carto.concesion as b ON a.cmun5_ine=b.cmun5_ine LEFT join carto.provincias as c ON a.cpro_ine=c.id";
		//municipios fields
		if($data['cpro_dgc']){
			$query		.=	" AND a.cpro_dgc='".$data['cpro_dgc']."'";		
		}
		if($data['area_km2']){
			$query		.=	" AND a.area_km2>".number_format((int)$data['area_km2'], 0, ',', '.');		
		}
		if($data['habitantes']){
			$query		.=	" AND a.habitantes>".(int)$data['habitantes'];		
		}
		if($data['sub_aqp']){
			$query		.=	" AND a.sub_aqp='".$data['sub_aqp']."'";		
		}
		if($data['sub_cla']){
			$query		.=	" AND a.sub_cla='".$data['sub_cla']."'";		
		}
		
		if($data['ap_data_ini']){
			$data['ap_data_ini']	= date("Y-m-d",strtotime($data['ap_data_ini']));
			$query		.=	" AND a.ap_data_ini>'".$data['ap_data_ini']."'";		
		}
		if($data['ap_data_fi']){
			$data['ap_data_fi']	= date("Y-m-d",strtotime($data['ap_data_fi']));
			$query		.=	" AND a.ap_data_fi<'".$data['ap_data_fi']."'";		
		}
		
		if($data['cla_data_ini']){
			$data['cla_data_ini']	= date("Y-m-d",strtotime($data['cla_data_ini']));
			$query		.=	" AND a.cla_data_ini>'".$data['cla_data_ini']."'";		
		}
		if($data['cla_data_fi']){
			$data['cla_data_fi']	= date("Y-m-d",strtotime($data['cla_data_fi']));
			$query		.=	" AND a.cla_data_fi<'".$data['cla_data_fi']."'";		
		}
		
		//concesion fields
		if($data['prox_concurso']){
			$query		.=	" AND b.prox_concurso='".$data['prox_concurso']."'";		
		}
		if($data['fut_prorroga']){
			$query		.=	" AND b.fut_prorroga='".$data['fut_prorroga']."'";		
		}
		if($data['neg_2016']){
			$query		.=	" AND b.neg_2016='".$data['neg_2016']."'";		
		}
		if($data['neg_2017']){
			$query		.=	" AND b.neg_2017='".$data['neg_2017']."'";		
		}
		if($data['neg_2018']){
			$query		.=	" AND b.neg_2018='".$data['neg_2018']."'";		
		}
		if($data['neg_resto']){
			$query		.=	" AND b.neg_resto='".$data['neg_resto']."'";		
		}
		if($data['inv_2016']){
			$query		.=	" AND b.inv_2016='".$data['inv_2016']."'";		
		}
		if($data['inv_2017']){
			$query		.=	" AND b.inv_2017='".$data['inv_2017']."'";		
		}
		if($data['inv_2018']){
			$query		.=	" AND b.inv_2018='".$data['inv_2018']."'";		
		}
		if($data['inv_resto']){
			$query		.=	" AND b.inv_resto='".$data['inv_resto']."'";		
		}
		if($data['inv_total']){
			$query		.=	" AND b.inv_total='".$data['inv_total']."'";		
		}		
		


		$query		.= " ORDER BY nmun_cc ASC";
		if($limit){
			$query 	.= " LIMIT ".$limit." OFFSET 0";
		}
//echo $query;
		$rs 		= $this->_system->pdo_select("bd1",$query);
		$retorno	= array();
		if(count($rs)>0){
			foreach($rs as $row){
				$item 	= array(
						"cpro_dgc"			=> $row['cpro_dgc'],
						"cmun5_ine"			=> $row['cmun5_ine'],
						"nmun_cc"			=> $row['nmun_cc'],
						"sub_aqp"			=> $row['sub_aqp'],
						"cla_data_ini"		=> $row['cla_data_ini'],
						"cla_data_fi"		=> $row['cla_data_fi'],	
						"sub_cla"			=> $row['sub_cla'],
						"ap_data_ini"		=> $row['ap_data_ini'],
						"ap_data_fi"		=> $row['ap_data_fi'],
						"habitantes"		=> $row['habitantes'],
						"area_km2"			=> $row['area_km2'],
						"fut_prorroga"		=> $row['fut_prorroga'],
						"prox_concurso"		=> $row['prox_concurso'],
						"neg_2016"			=> $row['neg_2016'],
						"neg_2017"			=> $row['neg_2017'],
						"neg_2018"			=> $row['neg_2018'],
						"neg_resto"			=> $row['neg_resto'],
						"inv_2016"			=> $row['inv_2016'],
						"inv_2017"			=> $row['inv_2017'],
						"inv_2018"			=> $row['inv_2018'],
						"inv_resto"			=> $row['inv_resto'],
						"inv_total"			=> $row['inv_total'],
						"gestor"			=> $row['gestor'],
						"tipo"				=> $row['tipo'],
						"cartera"			=> $row['cartera'],
						"zona"				=> $row['zona'],
						"delegation"		=> $row['delegation'],
						"unidad_gestion"	=> $row['unidad_gestion'],
						"prox_prorroga"		=> $row['prox_prorroga']
				);
				array_push($retorno, $item);
			}
		}
		if($createFile){
			return $this->_createReport($retorno);
		}else{
			return array("status"=>"Accepted","message"=>$retorno,"code"=>200,"query"=>$query,"total"=>count($retorno));	
		}
			
	}
	
	private function _createReport($retorno){	
		
		
		$baseRow = 7;
		/** PHPExcel_IOFactory */
		require_once $this->_system->get('carpetaIncludes')."PHPExcel/Classes/PHPExcel/IOFactory.php";
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("includes/template.xls");
		foreach($retorno as $r => $dataRow) {
		/*echo "<pre>";
		print_r($dataRow);
		echo "</pre>";*/
		$row = $baseRow + $r;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['zona'])
	                              ->setCellValue('C'.$row, $dataRow['delegation'])
	                              ->setCellValue('D'.$row, $dataRow['unidad_gestion'])
	                              ->setCellValue('E'.$row, $dataRow['nmun_cc'])
	                              ->setCellValue('F'.$row, $dataRow['tipo'])
	                              ->setCellValue('G'.$row, $dataRow['sub_aqp'])
	                              ->setCellValue('H'.$row, $dataRow['neg_resto'])
	                              ->setCellValue('I'.$row, $dataRow['cla_data_fi'])
	                              ->setCellValue('J'.$row, $dataRow['prox_concurso'])
	                              ->setCellValue('K'.$row, $dataRow['prox_prorroga'])
	                              ->setCellValue('L'.$row, $dataRow['fut_prorroga'])
	                              ->setCellValue('M'.$row, $dataRow['neg_2017'])
	                              ->setCellValue('N'.$row, $dataRow['neg_2018'])
	                              ->setCellValue('O'.$row, $dataRow['neg_resto'])
	                              ->setCellValue('R'.$row, $dataRow['cartera'])
	                              ->setCellValue('T'.$row, $dataRow['inv_2016'])
	                              ->setCellValue('U'.$row, $dataRow['inv_2017'])
	                              ->setCellValue('V'.$row, $dataRow['inv_2018'])
	                              ->setCellValue('W'.$row, $dataRow['inv_resto'])
	                              ->setCellValue('X'.$row, $dataRow['inv_total']);
		}

		
		
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$file 		= $this->_system->get('basedirContenidos')."xls/".session_id()."_".time().".xls";
		$objWriter->save($file);
	//	$this->_eraseOldFIles();
		return array("status"=>"Accepted","message"=>$retorno,"file"=>$file,"code"=>200,"total"=>count($retorno));		
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