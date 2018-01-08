<?php
setlocale(LC_ALL, 'zh_CN.utf-8');
require_once ('classes/image.class.php');

  	    
  	    $id = $_COOKIE["id"];

        
    	$targetFolder = 'imgFolder/'; // Relative to the root  
		if (!file_exists($targetFolder)) {
			 echo '目录不存在';
		     mkdir($targetFolder); 
		}
        if (!empty($_FILES)) {
        	//echo '<pre>';
        	//print_r($_FILES);
        	//die;
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $originalFileName2= $_FILES['Filedata']['name'];
            $originalFileName= iconv("utf-8","gbk",$_FILES['Filedata']['name']);
            $fileSize=$_FILES['Filedata']['size'];            
           
            $origalFile = $targetFolder.$_FILES['Filedata']['name'];
          
            //20141129
            $fileTypes = array('doc','ppt','xlsx','xls','jpg','png','gif','pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $originalFileName2=date("YmdHis").'.'.$fileParts['extension'];
          
            $originalFileName=date("YmdHis").'.'.$fileParts['extension'];
            $targetFile=$targetFolder.$originalFileName;
         
            if (in_array($fileParts['extension'],$fileTypes)) {
                //echo $tempFile;
                //echo '<br>';
                //echo $targetFile;
                //echo '<br>';
                move_uploaded_file($tempFile,$targetFile);              
                $result["success"] = 1;
                $result["originalFileName"] = $targetFile;               
                $result["FileName"] = $originalFileName;               
                $result["fileSize"] = $fileSize;
				$image = new imageclass();
                $image->updateImageName($id,$targetFile);
                $image->insertImageName($id,$targetFile);
            } else {
                $result["success"] = 1; 
                $result["reason"] = 'Invalid file type.';   
            }              
          
            $jsonresult= json_encode($result); 
            echo $jsonresult; 
        }
?>