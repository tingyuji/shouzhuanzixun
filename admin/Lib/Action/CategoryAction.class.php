<?php
// 本类由系统自动生成，仅供测试用途
class CategoryAction extends Action {

  public function getAllData(){

        $db = M('categoryTable');       
        $total = $db->order("`id` DESC")->count();
        $items = $db->order("`id` DESC")->select();
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }
 
}