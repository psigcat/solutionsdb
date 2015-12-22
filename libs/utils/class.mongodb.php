<?php
/****************************************************
 * CLASS MongoDB
 * 13/12/2011
  
 * gestiona las conexiones a la base de datos mongodb

 
***************************************************/

class MongoDB_invertred{
	
	private $_servidor;					//url del servido
	private $_database;					//nombre de la bd 
	/*private $_user;						//usuario de la bd de lectura
	private $_password;					//password de la bd de lectura*/
	
	private $_logger;					//objeto ErrorLogger
	
	private static $instancia = null;	 //instancia para controlar el singleton
	private $db;
	private $m;
	

	private $_conectado;
	function __construct(){
		$this->_logger=ErrorLogger::singleton();
		$system = System::singleton();
				
	}
	public function setDataBD($server,$database,$user,$pwd){
		$this->_servidor=$server;
		$this->_database=$database;
		$this->_user=$user;
		$this->_password=$pwd;
	}
	
	public function fDameId($col){
	
		$mongo=$this->fConecta();
		
		$collection=$mongo->counter;
		$collection->update(
			array('col'=>$col),
			array('$inc'=>array('value'=>1)),
			array('upsert'=>true)
		);
		
		$cursor = $collection->find(array('col'=>$col));
		$resultados=array();
		if($cursor->count()>0){
			foreach ($cursor as $obj) {
				$id	= $obj['value'];
				
			}
		}
		
		$this->fDesconectaMongo();	
		
		return $id;
	}
	
	public function fConecta(){
		if($this->_user!=""){
			$con="mongodb://".$this->_user.":".$this->_password."@".$this->_servidor;
		}else{
			$con=$this->_servidor;
		}
		$this->m = new Mongo($con); // connect
    	$db = $this->m->selectDB($this->_database);
    	
		return $db;
	}
	public function fDesconectaMongo(){
		$this->m->close();
	}
	public static function singleton() 
	{
		if( self::$instancia == null ) 
		{
			self::$instancia = new self();
		}
			return self::$instancia;
	}
	
	

	
	//Con set vamos guardando nuestras variables.
    public function set($name, $value){
    	//echo $name.$value;
    	$this->$name = $value;
  
    }
 
    //Con get('nombre_de_la_variable') recuperamos un valor.
    public function get($name)
    {
        if(isset($this->vars[$name]))
        {
            return $this->$name;
        }
    }

}
?>