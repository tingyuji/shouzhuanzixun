<?php
require_once 'database_wcc.php';
setlocale(LC_ALL, 'zh_CN.utf-8');

class t1Class extends database_wcc {
	private $test_datasource = 'test_datasource';
	function __construct ($config=NULL){
		parent::__construct($this->test_datasource);
	}
	function getTotal2($F02,$F03){
		$sql = "select count(*) as number from t1 where F02 = '$F02' and F03='$F03' order by F01 asc";
		return $this->getTotalNumber($sql);		
	}	
	function add($F02,$F03){		
		$sql = "INSERT  INTO t1(F02,F03,F04) Values('$F02','$F03',now())";
    	$this->update_sql($sql);
	}	
	

}