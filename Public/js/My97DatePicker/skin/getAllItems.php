<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
header("Content-Type:text/html;charset=utf-8");

require_once 'class/counterClass.php';
$counterClass = new counterClass();
$total=$counterClass->getCount();
$total2=$counterClass->getCountByToday();
$total3=$counterClass->getCountByMonth();

//$row = mysql_fetch_row($rs);  
$result["total"] = $total;  
$result["total2"] = $total2;
$result["total3"] = $total3;
$items = $counterClass->getAllItems();
$result["rows"] = $items;   
$jsonresult= json_encode($result); 
echo $jsonresult; 
?>