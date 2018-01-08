<?php
return array(
    //'配置项' => '配置值'

	'URL_MODEL' => 3, 
    // 0 /appName/?m=module&a=action&id=1 
    // 1 PATHINFO  ttp://<serverName>/appName/m/module/a/action/id/1
    // 2 智能模式 系统默认 http://<serverName>/appName/module/action/id/1 http://<serverName>/appName/module,action,id,1(自定分隔符)
    // 3 http://<serverName>/appName/?s=/module/action/id/1/
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 's601705db0',
    'DB_USER' => 's601705db0',
    'DB_PWD' => 'a2ec6d7f',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 't_',
);
?>