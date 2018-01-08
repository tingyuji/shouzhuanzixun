<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
header("Content-Type:text/html;charset=utf-8");

$F01 = isset($_POST['F01']) ? intval($_POST['F01']) : 1;  
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10; 

$offset = ($page-1)*$rows;  

require_once 'class/t3.class.php';


$t3Class= new t3Class();

$total=$t3Class->getCount2($F01);
$data["total"] = $total;  

$items = $t3Class->getAll2($F01,$offset,$rows);

$data["rows"] = $items;   
$json= json_encode($data); 
echo $json; 

?>