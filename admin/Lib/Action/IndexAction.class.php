<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

  public function login(){
    $this->display('login');
  }   
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
  public function item1(){
    $this->display('item1');
  } 
  public function item2(){
    $this->display('item2');
  }
  public function item3(){
    $this->display('item3');
  }  
  public function item4(){
    $this->display('item4');
  }  
  public function item6(){
    $this->display('item6');
  }       
  public function view(){
        $data = $this->_get();
        $id=$data['id'];
        $this->assign('id',$id);
        $this->display('view');
  }                             
  public function update1(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('categoryTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update1');
  }       
  public function update2(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('youqingTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update2');
  }   
  public function update3(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('material');       
        $item = $db->where(array('id'=>$id))->order("`id` DESC")->find();
        $this->assign('data',$item);
        $this->display('update3');
  }    
    
  
  public function update4(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('advertTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update4');
  }   
  public function update6(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('correctionTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update6');
  }
  public function update7(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('newsTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update7');
  }               
  public function update8(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('adminTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update8');
  }    
  public function update12(){
        $data = $this->_get();
        $id=$data['id'];
        $db = M('goodsTable');       
        $rows = $db->where(array('id'=>$id))->order("`id` DESC")->select();
        $this->assign('data',$rows[0]);
        $this->display('update12');
  }                                          
  public function addData1(){
        $db = M('categoryTable');
        $data = $this->_post();
        $add_id = $db->add($data); 
        if($add_id){
        
        }            
  }
  public function addData2(){
        $db = M('youqingTable');
        $data = $this->_post();
        $add_id = $db->add($data); 
        if($add_id){
        
        }            
  }  
  public function addData3(){
        $db = M('material');
        $data = $this->_post();     
        $add_id = $db->add($data);      

        echo $db->getLastSql();
        if($add_id){

        }
  }  
 
  public function addData4(){
        $db = M('advertTable');
        $data = $this->_post();     
        $add_id = $db->add($data);      

        echo $db->getLastSql();
        if($add_id){

        }
  }
  public function addData6(){
        $db = M('correctionTable');
        $data = $this->_post();     
        $add_id = $db->add($data);      

        echo $db->getLastSql();
        if($add_id){

        }
  }  
  public function addData7(){
        $db = M('searchTable');
        $data = $this->_post();     
        $add_id = $db->add($data);      

        echo $db->getLastSql();
        if($add_id){

        }
  }  
  public function addData8(){
        $db = M('adminTable');
        $data = $this->_post();     
        $add_id = $db->add($data);      

        echo $db->getLastSql();
        if($add_id){

        }
  }   
  public function addData12(){
        $db = M('goodsTable');
        $data = $this->_post();
        $add_id = $db->add($data); 
        if($add_id){
        
        }            
  }
  public function addData13(){
        $db = M('itemTable');
        $data = $this->_post();
        $add_id = $db->add($data); 
        if($add_id){
        
        }            
  }    
  public function updateData1(){
        $db = M('categoryTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }
  public function updateData2(){
        $db = M('youqingTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }  
  public function updateData3(){
        $db = M('material');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }  
  public function updateFavorite(){
        $data = $this->_post();
        $id=$data['id'];
        $db = M('sellerTable');
        $data = $this->_post();  
        $id=$data['id'];  
        $condition=array();
        $condition['id']  = array('EQ',$id);
        $data=array();
        $data['sortCode']=999;
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }       
  public function updateFavorite2(){
        $data = $this->_post();
        $id=$data['id'];
        $db = M('sellerTable');
        $data = $this->_post();  
        $id=$data['id'];  
        $condition=array();
        $condition['id']  = array('EQ',$id);
        $data=array();
        $data['sortCode']=0;
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }             
  public function updateCertificate(){
        $data = $this->_post();
        $id=$data['id'];
        $db = M('sellerTable');
        $data = $this->_post();  
        $id=$data['id'];  
        $condition=array();
        $condition['id']  = array('EQ',$id);
        $data=array();
        $data['certificate']=1;
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }     
  public function updateCertificate2(){
        $data = $this->_post();
        $id=$data['id'];
        $db = M('sellerTable');
        $data = $this->_post();  
        $id=$data['id'];  
        $condition=array();
        $condition['id']  = array('EQ',$id);
        $data=array();
        $data['certificate']=0;
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }           
  public function updateStatus(){
        $data = $this->_post();
        $id=$data['id'];
        $db = M('sellerTable');
        $data = $this->_post();  
        $id=$data['id'];  
        $condition=array();
        $condition['id']  = array('EQ',$id);

        $item = $db->where(array('id'=>$id))->order("`id` DESC")->find();        
        $userName=$item['userName'];

        $data=array();
        $data['status']=1;
        $add_id = $db->where($condition)->save($data); 
        echo $db->getLastSql();
        if($add_id){
          $db = M('pointTable');
          $data=array();
          $data['point']='450';      
          $data['username']=$userName;  
          $data['content']='审核通过了一条信息';
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
         
  public function updateData4(){
        $db = M('advertTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  } 
  public function updateData6(){
        $db = M('correctionTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }   
  public function updateData7(){
        $db = M('newsTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  } 
  public function updateData8(){
        $db = M('adminTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }          
  public function updateData12(){
        $db = M('goodsTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }  
  public function updateImageData(){
        $db = M('goodsTable');
        $data = $this->_post();  
        $id=$data['id'];   
        $add_id = $db->where(array('id'=>$id))->save($data); 
        echo $db->getLastSql();
        if($add_id){

        }
  }    
  public function checkus(){
        $data = $this->_post();  
        $username=$data['username'];
        $password=$data['password'];
        $db = M('adminTable');       
        $rows = $db->where(array('username'=>$username,'password'=>$password))->order("`id` DESC")->select();
        //echo $db->getLastSql();
        echo json_encode($rows);
  }
  public function checkus2(){
        $data = $this->_post();  
        $username=$data['username'];
        $password=$data['password'];
        $db = M('xiaobianTable');       
        $rows = $db->where(array('username'=>$username,'password'=>$password))->order("`id` DESC")->select();
        //echo $db->getLastSql();
        echo json_encode($rows);
  }
  public function getAllData1(){
        $db = M('categoryTable');       
        $items = $db->order("`id` DESC")->select();
        $jsonresult= json_encode($items); 
        echo $jsonresult;  
  }    
  public function getdata1(){
        $data = $this->_post();
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows;
        $db = M('category');       
        $allitems = $db->order("`id` ASC")->select();
        // echo $db->getLastSql();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allitems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }
  public function getAllByKeyword(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('categoryTable');       
        $condition['category']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;      
  }
  public function getAllByType2(){
        $data = $this->_get(); 
        $type=$data['type']; 
        $db = M('youqingTable');       
        $rows = $db->where(array('type'=>$type))->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }  
  public function getAllByKeyword3(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('sellerTable');       
        $condition['seller']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;      
  }
  public function getAllByType4(){
        $data = $this->_get(); 
        $type=$data['type']; 
        $db = M('advertTable');       
        $rows = $db->where(array('type'=>$type))->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }   

  public function getAllByKeyword6(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('correctionTable');       
        $condition['seller']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  }               
  public function getAllByTitle7(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('searchTable');       
        $condition['item']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }              
  
        $jsonresult= json_encode($result); 
        echo $jsonresult;      
  }
  public function getAllByusername8(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('adminTable');       
        $condition['username']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;      
  }  
  public function getdata2(){
        $data = $this->_post();
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows;
        $db = M('tag');       
        $allitems = $db->order("`id` DESC")->select();
        // echo $db->getLastSql();
        $items = $db->order("`id` ASC")->limit($offset,$rows)->select();
        $total=count($allitems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;  
  } 
  public function getAllData2(){
        $db = M('youqingTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  } 
  public function getdata3(){
	      $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows; 
		
        $db = M('material');       
        $allItems = $db->order("`id` ASC")->select();
		    $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allItems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;   
  } 
  public function getAllData3(){
        $db = M('sellerTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  }   
  public function getdata4(){
        $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows;     
        $db = M('log');       
        $logs = $db->order("`id` ASC")->select();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($logs);
        $obj["total"] = $total;   
        $obj["rows"] = $items;   
        if($total==0){
          $obj["rows"] = array();   
        }        
        $json= json_encode($obj); 
        echo $json; 
  }      
  public function getAllData4(){
        $db = M('advertTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  }             
  public function getAllData5(){
      $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows; 
    
        $db = M('userTable');       
        $allItems = $db->order("`id` DESC")->select();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allItems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;
  }    
  public function getAllBykeyword5(){
        $data = $this->_get(); 
        $keyword=$data['keyword']; 
        $db = M('userTable');       
        $condition['username']  = array('like',"%$keyword%");
        $rows = $db->where($condition)->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;      
  }    
  public function getdata6(){
        $db = M('comment');       
        $rows = $db->order("`id` DESC")->select();
        $total=count($rows);
        $result["total"] = $total;   
        $result["rows"] = $rows;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;    
  }
  public function getAllData7(){
      $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows; 
    
        $db = M('searchTable');       
        $allItems = $db->order("`id` DESC")->select();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allItems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;   
  } 
  public function getdata8(){

        $db = M('adminTable');       
        $rows = $db->order("`id` DESC")->select();
        echo json_encode($rows);
  } 
  public function getAllImageData(){
        $data = $this->_get();
        $id=$data['id'];     
        $db = M('imageTable');       
        $rows = $db->where(array('foreignid'=>$id))->order("`id` DESC")->select();
        echo json_encode($rows);
  }          
  public function getAllData12(){
      $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows; 
    
        $db = M('goodsTable');       
        $allItems = $db->order("`id` DESC")->select();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allItems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;   
  }     
  public function getAllData13(){
      $data = $this->_post();       
        $page = $data['page'];
        $rows = $data['rows'];
        $offset = ($page-1)*$rows; 
    
        $db = M('itemTable');       
        $allItems = $db->order("`id` DESC")->select();
        $items = $db->order("`id` DESC")->limit($offset,$rows)->select();
        $total=count($allItems);
        $result["total"] = $total;   
        $result["rows"] = $items;   
        if($total==0){
          $result["rows"] = array();   
        }        
        $jsonresult= json_encode($result); 
        echo $jsonresult;   
  }         
  public function deleteData1(){
        $db = M('categoryTable');       
        $data = $this->_post();  
        $id=$data['id'];  
        
        
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
        
  }  
  public function deleteData2(){
        $db = M('youqingTable');       
        $data = $this->_post();  
        $id=$data['id'];  
        
        
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
        
  }  
  public function deleteData3(){
        $db = M('sellerTable');       
        $data = $this->_post();  
        $id=$data['id'];        
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
        
  }  
  public function deleteData4(){
        $db = M('advertTable');       
        $data = $this->_post();  
        $id=$data['id'];  
        
        
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
        
  }      
  public function deleteData5(){
        $db = M('userTable');       
        $data = $this->_post();  
        $id=$data['id'];
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
        
  }        
  public function deleteData6(){
        $db = M('correctionTable');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
  }       
  public function deleteData7(){
        $db = M('searchTable');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
  }
  public function deleteData8(){
        $db = M('username');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
  }    
  public function deleteImageData(){
        $db = M('imageTable');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();         
  }
  public function deleteData12(){
        $db = M('goodsTable');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
  }   
  public function deleteData13(){
        $db = M('itemTable');       
        $data = $this->_post();  
        $id=$data['id'];          
        $db->where(array('id'=>$id))->delete();
        echo $db->getLastSql();      
  }       
}