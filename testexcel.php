<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/includes/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once 'libs/config.php'; //Archivo con configuraciones.
$system = System::singleton();

require_once dirname(__FILE__) . '/libs/apps/places/class.places.php';
$places = new Places();


echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("includes/template.xls");




echo date('H:i:s') , " Add new data to the template" , EOL;

$data = $places->previewReport(null,0);
echo "<pre>";
print_r($data['message'][0]);
echo "</pre>";

/*$data = array(array('cpro_dgc'		=> 'Excel for dummies',
					'price'		=> 17.99,
					'quantity'	=> 2
				   ),
			  array('title'		=> 'PHP for dummies',
					'price'		=> 15.99,
					'quantity'	=> 1
				   ),
			  array('title'		=> 'Inside OOP',
					'price'		=> 12.95,
					'quantity'	=> 1
				   )
			 );*/

//$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));

$baseRow = 7;
foreach($data['message'] as $r => $dataRow) {
	/*echo "<pre>";
print_r($dataRow);
echo "</pre>";*/
	$row = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['cpro_dgc'])
	                              ->setCellValue('C'.$row, $dataRow['cmun5_ine'])
	                              ->setCellValue('D'.$row, $dataRow['nmun_cc'])
	                              ->setCellValue('K'.$row, '0,0');
}
//$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);


echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$filename = str_replace('.php', '.xls', "test");
echo $filename."<br>";
$filename	= dirname(__FILE__).'/contenidos/xls/test.xls';
echo $filename;
$objWriter->save($filename);
echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;