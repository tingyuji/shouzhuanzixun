<?php
require_once 'database_wcc.php';
setlocale(LC_ALL, 'zh_CN.utf-8');

class tableclass extends database_wcc {
	private $test_datasource = 'test_datasource';
	function __construct ($config=NULL){
		parent::__construct($this->test_datasource);
	}
	function drop(){
		$sql = "DROP TABLE t_seller_table";
		echo $sql;
		echo '<br>';
    	$this->update_sql($sql);
	}
	function select(){
		$sql = "select * from t_seller_table";
		echo $sql;
		echo '<br>';
    	return $this->selectArray($sql);
	}
	function create(){
		$sql = "CREATE TABLE t_sellertest_table (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  seller varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  contacter varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  contact varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  telephone varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  category varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  remarks varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  point varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  status int(11) DEFAULT NULL,
				  CreateTime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				  UpdateTime timestamp NULL DEFAULT NULL,
				  PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
				";
				echo $sql;
				echo '<br>';
    	$this->update_sql($sql);

	}
	function create2(){
		$sql = "CREATE TABLE `t_user_table` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  `CreateTime` timestamp NULL DEFAULT NULL,
				  `UpdateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
				";
				echo $sql;
				echo '<br>';
    	$this->update_sql($sql);

	}	
	function create3(){
		$sql = "CREATE TABLE t_imagetest_table (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  foreignid int(11) DEFAULT NULL,
				  imageName varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				  status int(11) DEFAULT NULL,
				  CreateTime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				  UpdateTime timestamp NULL DEFAULT NULL,
				  PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
				";
				echo $sql;
				echo '<br>';
    	$this->update_sql($sql);

	}	

}