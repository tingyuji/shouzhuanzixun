<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>手赚资讯网</title>
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
      clear:both;
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
   .text-vertical-center {
      display: block;
      text-align: center;
      vertical-align: middle;
    }
    .text-vertical-center span{
      display: inline-block;
    }
  </style>
  </head>
  <body>
  <div class="header">
    <div class="topNav">
      <div class="left">
      <img style="height:45px;line-height: 45px;margin-top: 15px;" src="logo/1515402078_544189.png" />
      </div>
      <div class="right">
        <a href="#">登录</a>
        |
        <a href="#">论坛</a>
      </div>
    </div>
  </div>
  <div class="nav-wrap">
    <div class="nav" >
      <ul>
        <li>
          <a href="index.php">站点首页</a>
        </li>
        <li>
          <a href="__URL__/index1">精品推荐</a>
        </li> 
        <li>
          <a href="__URL__/index2">安卓有米</a>
        </li>          
        <li>
          <a href="__URL__/index3">苹果有米</a>
        </li>   
        <li>
          <a href="__URL__/index4">热门活动</a>
        </li>  
        <li>
          <a href="__URL__/index5">付费推广</a>
        </li>
        <li>
          <a href="__URL__/index6" class="active">联系客服</a>
        </li>                                                 
        <li>
          <a href="__URL__/index7">关于我们</a>
        </li>           
      </ul>
    </div>
  </div>
  <div id="foo">
  <div id="banner" style="text-align: center;">
    <a target="_blank" href="__URL__/item/id/3" target="_blank">
      <img src="https://segmentfault.com/img/bV9DfM" style="widht:640px;height:360px;" />
    </a>
  </div>
  <div class="separate" style="width:100%;height:45px;background-color:#ffe34a;">
  </div>    
  <p>推广咨询以及商务合作请联系客服专员，欢迎各位提出宝贵意见</p>
  <img class="img" src="http://img2.zxvp.org.cn/t/01/09/9384660287.png">
  </div>
  <div id="footer" style="text-align:center;vertical-align:middle;height:50px;line-height:50px;background-color:#F5F5F5;">
  手赚资讯网欢迎您
  </div>  
  </body>
</html>