<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    #foo .img{
      width:320px;
      height:551px;
      border:1px solid #ff6965;
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
          <a href="index3.php">任务列表</a>
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
  <div id="foo">
  <p>您输入的校验码不对，请您重新核对。</p>
  </div>
  </body>
</html>