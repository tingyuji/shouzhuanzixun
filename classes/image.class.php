<?php
require_once 'database_wcc.php';
setlocale(LC_ALL, 'zh_CN.utf-8');

class imageclass extends database_wcc {
	private $test_datasource = 'test_datasource';
	function __construct ($config=NULL){
		parent::__construct($this->test_datasource);
	}
	function updateImageName($id,$imageName){
		$sql = "UPDATE t_seller_table set imageName= '$imageName' where id='$id'";
		echo $sql;
		echo '<br>';
    	$this->update_sql($sql);
	}	
	function insertImageName($id,$imageName){
		$sql = "insert into t_image_table(foreignid,imageName) values($id,'$imageName')";
		echo $sql;
		echo '<br>';
    	$this->update_sql($sql);
	}		
	function updateImageName2($id,$imageName){
		$sql = "UPDATE t_advert_table set imageName= '$imageName' where id='$id'";
		echo $sql;
		echo '<br>';
    	var_dump($this->update_sql($sql));
	}
	function updateImageName3($Name){
		$sql = "insert into t_file_table(Name) values('$Name')";
		echo $sql;
		echo '<br>';
    	$this->update_sql($sql);
	}	
	function updateImageName4($seller,$contacter,$contact,$address,$scope){
		//$sql = "insert into t_seller_table(seller,contacter,contact,address,scope) values('$seller','$contacter','$contact','$address','$scope')";
		$sql = "insert into t_seller_table(seller,contacter,contact,telephone,address,scope,status) values('$seller','$contacter','$contact','$contact','$address','$scope','1')";
		echo $sql;
		echo '<br>';
    	$this->update_sql($sql);
	}					
}