<?php
$F02 = isset($_POST['F02']) ? $_POST['F02'] : '';
$F03 = isset($_POST['F03']) ? $_POST['F03'] : '';
$verCode = isset($_POST['verCode']) ? $_POST['verCode'] : '';

session_start();
//将用户输入的验证码与服务端存储的验证码内容进行对比  
if(strtolower($verCode) == strtolower($_SESSION['verCode'])){  
    require_once 'class/t1.class.php';
	$t1Model=new t1Class();
	$total = $t1Model->getTotal2($F02,$F03);
	if($total){
		$_SESSION['foo'] = $F02;
		$url='http://xiaomutong.com.cn/weixinyuedu/index3.php';
		echo $url;
		header('Location:'.$url);
		exit(); 	
	}
	if($total==0){
		$url='http://xiaomutong.com.cn/weixinyuedu/note03.php';
		echo $url;
		header('Location:'.$url);
		exit(); 	
	}
}else{  
	$url='http://xiaomutong.com.cn/weixinyuedu/note02.php';
	echo $url;
	header('Location:'.$url);
	exit(); 
}    

