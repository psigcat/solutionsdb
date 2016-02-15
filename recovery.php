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
		$pwd1      			= (empty($_POST['pwd1'])) 			? null	: $this->_system->nohacker($_POST['pwd1']);
		$pwd2      			= (empty($_POST['pwd2'])) 			? null	: $this->_system->nohacker($_POST['pwd2']);
		

		$hash      			= (empty($_GET['h'])) 				? null	: $this->_system->nohacker($_GET['h']);
		$token      		= (empty($_POST['token'])) 			? null	: $this->_system->nohacker($_POST['token']);
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
	
		if($pwd1){
			if($token===session_id()){
				$id      			= (empty($_POST['id'])) 			? null	: $this->_system->nohacker($_POST['id']);
				require_once 'libs/apps/users/class.users.php';
				$users		= new Users();
				$request 	= $users->resetPwd($id,$pwd1);
				
				$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_4.php",$data);
			}else{
				echo "Cross site injection detected";
			}
		}else{
			if($hash){
				require_once 'libs/apps/users/class.users.php';
				$users	= new Users();
				$request 	= $users->validateRecoveryHash($hash);
				/*
				echo "<pre>";
				print_r($request);
				echo "</pre>";
				*/
				if($request['status']==="Accepted"){
					$data['id']		= $request['message']['users_id'];
					$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_3.php",$data);
				}else{
					$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_5.php",$data);
				}
				
			}else{
				$this->_system->fShow($this->_system->get('skin')."/tpl_pwd_recovery_5.php",$data);
			}
		}

		$this->_shoe->pintaShoe();

	}
 	
}
		
new ControllerIndex();

?>