<?php
$F02 = isset($_POST['F02']) ? $_POST['F02'] : '';
$F03 = isset($_POST['F03']) ? $_POST['F03'] : '';
$verCode = isset($_POST['verCode']) ? $_POST['verCode'] : '';

$len = strlen($F02);
if($len!=11){
	$url='http://xiaomutong.com.cn/weixinyuedu/note01.php';
	echo $url;
	header('Location:'.$url);
	exit(); 	
}

session_start();  
//将用户输入的验证码与服务端存储的验证码内容进行对比  
if(strtolower($verCode) == strtolower($_SESSION['verCode'])){  
    require_once 'class/t1.class.php';
	$t1Model=new t1Class();
	$t1Model->add($F02,$F03);

	$url='http://xiaomutong.com.cn/weixinyuedu/index9.php';
	echo $url;
	header('Location:'.$url);
	exit(); 
}else{  
	$url='http://xiaomutong.com.cn/weixinyuedu/note02.php';
	echo $url;
	header('Location:'.$url);
	exit(); 
}    

