<?php
/****************************************************
 * CLASS Visor
 * 19/11/2009 Leandro Lopez Guerrero (leandro.lopez@3data.net)
  
	muestra la plantilla
 
***************************************************/
class Visor{
	private $_system;	
	function __construct(){
		$this->_system = System::singleton();
	}
 	public function fShow($name, $vars = array()){
		//$name es el nombre de nuestra plantilla, por ej, listado.php
		//$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.
		//Traemos una instancia de nuestra clase de configuracion.
		//Armamos la ruta a la plantilla
		$path = $this->_system->get('carpetaTpl') . $name;
		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false){
			$this->_system->imprError(trigger_error ('Template `' . $path . '` no existe.', E_USER_NOTICE));
			return false;
		}
 
		//Si hay variables para asignar, las pasamos una a una.
		if(is_array($vars)){
                    foreach ($vars as $key => $value) {
                		$$key = $value;//ojo $$ es variable variable
                    }
                }
 
		//Finalmente, incluimos la plantilla.
		include($path);
	}
}
/*
 USO:
 $vista = new View();
 $vista->show('listado.php', array("nombre" => "Juan"));
*/
?>