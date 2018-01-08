<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
header("Content-Type:text/html;charset=utf-8");

session_start();
$foo = $_SESSION['foo'];

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10; 

$offset = ($page-1)*$rows;  

require_once 'class/item.class.php';


$itemClass= new itemClass();

$total=$itemClass->getCount3($foo);
$data["total"] = $total;  

$items = $itemClass->getAll3($foo,$offset,$rows);

$data["rows"] = $items;   
$json= json_encode($data); 
echo $json; 

?>