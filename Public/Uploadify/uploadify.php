<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
//$targetFolder = 'uploads/'; // Relative to the root
$targetFolder = '/uploads'; // Relative to the root


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'];
	//C:/Zend/Apache2/htdocs
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] .'/phpUpload2'. $targetFolder;
	$targetFile = $targetPath. '/' . $_FILES['Filedata']['name'];
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	//C:/Zend/Apache2/htdocs/uploads
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>