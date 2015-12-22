<?php
/****************************************************
 * CLASS DB
 * 6/11/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
 * gestiona las conexiones a la base de datos
 * ejecuta las consultas
 
***************************************************/

class DB{
	
	private $_servidor;					//url del servidor de lectura
	private $_database;					//nombre de la bd de lectura
	private $_user;						//usuario de la bd de lectura
	private $_password;					//password de la bd de lectura
	
	private $_logger;					//objeto ErrorLogger
	
	private static $instancia = null;	 //instancia para controlar el singleton
	private static $pdo = null; 		// singleton de la conexion por PDO

	private $_conectado;
	function __construct(){
		$this->_logger=ErrorLogger::singleton();
		$this->_conectado=null;
		$system = System::singleton();
		
	}
	public function setDataBD($server,$database,$user,$pwd){
		$this->_servidor=$server;
		$this->_database=$database;
		$this->_user=$user;
		$this->_password=$pwd;
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


	/************************************************************************************
									Conexion por PDO
	*************************************************************************************/
	private static $_mode_pdo = null;	// estado del modo en curso de conexión a la DB
	const PDO_DB1 = 1;					// definir constantes por cada BD que se use y asignar número 
	const PDO_DB2 = 2;
	
	// Singleton de conexion por PDO
	public static function pdo($mode_pdo = self::PDO_DB1)
	{
		if ((self::$pdo == null) || (self::$_mode_pdo != $mode_pdo))
		{
			$system = System::singleton();
			if ($mode_pdo == self::PDO_DB1)
			{
				$host = $system->get('_servidor_bd1');
				$name = $system->get('_database_bd1');
				$user = $system->get('_user_bd1');
				$pwd = $system->get('_password_bd1');
			}
			elseif ($mode_pdo == self::PDO_DB2)
			{
				$host = $system->get('_servidor_bd2');
				$name = $system->get('_database_bd2');
				$user = $system->get('_user_bd2');
				$pwd = $system->get('_password_bd2');
			}else{
				$host = $system->get('_servidor_bd1');
				$name = $system->get('_database_bd1');
				$user = $system->get('_user_bd1');
				$pwd = $system->get('_password_bd1');
			}

			require_once 'class.pdo.php';
			$dbids = DB::_set_dbids();
			self::$pdo = new PDOdbp(PDO_MYSQL, $host, $name, $user, $pwd, $dbids);
		}

		self::$_mode_pdo = $mode_pdo;

		return self::$pdo;
	}


	// Declarar aqui las tablas y los ids de cada una
	private static function _set_dbids()
	{
		$dbids = new DBids();
		$dbids->add('PRUEBA', 'id');
		$dbids->add('LINKS', 'id');
		return ($dbids);
	}

	function get_mode_pdo()
	{
		return ($this->_mode_pdo);
	}
}
?>