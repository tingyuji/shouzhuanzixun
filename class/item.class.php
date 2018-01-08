<?php
require_once 'database_wcc.php';
setlocale(LC_ALL, 'zh_CN.utf-8');

class itemClass extends database_wcc {
	private $test_datasource = 'test_datasource';
	function __construct ($config=NULL){
		parent::__construct($this->test_datasource);
	}
	function getCount(){
		$sql = "select count(*) as number from item";
    	return $this->getTotalNumber($sql);
	}
	function getCount3($F07){
		$sql = "select count(*) as number from item where F07 = '$F07'";
    	return $this->getTotalNumber($sql);
	}	
	function getAll($offset,$rows){
		$sql = "select * from item order by F01 asc limit $offset,$rows";
		return $this->selectArray($sql);		
	}		
	function getAll2(){
		$sql = "select * from item where F06 = '审核中' order by F01 asc";
		return $this->selectArray($sql);		
	}	
	function getAll3($F07,$offset,$rows){
		$sql = "select * from item where F07 = '$F07' order by F01 asc limit $offset,$rows";
		return $this->selectArray($sql);		
	}			
	function add($F02,$F03,$F04,$F07){		
		$sql = "INSERT  INTO item(F02,F03,F04,F05,F07) Values('$F02','$F03','$F04',now(),'$F07')";
    	$this->update_sql($sql);
	}	
	function update($F01){		
		$sql = "update item set F06 = '执行中' where F01='$F01'";
		echo $sql;
		echo "\n";
    	$this->update_sql($sql);
	}	
	function update2($F01,$F03){		
		$sql = "update item set F03 = F03 + '$F03' where F01='$F01'";
		echo $sql;
		echo "\n";
    	$this->update_sql($sql);
	}		
	

}