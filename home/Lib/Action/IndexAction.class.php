<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

  public function index(){
    $this->display('index');
  } 
  public function index1(){
    $this->display('index1');
  }
  public function index2(){
    $this->display('index2');
  }
  public function index3(){
    $this->display('index3');
  }
  public function index4(){
    $this->display('index4');
  }
  public function index5(){
    $this->display('index5');
  }           
  public function index6(){
    $this->display('index6');
  }           
  public function index7(){
    $this->display('index7');
  }                 
  public function items(){
    $this->display('items');
  } 
  public function item(){

    $data = $this->_get();
    $id=$data['id'];    

    $condition=array();
    $condition["id"] = array("EQ", $id);

    $db = M('material');  
    $item = $db->where($condition)->order("`id` DESC")->find();

    $db = M('log');       
    $logdata = array();
    $logdata['itemid'] = $id;
    $logdata['itemtitle'] = $item['title'];
    $logdata['createTime']=date("Y-m-d H:i:s");
    $add_id = $db->add($logdata); 

    $db = M('comment'); 
    $condition=array();
    $condition["itemid"] = array("EQ", $id);    
    $comments = $db->where($condition)->order("`id` DESC")->select();

    $item['comments'] = $comments;

    $this->assign('data',$item); 
    $this->display('item');
  }
  public function addData(){
    $data = $this->_post();

    $db = M('comment'); 
    $data['createTime']=date("Y-m-d H:i:s");    
    $add_id = $db->add($data); 
  }  
  

}

