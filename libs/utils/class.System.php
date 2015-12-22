<?php
/****************************************************
 * CLASS Config
 * 19/11/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
 pone los datos de configuración del sitio
 incluye las clase comunes:
 - class.db.php acceso a la bd (BD)
 - class.errorLogger.php gestión de errores (errorLogger)
 - class.visor.php motor de plantillas
 - class.notificaciones.php para las notificaciones
 - class.fechas.php para formtear fechas
 - class.hat.php para el hat del front
 - class.mongodb.php
 
 La funcionalidad de esta clase es centralizar procesos. Todas las clases instancian a System, asi que esta recibe peticiones, las reenvia a la clase que corresponda y devuelve la respuesta a la clase que haya echo la solicitud.
 

***************************************************/
class System
{
    private $vars;
    private static $instance;
    public $_rutaEnlace;
    public $sesion;
 	
 	private $_queBD;
    
    private $_logger;	//objeto ErrorLogger
    private $_con;		//objeto BD
    private $_hat; 		//objeto hat
    private $_root;
    private $_mongo;
	public $ajax;
	
    	
    private function __construct()
    {
    
    	require_once 'class.pdo.php'; 				// acceso a la BD
    	require_once 'class.mongodb.php';			// acceso a mongo DB	
		require_once 'class.visor.php'; 			// Motor de plantillas
		require_once 'class.errorLogger.php'; 		// clase que controla los errores
		require_once 'class.fechas.php'; 			// clase fechas
		require_once 'class.hat.php'; 				// clase hat
		require_once 'class.shoe.php'; 				// clase shoe
		require_once 'class.RestRequest.php';		// clase para peticiones res

		$this->vars = array();            
        session_start();
		$this->sesion=$_SESSION;
		$this->_queBD="bd1";
		
		
       
    }
	//pongo el baseRef para la carga de css/img desde cualquier servidor
    //se define e config.php
	public function SetbaseRef($href){
		$this->_rutaEnlace=$href;
		$_SESSION['baseRef']=$href;
	}
	public function GetBaseRef(){
		return $this->_rutaEnlace;
	}
	public function fDameUrl(){
		return $this->_rutaEnlace;
   	}
	
	//devuelve el entorno (dev o prod) definido en el config  
   	public function getEnviroment(){
   		return $this->get('environment');
   	}

	//FUNCIÓN QUE MUESTRA LAS PLANTILLAS
	public function fShow($plantilla,$data){
	
	 try{
	        if(!class_exists('Visor')) {
	            throw new Exception("clase Visor no existe");
	        }else{
				$this->sesion=$_SESSION;
	        	$this->visor=new Visor();
	      		$this->visor->fShow($plantilla,$data);
	      	}
	    }catch (Exception $e) {
			$this->imprError($e->getMessage());
	    }
	
	}
	
	
	//FUNCIONES DE MANEJO DE ERRORES
    public function imprError($err){
    	try{
	        if(!class_exists('ErrorLogger')) {
	            throw new Exception("clase ErrorLogger no existe");
	        }else{
	        	$this->_logger=ErrorLogger::singleton();
	        	if($err==""){
	        		throw new Exception("Error está vacio");
	        	}else{
	      			$this->_logger->imprError($err);
	        	}
	      	}
	    }catch (Exception $e) {
	    	switch ($e->getMessage()) {
            	case "clase ErrorLogger no existe":
            		//no hagas nada, no hay handler de errores
               	//	echo "no hay clase";
             		break;
             	case "Error está vacio":
            	//no hagas nada, no hay handler error
               $this->_logger->imprError("Error está vacio");
               break;   
	    	}
			
	    }
    }
        
   	//VARIABLES QUE VIENEN DE config.php
    //Con set vamos guardando nuestras variables.
    public function set($name, $value)
    {
        if(!isset($this->vars[$name]))
        {
            $this->vars[$name] = $value;
        }
    }
 
    //Con get('nombre_de_la_variable') recuperamos un valor.
    public function get($name)
    {
        if(isset($this->vars[$name]))
        {
        	return $this->vars[$name];
        }
    }
 
    //limpieza de html en contenidos para evitar inyección de código
	public function f_parse_html($str_input) {
 	 	if (!is_string($str_input)) {
    		return false;
 		}else{
    		$str_output = trim($str_input);
    		$str_output = str_replace(chr(34), "&#34;", $str_output); 		// Comilla doble
    		$str_output = str_replace(chr(13), "<br>", $str_output);		// Salto de línea
	 		$str_output = str_replace("&lt;i&gt;", "<i>", $str_output);		// <i>
	 		$str_output = str_replace("&lt;/i&gt;", "</i>", $str_output);	// </i>
	 		$str_output = str_replace("&lt;b&gt;", "<b>", $str_output);		// <b>
	 		$str_output = str_replace("&lt;/b&gt;", "</b>", $str_output);	//</b>
    		return $str_output;
  		}
	}

	//limpieza de variables que viene por GET para evitar ' \ '
	public function sanitize_get($var){
		$retorno 	= 	strip_tags(stripslashes($var));
		$retorno	= 	str_replace("'", "", $retorno);
		return $retorno;
	}


	public function obj2ArrRecursivo($obj) {
		if (is_object($obj)){
			$obj = get_object_vars($obj);
		}
		if (is_array($obj)){
			foreach ($obj as $key => $value){
				$obj[$key] = $this->obj2ArrRecursivo($obj[$key]);
			}
		}
		return $obj;
	}
	/************************************************************************************
									MONGO
	*************************************************************************************/
	public function fConectaMongo($server=null){
		$this->_mongo 	= MongoDB_invertred::singleton();
		/*múltiple hosts mongo
		en el config se pueden poner todos los host mongo que queramos, con la siguiente nomenclatura
			_servidorMongoNUM
			_bdMongoNUM
			_usMomgoNUM
			_passwMongNUM
		
		Ejemplo:
			$config->set('_servidorMongo1','url');				
			$config->set('_bdMongo1','nv');										
			$config->set('_usMongo1','adgrup');									
			$config->set('_passwMongo1','4ng3l43');
		*/
		if(!$server){
			$server=1;
		}
		
		$h				= "_servidorMongo".$server;
		$b				= "_bdMongo".$server;
		$u				= "_usMongo".$server;
		$p				= "_passwMongo".$server;
		$host			= $this->get($h);
		$bd				= $this->get($b);
		$us				= $this->get($u);
		$pw				= $this->get($p);

		
		$this->_mongo->setDataBD($host,$bd,$us,$pw);
		$driver=$this->_mongo->fConecta();
		return $driver;
	}
	public function fDesconectaMongo(){
		$this->_mongo->fDesconectaMongo();
	}
	
	
	public function fDameId($col){	
		return $this->_mongo->fDameId($col);
	}
	/************************************************************************************
									FIN MONGO
	*************************************************************************************/
	
	/************************************************************************************
									DB con PDO
	*************************************************************************************/
	
	//Inicio  registro bd del proyecto
	
	/*
	Definir cuantas bases de datos se usan:
	
	bd1-> base de datos 1 
	bd2-> base de datos 2
	*/
	
	public function getBD(){
		if($this->_queBD=="bd1"){
			return 1;
		}elseif($this->_queBD=="bd2"){
			return 2;
		}
	}
	
	private function _setBD($cual){
		if($cual=="bd1"){
			$this->_queBD="bd1";
		}elseif($cual=="bd2"){
			$this->_queBD="bd2";
		}else{
			$this->_queBD="bd1";
		}

	}
	
	//Fin registro bd del proyecto
	
	function pdo($queDB)
	{
		$this->_setBD($queDB);
		return DB::pdo(DB::$this->getBD());
	}
	function pdo_select($queDB,$sql, $npage=null, $nrow=null)
	{
		$this->_setBD($queDB);
		$db = DB::pdo(DB::$this->getBD());
		$db->prepare_select($sql);
		$rs = $db->select();
		return ($rs);
	}

	function pdo_insert($queDB,$table, $fields, $values)
	{
		$this->_setBD($queDB);
		$db = DB::pdo(DB::$this->getBD());
		$db->prepare_insert($table, $fields);
		$last_id = $db->insert($values);
		return ($last_id);
	}

	function pdo_update($queDB,$table, $fields, $values, $id=null, $where=null)
	{
		$this->_setBD($queDB);
		$db = DB::pdo(DB::$this->getBD());
		$db->prepare_update($table, $fields, $id, $where);
		$db->update($values);
	}

	function pdo_delete($queDB,$table, $ids=null, $where=null)
	{
		$this->_setBD($queDB);
		$db = DB::pdo(DB::$this->getBD());
		$db->prepare_delete($table, $ids, $where);
		$db->delete();
	}

	function pdo_count()
	{
		
		$db = DB::pdo(DB::$this->getBD());
		return ($db->count);
	}


	
	/************************************************************************************
									System Singleton
	*************************************************************************************/
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
 
        return self::$instance;
    }

	
}

?>