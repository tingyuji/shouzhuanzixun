<?php

/**
// 配置文件增加设置
// MY_AUTH_ON 是否需要认证
// MY_AUTH_TYPE 认证类型 1登录验证，2即时验证
// MY_AUTH_KEY 认证识别号 session键值
// MY_ADMIN_AUTH_KEY 超级管理员 session键值
// MY_REQUIRE_AUTH_MODULE  需要认证模块，逗号做间隔
// MY_NOT_AUTH_MODULE 无需认证模块
// MY_REQUIRE_AUTH_ACTION 需要认证的action
// MY_NOT_AUTH_ACTION 无需要认证的action
// MY_RBAC_ROLE_TABLE 角色表名称
// MY_RBAC_USER_TABLE 用户表名称
// MY_RBAC_ACCESS_TABLE 权限表名称
// MY_RBAC_NODE_TABLE 节点表名称

// MY_RBAC_DB_DSN  数据库连接DSN
/*
-- --------------------------------------------------------
--   `level` tinyint(1) NOT NULL,
--   `module` varchar(50) DEFAULT NULL,
CREATE TABLE IF NOT EXISTS `my_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- #扩展 isexp 是否为正则，针对模块级别用
CREATE TABLE IF NOT EXISTS `my_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `isexp` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `my_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `my_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
class MyRBAC {

    //用于检测用户权限的方法,并保存到Session中
    static function saveAccessList($authId=null) {
        if(null===$authId)   $authId = $_SESSION[C('MY_AUTH_KEY')];
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if(C('MY_AUTH_TYPE') !=2 && !$_SESSION[C('MY_ADMIN_AUTH_KEY')] )
            $_SESSION['_ACCESS_LIST']	=	MyRBAC::getAccessList($authId);
        return ;
    }

    //检查当前操作是否需要认证
    static function checkAccess($module=MODULE_NAME, $action=ACTION_NAME) {
        //如果项目要求认证，并且当前模块需要认证，则进行权限认证
        if( C('MY_AUTH_ON') ){
			$_module	=	array();
			$_action	=	array();
            if("" != C('MY_REQUIRE_AUTH_MODULE')) {
                //需要认证的模块
                $_module['yes'] = explode(',', str_replace(' ', '', strtoupper(C('MY_REQUIRE_AUTH_MODULE'))));
            }else {
                //无需认证的模块
                $_module['no'] = explode(',', str_replace(' ', '', strtoupper(C('MY_NOT_AUTH_MODULE'))));
            }
            //检查当前模块是否需要认证
            if((!empty($_module['no']) && !in_array(strtoupper($module),$_module['no'])) || (!empty($_module['yes']) && in_array(strtoupper($module),$_module['yes']))) {
				if("" != C('MY_REQUIRE_AUTH_ACTION')) {
					//需要认证的操作
					$_action['yes'] = explode(',', str_replace(' ', '', strtoupper(C('MY_REQUIRE_AUTH_ACTION'))));
				}else {
					//无需认证的操作
					$_action['no'] = explode(',', str_replace(' ', '', strtoupper(C('MY_NOT_AUTH_ACTION'))));
				}
				//检查当前操作是否需要认证
				if((!empty($_action['no']) && !in_array(strtoupper($action),$_action['no'])) || (!empty($_action['yes']) && in_array(strtoupper($action),$_action['yes']))) {
					return true;
				}else {
					return false;
				}
            }else {
                return false;
            }
        }
        return false;
    }


    //权限认证的过滤器方法
    static public function AccessDecision($appName=APP_NAME, $pm='', $pa='') {
        $appName = $appName? $appName : APP_NAME;
        $urls = explode('/', $pm);
        $module = $pm? $urls[0] : (defined('P_MODULE_NAME')?  P_MODULE_NAME   :   MODULE_NAME);
        $action = $pa? $pa : $urls[1]? $urls[1] : ACTION_NAME;
        //检查是否需要认证
        if(MyRBAC::checkAccess($module, $action)) {
            //存在认证识别号，则进行进一步的访问决策
            $accessGuid   =   md5($appName.$module.$action);
            if(empty($_SESSION[C('MY_ADMIN_AUTH_KEY')])) {
                if(C('MY_AUTH_TYPE')==2) {
                    //加强验证和即时验证模式 更加安全 后台权限修改可以即时生效
                    //通过数据库进行访问检查
                    $accessList = MyRBAC::getAccessList($_SESSION[C('MY_AUTH_KEY')]);
                }else {
                    // 如果是管理员或者当前操作已经认证过，无需再次认证
                    if( $_SESSION[$accessGuid]) {
                        return true;
                    }
                    //登录验证模式，比较登录后保存的权限访问列表
                    $accessList = $_SESSION['_ACCESS_LIST'];
                }
                
                if(!isset($accessList[strtoupper($appName)][strtoupper($module)][strtoupper($action)])) {
                    $module_url = $pm? $pm . ($pa? '/' . $pa : '') : $module . '/' . $action;
                    //echo $module_url.'111';exit;
                    //使用正则模式检查
                    foreach($accessList[strtoupper($appName)]['__EXP__'] as $expstr){
                        $exps = explode(',', $expstr);
                        foreach($exps as $exp){
                            if(preg_match("/". str_replace('/', '\\/', trim($exp)) . "/i", $module_url)){
                                //return 123;
                                return true;
                            }
                        }
                    }
                    
                    //$_SESSION[$accessGuid]  =   false;
                    //return 124;
                    return false;
                }
                else {
                    //$_SESSION[$accessGuid]	=	true;
                    //return 125;
                    return true;
                }
            }else{
                //管理员无需认证
				//return 126;
                return true;
			}
        }
        //return 127;
        return true;
    }

    /**
     +----------------------------------------------------------
     * 取得当前认证号的所有权限列表
     +----------------------------------------------------------
     * @param integer $authId 用户ID
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    static public function getAccessList($authId) {
        // Db方式权限数据
        $db     =   Db::getInstance(C('MY_RBAC_DB_DSN'));
        $table = array('role'=>C('MY_RBAC_ROLE_TABLE'),'user'=>C('MY_RBAC_USER_TABLE'),'access'=>C('MY_RBAC_ACCESS_TABLE'),'node'=>C('MY_RBAC_NODE_TABLE'));
        $sql    =   "select node.id,node.name from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access ,".
                    $table['node']." as node ".
                    "where user.user_id='{$authId}' and user.role_id=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and access.node_id=node.id and node.level=1 and node.status=1";
        $apps =   $db->query($sql);
        $access =  array();
        $exp_access = array();
        foreach($apps as $key=>$app) {
            $appId	=	$app['id'];
            $appName	 =	 $app['name'];
            // 读取项目的模块权限
            $access[strtoupper($appName)]   =  array();
            $sql    =   "select node.id,node.name,node.isexp from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access ,".
                    $table['node']." as node ".
                    "where user.user_id='{$authId}' and user.role_id=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and access.node_id=node.id and node.level=2 and node.pid={$appId} and node.status=1";
            $modules =   $db->query($sql);
            //echo $db->getLastSql();exit;
            // 判断是否存在公共模块的权限
            $publicAction  = array();
            foreach($modules as $key=>$module) {
                $moduleId	 =	 $module['id'];
                $moduleName = $module['name'];
                if('PUBLIC'== strtoupper($moduleName)) {
                $sql    =   "select node.id,node.name from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access ,".
                    $table['node']." as node ".
                    "where user.user_id='{$authId}' and user.role_id=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and access.node_id=node.id and node.level=3 and node.pid={$moduleId} and node.status=1";
                    $rs =   $db->query($sql);
                    foreach ($rs as $a){
                        $publicAction[$a['name']]	 =	 $a['id'];
                    }
                    unset($modules[$key]);
                    break;
                }else if($module['isexp']){//是正则模块的，单独出来
                    unset($modules[$key]);
                    $exp_access[] =	$moduleName;
                }
            }
            // 依次读取模块的操作权限
            foreach($modules as $key=>$module) {
                $moduleId	 =	 $module['id'];
                $moduleName = $module['name'];
                $sql    =   "select node.id,node.name from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access ,".
                    $table['node']." as node ".
                    "where user.user_id='{$authId}' and user.role_id=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and access.node_id=node.id and node.level=3 and node.pid={$moduleId} and node.status=1";
                $rs =   $db->query($sql);
                $action = array();
                foreach ($rs as $a){
                    $action[$a['name']]	 =	 $a['id'];
                }
                // 和公共模块的操作权限合并
                $action += $publicAction;
                $access[strtoupper($appName)][strtoupper($moduleName)]   =  array_change_key_case($action,CASE_UPPER);
            }
            $access[strtoupper($appName)]['__EXP__'] = $exp_access;
        }
        //print_r($access);exit;
        return $access;
    }

}