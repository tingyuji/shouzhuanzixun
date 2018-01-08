<?php
require_once 'database_wcc.php';
setlocale(LC_ALL, 'zh_CN.utf-8');

class t3Class extends database_wcc {
	private $test_datasource = 'test_datasource';
	function __construct ($config=NULL){
		parent::__construct($this->test_datasource);
	}
	function getCount2($F02){
		$sql = "select count(*) as number from t3 where F02 = '$F02' order by F01 asc";
		return $this->getTotalNumber($sql);		
	}	
	function getAll2($F02,$offset,$rows){
		$sql = "select * from t3 where F02 = '$F02' order by F01 asc limit $offset,$rows";
		return $this->selectArray($sql);		
	}	
	function add($F02,$F03){		
		$sql = "INSERT  INTO t3(F02,F03,F04) Values('$F02','$F03',now())";
    	$this->update_sql($sql);
	}	
	

}