<?php
	require_once 'libs/config.php'; //Archivo con configuraciones.
	$system = System::singleton();
	$filename = $system->get('basedirContenidos')."csv/".$_GET['fileName']; // of course find the exact filename....        
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private', false); // required for certain browsers 


	header('Content-Disposition: attachment; filename="'. basename($_GET['fileName']) . '";');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($filename));

	readfile($filename);
	exit;
?>