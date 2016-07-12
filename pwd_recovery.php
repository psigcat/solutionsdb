<?php

class ControllerIndex{
	private $_system;
	private $_hat;
	private $_shoe;
	function __construct()
	{

		require_once 'libs/config.php';
		$this->_system 		= System::singleton();
		$this->_hat 		= new Hat();
		$this->_shoe 		= new Shoe();
		
		$data["baseHref"]	= $this->_system->GetBaseRef();
		$data["skin"]		= $this->_system->get('skin');
		$data['env']		= $this->_system->getEnviroment();
		$data['token']		= session_id();		//token for cross site injection
		
		$email      		= (empty($_POST['email'])) 			? null	: $this->_system->nohacker($_POST['email']);
		$token      		= (empty($_POST['token'])) 			? null	: $this->_system->nohacker($_POST['token']);
		$type      			= (empty($_GET['t'])) 				? null	: $this->_system->nohacker($_GET['t']);
		$this->_hat->pintaHat('login');
		
		
		
		$array_bg 			= array();
		$directory 			= $this->_system->get('background');
		$dirint 			= dir($directory);
		while (($archivo = $dirint->read()) !== false){
			if (eregi("gif", $archivo) || eregi("jpg", $archivo) || eregi("png", $archivo)){
				array_push($array_bg, $directory.$archivo);
			}
        }
		$dirint->close();
		$data['background'] = $array_bg;
		if($email){
			if($token===session_id()){
				require_once 'libs/apps/users/class.users.php';
				$users	= new Users();
				$request 	= $users->recoveryRequest($email);
				if($request['status']==="Accepted"){
					$data['ok']		= true;
					$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_2.php",$data);
				}else{
					$data['ok']		= false;
					$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_2.php",$data);
				}
			}else{
				echo "Cross site injection detected";
			}
		}else{
			$data['type']		= $type;
			$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_1.php",$data);
		}
	
	
		
		
		$this->_shoe->pintaShoe();

	}
 	
}
		
new ControllerIndex();

?>