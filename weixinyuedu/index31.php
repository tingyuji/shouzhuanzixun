<?php
session_start();
$foo = $_SESSION['foo'];
if($foo){
  $message = '您当前余额是100';
}
if(!isset($foo)){
  $message = '您当前没有登陆|请先登陆再发布任务';
}

$F01 = $_GET['F01'];
$keycode = $_GET['keycode'];
if($keycode != md5($F01)){
  $url='http://www.xiaomutong.com.cn/weixinyuedu/note04.php';
  header('Location:'.$url);
  exit();
}

?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script type="text/javascript" src="js/purl.js"></script>
    <title>微信阅读平台</title>
    <style type="text/css">
    body{
      margin: 0;
      padding: 0;
      background-color: #fff;
      text-align: center;
    }
    .header{
      width:80%;
      height:75px;
      line-height:75px;
      text-align: center;
      margin: 0 auto;
    }
    .header .topNav .left{
      float: left;
      vertical-align: middle;
      color:#ff6965;
      font-size: 21px;
    }
    .header .topNav .right{
      float: right;
    }  
    .header .topNav .right a{
      text-decoration: none;
      color: #ff6965;
    }         
    .nav-wrap{
      width:100%;
      background-color: #ff6965;
      height: 45px;
      line-height: 45px;
    }
    .nav-wrap .nav ul{
      list-style: none;
      margin-top: 0px;
      margin-bottom: 0px;
    }
    .nav-wrap .nav ul li{
      list-style: none;
      display: inline-block;
      margin-left: -9px;
    }    
    .nav-wrap .nav ul li a{
      text-decoration: none;
      display: inline-block;
      padding:0 25px;
    } 
    .nav-wrap .nav ul li a{
      color:#fff;
      text-decoration: none;
      display: inline-block;
      padding:0 25px;
    }   
    .nav-wrap .nav ul li a.active{
      background-color: #ff402f;
    }     
    .nav-wrap .nav ul li a:hover{
      background-color: #ff402f;
    }  
    #foo .line input[type="submit"]{
      width: 150px;
      padding: 5px 10px;
    }    
    #foo .btn{
      padding:5px 15px;
      border-radius:17px;
      background-color: #ff6965;
      color: #fff;
    }
    #foo table{
      width: 75%;
    }
    #foo table tr{
      width:75%;
    }
    #foo table tr td:nth-child(1){
      width:100%;
      text-align: center;
    }

  </style>
  </head>
  <body>
  <div class="header">
    <div class="topNav">
      <div class="left">
      微信阅读平台
      </div>
      <div class="right">
        <a href="index9.php">登录</a>
        |
        <a href="#">论坛</a>
      </div>
    </div>
  </div>
  <div class="nav-wrap">
    <div class="nav" >
      <ul>
        <li>
          <a href="index1.php">站点首页</a>
        </li>
        <li>
          <a href="index2.php">发布任务</a>
        </li> 
        <li>
          <a href="index3.php" class="active">任务列表</a>
        </li>   
        <li>
          <a href="index4.php">在线充值</a>
        </li>  
        <li>
          <a href="index5.php">消费记录</a>
        </li>
        <li>
          <a href="index6.php">联系客服</a>
        </li>                                                 
        <li>
          <a href="index7.php">关于我们</a>
        </li>           
      </ul>
    </div>
  </div>
  <div>
    <p>任务追加单价4分一个阅读</p>
  </div>
  <div>
    <hr>
  </div>
  <div id="foo">
    <form action="form031.php" method="post">
      <input type="hidden" name="F01" value="<?php echo $F01?>">
      <table style="margin: 0 auto;">
        <tr>
        <td style="text-align: left;background-color: #ff6965;width:100%;height:35px;line-height: 35px;">
         请输入要追加的数量|追加数量必须是100的倍数|否则无效
        </td>
        </tr>
        <tr>
        <td style="width:100%;">
          <input type="text" name="F03" style="width:100%;height: 35px;line-height: 35px;margin:0px;">
        </td>
        </tr>
        <tr>
        <td style="text-align: left;background-color: #F5F5F5;width:100%;height:35px;">
        <?php echo $message ?>
        </td>
        </tr>
        <tr>
        <td>
          <input type="submit" name="" class="btn" value="提交" style="width:75px;">
        </td>
        </tr>
    </table>
    </form>
  </div>
  </body>
</html>