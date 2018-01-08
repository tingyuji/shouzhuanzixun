<?php
$F01 = isset($_POST['F01']) ? $_POST['F01'] : '';
$F03 = isset($_POST['F03']) ? $_POST['F03'] : '100';
$F04 = isset($_POST['F04']) ? $_POST['F04'] : '0.04';

require_once 'class/item.class.php';
require_once 'class/t2.class.php';

$itClass=new itemClass();
$t2Class=new t2Class();
session_start();
$foo =  $_SESSION['foo'];
$itClass->update2($F01,$F03);
$t2Class->add($foo,'支出',$F03*0.04);

$url='http://www.xiaomutong.com.cn/weixinyuedu/index3.php';
header('Location:'.$url);
exit();

?>
