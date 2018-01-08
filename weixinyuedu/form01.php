<?php

$F02 = isset($_POST['F02']) ? $_POST['F02'] : '';
$F03 = isset($_POST['F03']) ? $_POST['F03'] : '';
$F04 = isset($_POST['F04']) ? $_POST['F04'] : '';

require_once 'class/item.class.php';
$itemClass=new itemClass();

$itemClass->add($F2,$F03,$F04);

// $data=array();
// $data['status']=1;
// $data['msg']='提交成功';
// $data['url']='index2.php';

// $json=json_encode($data);
// echo $json;

$url='http://www.xiaomutong.com.cn/weixinyuedu/index3.html';
header('Location:'.$url);
exit();

?>
