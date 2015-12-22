<?php
/****************************************************
 * CLASS ErrorLogger
 * 6/11/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
 * Gestiona los errores, creando un log personalizado
 
 Imprime el error en pantalla
 

 
***************************************************/
class ErrorLogger{
	private static $instancia = null; //instancia para controlar el singleton
	private $_fecha;
	private $_system;
	function __construct(){
		$this->_system = System::singleton();
		$ObFecha=new Fecha();
		$this->_fecha=$ObFecha->soloFecha();
	}
	public static function singleton() 
	{
		if( self::$instancia == null ) 
		{
			self::$instancia = new self();
		}
			return self::$instancia;
	}
	public function imprError($err){
		/*$archivolog="../../../".$this->_system->get('carpetaLogs')."/log_".$this->_fecha.".txt";
		$log=fopen($archivolog,"a+");
		fputs($log,"ERROR: ".$err."\n");
		fclose($log); */

		echo "ERROR: ".$err." - ".$this->_fecha."<br>";
		

	}
	

}
?>