<?php
header("Content-Type:text/html;charset=utf-8");
setlocale(LC_ALL, 'zh_CN.utf-8');

require_once 'classes/table.class.php';

$tableclass = new tableclass();
$tableclass->create3();
echo '添加成功';