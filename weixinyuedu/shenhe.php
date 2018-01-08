<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
header("Content-Type:text/html;charset=utf-8");

require_once 'class/item.class.php';

$foo = new redis(); 
$foo->connect('127.0.0.1', 6379); 

$itemClass=new itemClass();

$items=$itemClass->getAll2();
echo '<pre>';
echo "\n";
print_r($items);

foreach ($items as $item) {
	$F01=$item['F01'];
	$F02=$item['F02'];
	$F03=$item['F03'];
	
	$itemClass->update($F01);

	$itemCode = str_pad($F01,5,'0',STR_PAD_LEFT);
	$foo->sAdd('ITEM', $itemCode);
	$foo->set($itemCode,$F02);
	for($i=1;$i<=$F03;$i++){
		$fooCode = str_pad($i,5,'0',STR_PAD_LEFT);
		$queue=date('Ymd').$itemCode.$fooCode;
		$foo->lPush('ITEM-'.$itemCode, $queue);
	}

}


echo '审核完成';
echo "\n";
