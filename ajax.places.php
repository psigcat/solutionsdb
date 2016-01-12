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
		$what   	= (empty($_POST['what'])) 			? null 									: $_POST['what'];
		
		/*
		$limit      = (empty($_POST['limit'])) 			? $this->_system->get('default_limit') 	: (int)$this->_system->nohacker($_POST['limit']);
		$language   = (empty($_POST['lang'])) 			? $this->_system->getBrowserLanguage() 	: $this->_system->nohacker($_POST['lang']);
		*/
		
		$what = "LIST_PROVINCES";
		//$what = "LIST_TOWNS";
		
		if($what==="LIST_PROVINCES"){
			$data		= array();
		  	$provinces 	= $places->listProvinces($data);
		  	echo json_encode($provinces);
		}else if($what==="LIST_TOWNS"){
			$id_province      = (empty($_POST['id'])) 			? 0 	: $this->_system->nohacker($_POST['id']);
			//$id_province		= "08";
		  	$towns 	= $places->listTowns($id_province);
		  	echo json_encode($towns);
		}
	}
}
		
new ControllerIndex();

?>