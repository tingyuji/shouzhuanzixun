<?php
session_start();
if($_POST['code']!=$_SESSION['mobile_code'] or empty($_POST['code'])){
    echo '手机验证码输入错误!';
}else{
    $_SESSION['mobile'] = '';
    $_SESSION['mobile_code'] = '';  
    echo '验证成功,请继续';  
}
?>