<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);
ini_set('max_execution_time',3000);
ini_set('memory_limit', '4069M');
header("Content-Type:text/html;charset=utf-8");
setlocale(LC_ALL, 'zh_CN.utf-8');
date_default_timezone_set('Asia/Shanghai');
date_default_timezone_set('UTC');

require_once 'simplexlsx/simplexlsx.class.php';
require_once ('classes/image.class.php');
ob_start();
$xlsWholeName='20150213.xlsx';
$xlsWholeName='20150225.xlsx';
$xlsWholeName='20150423.xlsx';
$xlsWholeName='20150423-2.xlsx';
$xlsWholeName='20150423-3.xlsx';
$xlsWholeName = isset($_GET['xlsOriginalName']) ? $_GET['xlsOriginalName'] : '';

echo 'Name:'.$xlsWholeName;
echo '<br>';
$xlsx = new SimpleXLSX($xlsWholeName);
list($columnNum, $rowNum) = $xlsx->dimension();

// Load sheet data (take time ...)
$sheetData = $xlsx->rows();

$count = 0;

$image = new imageclass();
$items = array();
for ($i = 1; $i < $rowNum; $i++) {
	$row = $sheetData[$i];
	echo '<pre>';
	print_r($row);

	if(empty($row[0])){
		break;
	}	
	$item=array();
	$item['seller'] = isset($row[1]) ? $row[1] : '';
	$item['contacter'] = isset($row[2]) ? $row[2] : '';
	$item['address'] = isset($row[3]) ? $row[3] : '';
	$item['contact'] = isset($row[4]) ? $row[4] : '';
	$item['scope'] = isset($row[5]) ? $row[5] : '';

	$seller = isset($row[0]) ? $row[0] : '';
	$contacter = isset($row[1]) ? $row[1] : '';
	$address = isset($row[2]) ? $row[2] : '';
	$contact = isset($row[3]) ? $row[3] : '';
	$scope = isset($row[4]) ? $row[4] : '';


    $image->updateImageName4($seller,$contacter,$contact,$address,$scope);
}
?>
