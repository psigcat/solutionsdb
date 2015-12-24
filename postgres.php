<?php

class ControllerIndex{
	private $_system;
	private $_hat;
	private $_shoe;
	private $_modulo;
	function __construct()
	{

		$host		= "localhost";
		$name		= "test";
		$user		= "llopez";
		$pwd		= "";
		require_once 'libs/config.php'; //Archivo con configuraciones.
	  	$this->_system = System::singleton();//contiene objeto system

	  	$dbconn = pg_connect("host=localhost dbname=test user=llopez password=")
	  	or die('No se ha podido conectar: ' . pg_last_error());
	  	
	  	
	  	//perform the insert using pg_query
	  	/*$result = pg_query($dbconn, "INSERT INTO testtable(name) 
                  VALUES('pedo');");*/
        $result = pg_query($dbconn, "SELECT * FROM testtable");

		//dump the result object
		var_dump($result);

		 

		// Closing connection
		pg_close($dbconn);
		
		
		
		echo "<br>PDO<br>";
		$pdo = new PDOdbp(PDO_PGSQL, $host, $name, $user, $pwd, $dbids);
		echo "<br>Insert:<br>";
	
		$pdo->prepare_insert("testtable", "id,name");
		$last_id = $pdo->insert(array(2,"algo"));
		echo "lastId: ".$last_id."<br>";
		
		echo "<br>Update:<br>";
		
		$pdo->prepare_update("testtable", "name",null,"id=1");
		$pdo->update(array('ogtro', 2));

		
		echo "<br>Select:<br>";
		$query	= "SELECT * FROM testtable";
		$select	= $pdo->prepare_select($query);
		$rs = $pdo->select();
		var_dump($rs);
		
		echo "<br><br>Select con bind:<br>";
		$query = "SELECT * FROM testtable WHERE id= :v1";

		$pdo->prepare_select($query);
		$pdo->bind(":v1", 2);
		$rs = $pdo->select();
		var_dump($rs);
		
		
		
	}
 
	
}
		
new ControllerIndex();

?>