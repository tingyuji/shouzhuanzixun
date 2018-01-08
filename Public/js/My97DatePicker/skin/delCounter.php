<?php
header("Content-Type:text/html;charset=utf-8");
setlocale(LC_ALL, 'zh_CN.utf-8');

require_once 'class/productClass.php';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$productClass = new productClass();
$productClass->delete($id);
echo '删除成功';