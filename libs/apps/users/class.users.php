<?php
class Users {

	private $_system;	
				
	public function __construct(){
		$this->_system = System::singleton();
	}
	

	public function login($user,$pwd){
		if($pwd==="12345"){
			$retorno	= array("status"=>"Failed","message"=>"Password must be regenerated","code"=>412);
		}else{
			$query 		= "SELECT * FROM var.users WHERE nick='".$user."' AND password='".$this->_encriptpwd($pwd)."'";
			$rs 		= $this->_system->pdo_select("bd1",$query);
			if(count($rs)>0){
				$row		= $rs[0];
				$access		= array(
								"id"			=> $row['id'],
								"consumerdb"	=> $row['dbconsumer'],
								"dbmanager"		=> $row['dbmanager'],
								"dbquality"		=> $row['dbquality'],
								"dbwater"		=> $row['dbwater'],
								"dbbnergy"		=> $row['dbenergy'],
								"dbconsumer"	=> $row['dbconsumer'],
								"update"		=> $row['edition']
				);			$this->_system->pdo_update(
					"bd1",
					"var.users", "last_login,last_ip",
					array(date("Y-m-d H:i:s"),$_SERVER['REMOTE_ADDR']),
					null,"id='".$row['id']."'"
				);
				$retorno 	= array("status"=>"Accepted","message"=>$access);
			}else{
				$retorno	= array("status"=>"Failed","message"=>"Wrong email o password","code"=>401);
			}
		}
		return $retorno;		
	}
	
	
	public function getUser($id=null,$email=null){
		$retorno	= array();
		if($email){
			$query 		= "SELECT * FROM var.users WHERE email='".$email."'";
		}else{
			$query 		= "SELECT * FROM var.users WHERE id='".$id."'";
		}

		$rs 		= $this->_system->pdo_select("bd1",$query);
		/*echo "<pre>";
		print_r($rs);
		echo "</pre>";*/
		if(count($rs)===1){
			$row	= $rs[0];
			$item	= array(
						"id"			=> $row['id'],
						"full_name"		=> $row['fullname'],
						"email"			=> $row['email'],
						"last_login"	=> $row['last_login'],
						"last_ip"		=> $row['last_ip']
			);
			return array("status"=>"Accepted","message"=>$item,"code",200);
		}else{
			return array("status"=>"Failed","message"=>"Admin not found","code"=>404);
		}		
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************               PASSWORD RECOVERY 	          ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function recoveryRequest($email){
		$exists	= $this->getUser(null,$email);
		if($exists['status']==="Accepted"){
			$hash 	= $this->_generateRecoveryHash();
			$id 	= $this->_system->pdo_insert(
						"bd1",
						"var.users_recovery",
						"users_id,hash,date_create,ip_create",
						array(
							$exists['message']['id'],
							$hash,
							date("Y-m-d H:i:s"),
							$_SERVER['REMOTE_ADDR']
						)
						);
			$this->sendRecoveryMail($email,$hash);

			return array("status"=>"Accepted","message"=>"recovery hash code generated","code"=>200);
		}else{
			return array("status"=>"Failed","message"=>"users not found","code"=>404);
		}		
	}
	
	
	public function validateRecoveryHash($hash){
		$query 		= "SELECT * FROM var.users_recovery WHERE hash='".$hash."'";
		$rs 		= $this->_system->pdo_select("bd1",$query);
		/*echo "<pre>";
		print_r($rs);
		echo "</pre>";*/
		if(count($rs)===1){
			$row	= $rs[0];
			if($row['date_act']==""){
				$item	= array(
							"users_id"			=> $row['users_id']
				);
				$this->_system->pdo_update(
				"bd1",
				"var.users_recovery", "ip_act,date_act",
				array($_SERVER['REMOTE_ADDR'],date("Y-m-d H:i:s")),
				null,"id='".$row['id']."'"
			);
				return array("status"=>"Accepted","message"=>$item,"code"=>200);
			}else{
				return array("status"=>"Failed","message"=>"Recovery code not valid","code"=>000);
			}
		}else{
			return array("status"=>"Failed","message"=>"Recovery code not found","code"=>404);
		}
	}
	
	private function _generateRecoveryHash(){
		$letras  	=	"23456789qwertyupasdfghkzxcvbnm"."98765432mnbvcxzkhgfdsapuytrewq";
		$semilla 	= 	microtime()*1000000 + intval(65487215, 10);
		mt_srand($semilla);
		$clave 		=	"";
		$len   		= 	strlen($letras) - 1;
		for($i = 0; $i < 8; $i++) {
	    	$clave .= $letras[ mt_rand(0, $len) ];
	    }
	    return md5($clave);
	}
	
	/***
		sendRecoveryMail
			Envia un mail con el one time link para regenar el password
		@param $email (string y email válido)
		@param JSON
		
	***/
	
	public function sendRecoveryMail($email,$hash){
		$response = false;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
				$link = 'http://'.$_SERVER['HTTP_HOST'].'/aqualia/www/solutionsdb/recovery.php?h='.$hash;
				
				$subject = "Recovery password";
				$message = '<html><body>';
				$message .= '<h1>Recovery password</h1>';
				$message .= '<p>You can reset your password following this link:<br /><a href="'.$link.'">RECOVERY_LINK</a><br /></p>';
				$message .= '<p><a href="'.$link.'">'.$link.'</a></p>';
				$message .= '</body></html>';
	
				$headers = "From: no-reply@solutionsdb.net\r\n";
				$headers .= "Reply-To: no-reply@solutionsdb.net\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				$response = mail($email, $subject, $message, $headers, '-fsuport@domain.com');
			
		}
		return $response;
	}
	
	public function resetPwd($id,$pwd){
		$this->_system->pdo_update(
				"bd1",
				"var.users", "password",
				array($this->_encriptpwd($pwd)),
				null,"id='".$id."'"
			);
		return array("status"=>"Accepted","message"=>"User succesfully updated","code"=>200);	
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************              END PASSWORD RECOVERY 	          ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************

	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                    HELPERS	                  ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
	public function testCript($txt){
		echo $this->_encriptpwd($txt);
	}
	public function testMail($email){
		$this->_sendMailToAdmin($email,"test","body test");
	}
	
	private function _sendMailToAdmin($email,$subject,$message){			
		$headers = "From: webmaster@loquesea.coop" . "\r\n" .
		'Reply-To:  webmaster@loquesea.coop' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		if(mail($email, $subject, $message, $headers)){
			echo "mail sent";
		}else{
			echo "mail failed";
		}
	}
	
	private function _encriptpwd($pwd){
		return md5($pwd);
	}
	
	//**********************************************************************************************************
	//**********************************************************************************************************
	//*****************************                 END HELPERS	                  ******************************
	//**********************************************************************************************************
	//**********************************************************************************************************
	
}
?>