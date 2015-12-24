<?php
/****************************************************
 * CLASS check
 * 
  
 * Checks Session
***************************************************/
class Check{

	public function __construct($needed=true){	
		if ($needed === true){		
			if (!isset($_SESSION['logged'])){
				header('Location:index.php');
				exit();
			}
		}	
	}
	
	public function isExplorer(){
	    $u_agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i',$u_agent)){
            return true;
        }
        else{
	        return false;
        }
    }
}
?>