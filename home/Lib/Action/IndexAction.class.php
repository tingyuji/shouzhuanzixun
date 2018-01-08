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
  public function reply(){
    $data = $this->_get();
    $keyword=$data['keyword'];  
    $this->assign('keyword',$keyword); 
    $this->display('reply');
  }   
  public function ugc(){
    $this->display('ugc');
  }   
  public function hello(){
    $this->display('hello');
  }   
  public function hello2(){
    $this->display('hello2');
  }     
  public function hello3(){
    $this->display('hello3');
  }       
  public function items(){
    $data = $this->_get();
    print_r($data);
    $data = $this->_post();
    print_r($data);  
    exit();  
    $category=$data['keyword'];
    $db = M('categoryTable');       
    $rows = $db->where(array('category'=>$category))->order("`id` DESC")->select();
    $this->assign('data',$rows[0]);    
    $this->display('items');
  }   
  public function item(){

    $data = $this->_get();
    $id=$data['id'];    

    $condition=array();
    $condition["id"] = array("EQ", $id);

    $db = M('material');  
    $item = $db->where($condition)->order("`id` DESC")->find();

    $this->assign('data',$item); 
    $this->display('item');
  }
  public function teldetail(){
    $data = $this->_get();
    $id=$data['id'];
    $db = M('sellerTable');       
    $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
    $this->assign('data',$rows[0]);       
    $this->display('teldetail'); 
  }   
  public function getAllData1(){
    $db = M('categoryTable');       
    $items = $db->order("`id` DESC")->select();
    $jsonresult= json_encode($items); 
    echo $jsonresult;  
  }     
  public function getAllData3(){
        $db = M('sellerTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  }   
  public function getTotal(){
        $db = M('sellerTable');       
        $total = $db->count();
        echo $total;
  }     
  public function getAllData4(){
        $db = M('advertTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  }                 
  public function getAllDataByCategory(){
    $data = $this->_post();
    $category=$data['category'];

    $db = M('categoryTable');
    $condition=array();
    $condition['category']=array('EQ',$category);
    $total = $db->where($condition)->count();    
    if($total==1){
      $item = $db->where($condition)->find();  
      $total=$item['total'];
      $data=array();
      $data['total']=$total+1;
      $db->where($condition)->save($data); 
    }    

    $db = M('sellerTable');       
    //20150106
    //按照id自增来排序，先录入的，排在最前边
    //$rows = $db->where(array('category'=>$category))->order("`id` ASC")->select();
    $condition=array();
    $condition['category']  = array('EQ',$category);
    $condition['status']  = array('EQ',1);
    //$rows = $db->where(array('category'=>$category))->order("`sortCode` DESC")->select();
    $rows = $db->where($condition)->order("`sortCode` DESC")->select();
    echo json_encode($rows);
  } 
  public function getAllDataByKeyword(){
    $data = $this->_post();
    $keyword=$data['keyword'];
    $db = M('sellerTable');       
    //$condition['seller']  = array('like',"%$keyword%");
    //$condition['keyword']  = array('like',"%$keyword%");
 
    $rows = $db->where("status=1 and seller like '%$keyword%' or keyword like '%$keyword%'  or telephone like '%$keyword%' or address like '%$keyword%'")->order("`sortCode` DESC")->select();
    //echo $db->getLastSql();
    echo json_encode($rows);
  }
  public function getAllImageData(){
        $data = $this->_get();
        $id=$data['id'];     
        $db = M('imageTable');       
        $rows = $db->where(array('foreignid'=>$id))->order("`id` DESC")->select();
        echo json_encode($rows);
  }   
  public function getAllData5(){
        $db = M('sellerTable'); 
        $data = $this->_post();
        $userName=$data['userName'];

        $condition=array();
        $condition['userName']=array('EQ',$userName);    
        $total = $db->where($condition)->order("`id` DESC")->count(); 
        $items = $db->where($condition)->order("`id` DESC")->select();
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }     
  public function getAllData6(){
        $db = M('userTable'); 
        $data = $this->_post();
        $username=$data['username'];

        $condition=array();
        $condition['username']=array('EQ',$username);    
        $total = $db->where($condition)->order("`id` DESC")->count(); 
        $items = $db->where($condition)->order("`id` DESC")->select();
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }       
  public function getAllData7(){
        $db = M('goodsTable');   
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
  public function correction(){
    $data = $this->_post();
    $userName=$data['userName'];
    $db = M('correctionTable');       
    $add_id = $db->add($data); 
    if($add_id){
      echo $add_id;
      $db = M('pointTable');
      $data=array();
      $data['point']='300';      
      $data['username']=$userName;  
      $data['content']='纠正了一条信息';
      $db->add($data);   

      $condition=array();
      $condition["username"] = array("EQ", $userName);
      $items = $db->where($condition)->order("`id` DESC")->select();
     
      $sum=0;
      foreach ($items as $item) {
        $point=intval($item['point']);
        $sum=$sum+$point;
      }
      
      $db = M('userTable'); 
      $data=array();
      $data['point']=$sum; 

      $condition=array();
      $condition["username"] = array("EQ", $userName); 
      $db->where($condition)->save($data);           
    } 
  } 
  public function search(){
    $data = $this->_post();
    $db = M('searchTable');       
    $add_id = $db->add($data); 
    if($add_id){
      echo $add_id;
    } 
  }   
  public function addData1(){
    $db = M('phoneTable');       
    $data = $this->_post();
    $phone=$data['phone'];
    $condition=array();
    $condition["phone"] = array("EQ", $phone);
    $condition["status"] = array("EQ", 1);
    $rows = $db->where($condition)->order("`id` DESC")->select();
    $total=count($rows);
    if($total==0){
     
      $add_id = $db->add($data); 
      //echo $db->getLastSql();
      if($add_id){
        echo $add_id;
      } 
    } 
  }
  public function addData2(){
    $data = $this->_post();
    $username=$data['userName'];

    $db = M('sellerTable');       
    $add_id = $db->add($data); 
    if($add_id){
      echo $add_id;      
      $db = M('pointTable');
      $data=array();
      $data['point']='50';      
      $data['username']=$username;  
      $data['content']='提交了一条信息';
      $add_id = $db->add($data); 


      $condition=array();
      $condition["username"] = array("EQ", $username);
      $items = $db->where($condition)->order("`id` DESC")->select();
     
      $sum=0;
      foreach ($items as $item) {
        $point=intval($item['point']);
        $sum=$sum+$point;
      }
      
      $db = M('userTable'); 
      $data=array();
      $data['point']=$sum; 

      $condition=array();
      $condition["username"] = array("EQ", $username); 
      $db->where($condition)->save($data); 

    } 
  }  
  public function addData3(){
    $data = $this->_post();
    $userName=$data['username'];
    $db = M('userTable');     

    $username=$data['username'];
    $condition=array();
    $condition['username']=array('EQ',$userName);
      
    $total = $db->where($condition)->order("`id` DESC")->count();
    if($total>0){
      echo '该账号已存在,请重新输入';
    }
    $add_id=0;
    if($total==0){
      $add_id=$db->add($data); 
      echo '注册成功';
    }    
    if($add_id){
      $db = M('pointTable');
      $data=array();
      $data['point']='10000';      
      $data['username']=$userName;  
      $data['content']='注册成功';
      $add_id = $db->add($data); 

      $condition=array();
      $condition["username"] = array("EQ", $userName);
      $items = $db->where($condition)->order("`id` DESC")->select();
      $sum=0;
      foreach ($items as $item) {
        $point=intval($item['point']);
        $sum=$sum+$point;
      } 
      $db = M('userTable'); 
      $data=array();
      $data['point']=$sum; 

      $condition=array();
      $condition["username"] = array("EQ", $userName); 
      $db->where($condition)->save($data); 

    } 
  }    
  public function addData4(){
    $data = $this->_post();
    $id=$data['id'];
    $userName=$data['userName'];
    $point=$data['point'];


    $db = M('pointTable');
    $data=array();
    $data['point']=$point*(-1);      
    $data['username']=$userName;  
    $data['content']='兑换奖品';
    $add_id = $db->add($data);   

    $condition=array();
    $condition["username"] = array("EQ", $userName);
    $items = $db->where($condition)->order("`id` DESC")->select();
   
    $sum=0;
    foreach ($items as $item) {
      $point=intval($item['point']);
      $sum=$sum+$point;
    }
    
    $db = M('userTable'); 
    $data=array();
    $data['point']=$sum; 

    $condition=array();
    $condition["username"] = array("EQ", $userName); 
    $db->where($condition)->save($data);       
     

    $condition=array();
    $condition["id"] = array("EQ", $id);

    $db = M('goodsTable');  
    $item = $db->where($condition)->order("`id` DESC")->find();
    echo $db->getLastSql();  

    $numbers=$item['numbers'];
    $data=array();
    $data['numbers']=$numbers-1;
    $db->where($condition)->save($data);

    //print_r($item);

/*
(
    [id] => 1
    [goods] => r44
    [imageName] => /upload/attached/image/20150405/20150405153428_50259.jpg
    [status] => 
    [CreateTime] => 
    [UpdateTime] => 2015-04-04 23:50:04
    [point] => 044
    [numbers] => 4
    [remarks] => 
)
*/

    $data=array();
    $data['goods']=$item['goods'];
    $data['point']=$item['point'];
    $data['imageName']=$item['imageName'];
    $data['numbers']=1;
    $data['userName']=$userName;

    $condition=array();
    $condition["username"] = array("EQ", $userName);

    $db = M('userTable');  
    $item = $db->where($condition)->order("`id` DESC")->find();  

    $data['address']=$item['address'];
    $data['telephone']=$item['telephone'];

    $db = M('itemTable');        
    $add_id = $db->add($data); 
    //echo $db->getLastSql(); 
    if($add_id){
      echo $add_id;
    } 
  }    
  public function checkus(){
        $data = $this->_post();  
        $username=$data['username'];
        $password=$data['password'];
        $db = M('userTable');       
        $rows = $db->where(array('username'=>$username,'password'=>$password))->order("`id` DESC")->select();
        echo json_encode($rows);
  }  
  public function checkData1(){
    $db = M('phoneTable');   
    $data = $this->_post();
    $phone=$data['phone'];
    $condition=array();
    $condition["phone"] = array("EQ", $phone);
    //$condition["status"] = array("EQ", 1);
    $rows = $db->where($condition)->order("`id` DESC")->select();
    echo json_encode($rows);
  }      
  public function updateData(){
        $db = M('userTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  } 
  public function updateData2(){
        $db = M('userTable');
        $data = $this->_post();  
        $username=$data['username'];

        $condition=array();
        $condition['username']=array('EQ',$username);   
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }   

}

