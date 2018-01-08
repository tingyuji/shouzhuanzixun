<?php 
//商用后，APP_DEBUG 要改为false, 清空应用 runtime 目录下内容
define('APP_DEBUG', true); 

//定义项目名称和路径
define('APP_NAME', 'admin');
define('APP_PATH', './admin/');

// 加载框架入口文件
require( "./ThinkPHP/ThinkPHP.php");