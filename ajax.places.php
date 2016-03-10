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
			}else if($what==="LIST_TOWNS_FROM_NAME"){
				$town_name      = (empty($_POST['town_name'])) 	? null 	: $this->_system->nohacker($_POST['town_name']);
				$towns 			= $places->listTownsFromName($town_name );
				echo json_encode($towns);
			}else if($what==="TOWN_INFO"){
				$id_town     	= (empty($_POST['id'])) 		? 0 	: $this->_system->nohacker($_POST['id']);
				$town_name      = (empty($_POST['town_name'])) 	? null 	: $this->_system->nohacker($_POST['town_name']);
				$town			= $places->getTownInfo($id_town,$town_name);
				echo json_encode($town);		
			}else if($what==="UPDATE_TOWN"){
				if((int)$_SESSION['update']===1){
					$id_town    			= (empty($_POST['id_town'])) 				? null : $this->_system->nohacker($_POST['id_town']);
					$town_water_provider	= (empty($_POST['town_water_provider'])) 	? null : $this->_system->nohacker($_POST['town_water_provider']);
					$town_w_contract_init   = (empty($_POST['town_w_contract_init'])) 	? null : $this->_system->nohacker($_POST['town_w_contract_init']);
					$town_w_contract_end    = (empty($_POST['town_w_contract_end'])) 	? null : $this->_system->nohacker($_POST['town_w_contract_end']);
					$town_sanity_provider   = (empty($_POST['town_sanity_provider'])) 	? null : $this->_system->nohacker($_POST['town_sanity_provider']);
					$town_s_contract_init	= (empty($_POST['town_s_contract_init'])) 	? null : $this->_system->nohacker($_POST['town_s_contract_init']);
					$town_s_contract_end    = (empty($_POST['town_s_contract_end'])) 	? null : $this->_system->nohacker($_POST['town_s_contract_end']);
					$town_observations    	= (empty($_POST['town_observations'])) 		? null : $this->_system->nohacker($_POST['town_observations']);
					$town_govern    		= (empty($_POST['town_govern'])) 			? null : $this->_system->nohacker($_POST['town_govern']);
					
					$prox_prorroga    		= (empty($_POST['prox_prorroga'])) 			? null : $this->_system->nohacker($_POST['prox_prorroga']);
					$prox_concurso    		= (empty($_POST['prox_concurso'])) 			? null : $this->_system->nohacker($_POST['prox_concurso']);
					$fut_prorroga    		= (empty($_POST['fut_prorroga'])) 			? null : $this->_system->nohacker($_POST['fut_prorroga']);
					$cartera    			= (empty($_POST['cartera'])) 				? null : $this->_system->nohacker($_POST['cartera']);
					$neg_2016    			= (empty($_POST['neg_2016'])) 				? null : $this->_system->nohacker($_POST['neg_2016']);
					$neg_2017    			= (empty($_POST['neg_2017'])) 				? null : $this->_system->nohacker($_POST['neg_2017']);
					$neg_2018    			= (empty($_POST['neg_2018'])) 				? null : $this->_system->nohacker($_POST['neg_2018']);
					$inv_2016    			= (empty($_POST['inv_2016'])) 				? null : $this->_system->nohacker($_POST['inv_2016']);
					$inv_2017    			= (empty($_POST['inv_2017'])) 				? null : $this->_system->nohacker($_POST['inv_2017']);
					$inv_2018    			= (empty($_POST['inv_2018'])) 				? null : $this->_system->nohacker($_POST['inv_2018']);
					$inv_resto    			= (empty($_POST['inv_resto'])) 				? null : $this->_system->nohacker($_POST['inv_resto']);
					$neg_resto    			= (empty($_POST['neg_resto'])) 				? null : $this->_system->nohacker($_POST['neg_resto']);
					$inv_total    			= (empty($_POST['inv_total'])) 				? null : $this->_system->nohacker($_POST['inv_total']);
					$cmun5_ine				= (empty($_POST['cmun5_ine'])) 				? null : $this->_system->nohacker($_POST['cmun5_ine']);
					$data					= array(
												'sub_aqp'		=> $town_water_provider,
												'sub_cla'		=> $town_sanity_provider,
												'gobierno'		=> $town_govern,
												'observaciones'	=> $town_observations,
					);
					$dataConcesion			= array(
												'prox_prorroga'	=> $prox_prorroga,
												'prox_concurso'	=> $prox_concurso,
												'fut_prorroga'	=> $fut_prorroga,
												'cartera'		=> $cartera,
												'neg_2016'		=> $neg_2016,
												'neg_2017'		=> $neg_2017,
												'neg_2018'		=> $neg_2018,
												'inv_2016'		=> $inv_2016,
												'inv_2017'		=> $inv_2017,
												'inv_2018'		=> $inv_2018,
												'inv_resto'		=> $inv_resto,
												'neg_resto'		=> $neg_resto,
												'inv_total'		=> $inv_total
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
						$concesion		= $places->updateConcesion($dataConcesion,$cmun5_ine);
						echo json_encode($town);
					}else{
						echo json_encode(array("status"=>"Failed","message"=>"id_town can't be null","code"=>501));
					}
				}else{
					echo json_encode(array("status"=>"Failed","message"=>"Permission denied. User can't update","code"=>501));
				}
			}else if($what==="PREVIEW_REPORT"){
					
				$cpro_dgc     	 	= (empty($_POST['cpro_dgc'])) 				? null 	: $this->_system->nohacker($_POST['cpro_dgc']);	
				$area_km2     	 	= (empty($_POST['area_km2'])) 				? null 	: $this->_system->nohacker($_POST['area_km2']);	
				$habitantes    		= (empty($_POST['habitantes'])) 			? null 	: $this->_system->nohacker($_POST['habitantes']);	
				$sub_aqp     	 	= (empty($_POST['sub_aqp'])) 				? null 	: $this->_system->nohacker($_POST['sub_aqp']);	
				$ap_data_ini     	= (empty($_POST['ap_data_ini'])) 			? null 	: $this->_system->nohacker($_POST['ap_data_ini']);	
				$ap_data_fi     	= (empty($_POST['ap_data_fi'])) 			? null 	: $this->_system->nohacker($_POST['ap_data_fi']);	
				$sub_cla     		= (empty($_POST['sub_cla'])) 				? null 	: $this->_system->nohacker($_POST['sub_cla']);	
				$cla_data_ini     	= (empty($_POST['cla_data_ini'])) 			? null 	: $this->_system->nohacker($_POST['cla_data_ini']);	
				$cla_data_fi     	= (empty($_POST['cla_data_fi'])) 			? null 	: $this->_system->nohacker($_POST['cla_data_fi']);	
				$prox_concurso     	= (empty($_POST['prox_concurso'])) 			? null 	: $this->_system->nohacker($_POST['prox_concurso']);	
				$fut_prorroga     	= (empty($_POST['fut_prorroga'])) 			? null 	: $this->_system->nohacker($_POST['fut_prorroga']);	
				$cartera     	 	= (empty($_POST['cartera'])) 				? null 	: $this->_system->nohacker($_POST['cartera']);	
				$neg_2016     	 	= (empty($_POST['neg_2016'])) 				? null 	: $this->_system->nohacker($_POST['neg_2016']);	
				$neg_2017     	 	= (empty($_POST['neg_2017'])) 				? null	: $this->_system->nohacker($_POST['neg_2017']);	
				$neg_2018     	 	= (empty($_POST['neg_2018'])) 				? null	: $this->_system->nohacker($_POST['neg_2018']);	
				$neg_resto     	 	= (empty($_POST['neg_resto'])) 				? null	: $this->_system->nohacker($_POST['neg_resto']);				
				$inv_2016     	 	= (empty($_POST['inv_2016'])) 				? null	: $this->_system->nohacker($_POST['inv_2016']);	
				$inv_2017     	 	= (empty($_POST['inv_2017'])) 				? null	: $this->_system->nohacker($_POST['inv_2017']);	
				$inv_2018     	 	= (empty($_POST['inv_2018'])) 				? null	: $this->_system->nohacker($_POST['inv_2018']);	
				$inv_resto     	 	= (empty($_POST['inv_resto'])) 				? null	: $this->_system->nohacker($_POST['inv_resto']);	
				$inv_total     	 	= (empty($_POST['inv_total'])) 				? null	: $this->_system->nohacker($_POST['inv_total']);
				$createFile     	= (empty($_POST['createFile'])) 			? null	: $this->_system->nohacker($_POST['createFile']);	
				
				$data					= array(
												
												'cpro_dgc'		=> $cpro_dgc,
												'habitantes'	=> $habitantes,
												'area_km2'		=> $area_km2,
												'sub_aqp'		=> $sub_aqp,
												'ap_data_ini'	=> $ap_data_ini,
												'ap_data_fi'	=> $ap_data_fi,
												'sub_cla'		=> $sub_cla,
												'cla_data_ini'	=> $cla_data_ini,
												'cla_data_fi'	=> $cla_data_fi,
												'prox_concurso'	=> $prox_concurso,
												'fut_prorroga'	=> $fut_prorroga,
												'cartera'		=> $cartera,
												'neg_2016'		=> $neg_2016,
												'neg_2017'		=> $neg_2017,
												'neg_2018'		=> $neg_2018,
												'neg_resto'		=> $neg_resto,
												'inv_2016'		=> $inv_2016,
												'inv_2017'		=> $inv_2017,
												'inv_2018'		=> $inv_2018,
												'inv_resto'		=> $inv_resto,
												'inv_total'		=> $inv_total
					);

				
				
				$report				= $places->previewReport($data,$createFile);
				echo json_encode($report);	
			}else if($what==="CREATE_REPORT"){
//				$id_province     	= (empty($_POST['province_id'])) 			? 0 	: $this->_system->nohacker($_POST['province_id']);	
//				$report				= $places->createReport($id_province);
//				echo json_encode($report);
			}else if($what==="GET_TOWN_EXTRA_INFO"){
				$cmun5_ine    		= (empty($_POST['cmun5_ine'])) 				? null : $this->_system->nohacker($_POST['cmun5_ine']);
				
				$extra				= $places->getExtraInfoFromTown($cmun5_ine);
				echo json_encode($extra);
			}else if($what==="ADD_NOTE"){
				$municipio_id     	= (empty($_POST['municipio_id'])) 			? 0 	: $this->_system->nohacker($_POST['municipio_id']);	
				$mensaje     		= (empty($_POST['mensaje'])) 				? 0 	: $this->_system->nohacker($_POST['mensaje']);	
				$data 				= array(
											"mensaje"		=> $mensaje,
											"municipio_id"	=> $municipio_id,
											"user_id"		=> $_SESSION['id']
										);
				
				
				$extra				= $places->addNote($data);
				echo json_encode($extra);

			}
		}else{
			echo json_encode(array("status"=>"Failed","message"=>"Cross site injection detected","code"=>501));
		}
	}
}
		
new ControllerIndex();

?>