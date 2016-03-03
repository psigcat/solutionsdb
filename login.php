<?php

class ControllerIndex{
	private $_system;
	function __construct()
	{

		require_once 'libs/config.php'; //Archivo con configuraciones.
		$this->_system = System::singleton();//contiene objeto system
		if($_POST['token']!=session_id()){
			header('location: error.php');
		}else{
			require_once 'libs/apps/users/class.users.php'; //Archivo con configuraciones.
			$users	= new Users();
			$user	= $this->_system->nohacker($_POST['user']);
			$pwd	= $this->_system->nohacker($_POST['pwd']);

			$login	= $users->login($user,$pwd);
			/*echo "<pre>";
			print_r($login);
			echo "</pre>";
	*/
			if($login['status']==="Accepted"){
				$_SESSION['logged']			= true;
				$_SESSION['id']				= $login['message']['id'];
				$_SESSION['nick']			= $_POST['user'];
				$_SESSION['consumerdb']		= $login['message']['consumerdb'];
				$_SESSION['dbmanager']		= $login['message']['dbmanager'];
				$_SESSION['dbquality']		= $login['message']['dbquality'];
				$_SESSION['dbwater']		= $login['message']['dbwater'];
				$_SESSION['dbbnergy']		= $login['message']['dbbnergy'];
				$_SESSION['update']			= (int)$login['message']['update'];
				/*echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";*/
				header('location: home.php');
			}else{
				header('location: index.php?e=login_error');
			}
		}
	}
 	
}
		
new ControllerIndex();
?>