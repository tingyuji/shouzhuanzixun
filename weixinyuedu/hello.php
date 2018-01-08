<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
header("Content-Type:text/html;charset=utf-8");

echo 'hello';

$foo = new redis(); 
$foo->connect('127.0.0.1', 6379); 
