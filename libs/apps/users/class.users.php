<?php
class Users {

	private $_system;	
				
	public function __construct(){
		$this->_system = System::singleton();
	}
	

	public function login($user,$pwd){
			
		if($user===USER1 && $pwd===PWD1){
			$access		= array(
							"consumerdb"	=> 1,
							"dbmanager"		=> 1,
							"dbquality"		=> 1,
							"dbwater"		=> 1,
							"dbbnergy"		=> 1,
							"update"		=> 1
			);
			$retorno	= array(
							"status"	=> "Accepted",
							"message"	=> array(
											"access"	=> $access
											),
							"code"		=> 200
				
			);
		}else if($user===USER2 && $pwd===PWD1){
			$access		= array(
							"consumerdb"	=> 1,
							"dbmanager"		=> 1,
							"dbquality"		=> 1,
							"dbwater"		=> 1,
							"dbbnergy"		=> 1,
							"update"		=> 0
			);
			$retorno	= array(
							"status"	=> "Accepted",
							"message"	=> array(
											"access"	=> $access
											),
							"code"		=> 200
				
			);
			
			
		
			
		}else{
			$retorno	= array(
							"status"	=> "Failed",
							"message"	=> "user or password invalid",
							"code"		=> 404
				
			);
		}
		return $retorno;
		
		/*$retorno	= "";
		$query 		= "SELECT * FROM testtable WHERE id=1";
		//echo $query;
		$rs 		= $this->_system->pdo_select("bd1",$query);
		if(count($rs)>0){
			return array("status"=>"Accepted","message"=>$retorno);
		}else{
			return array("status"=>"Failed","message"=>$retorno);
		}*/
		
	}
}
?>