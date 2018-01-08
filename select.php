<?php
header("Content-Type:text/html;charset=utf-8");
setlocale(LC_ALL, 'zh_CN.utf-8');

require_once 'classes/table.class.php';

$tableclass = new tableclass();
$items = $tableclass->select();
echo '<pre>';
print_r($items);
echo '成功';