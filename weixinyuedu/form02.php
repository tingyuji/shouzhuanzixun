<?php

$F02 = isset($_POST['F02']) ? $_POST['F02'] : '';
$F03 = isset($_POST['F03']) ? $_POST['F03'] : '100';
$F04 = isset($_POST['F04']) ? $_POST['F04'] : '0.04';

require_once 'class/item.class.php';
require_once 'class/t2.class.php';

$itClass=new itemClass();
$t2Class=new t2Class();
session_start();
$foo =  $_SESSION['foo'];
$itClass->add($F02,$F03,$F04,$foo);
$t2Class->add($foo,'支出',4);
// $data=array();
// $data['status']=1;
// $data['msg']='提交成功';
// $data['url']='index2.php';

// $json=json_encode($data);
// echo $json;

$url='http://www.xiaomutong.com.cn/weixinyuedu/index3.php';
header('Location:'.$url);
exit();

?>
