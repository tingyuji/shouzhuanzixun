<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>微信阅读平台</title>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/md5.min.js"></script>
    <script type='text/javascript' src='js/jquery-easyui-1.5.3/jquery.easyui.min.js'></script>
    <script type='text/javascript' src='js/jquery-easyui-1.5.3/locale/easyui-lang-zh_CN.js'></script>
    <link rel='stylesheet' href='js/jquery-easyui-1.5.3/themes/default/easyui.css' type='text/css'>
    <link rel='stylesheet' href='js/jquery-easyui-1.5.3/themes/icon.css' type='text/css'>    
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
    #foo{
      width:98%;
      margin: 0 auto;
    }
    #foo .btn{
      padding:5px 15px;
      border-radius:17px;
      background-color: #ff6965;
      color: #fff;
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
  <div id="foo">
      <div style="height:45px;line-height: 45px";vertical-align: middle;>
        <button type="button" id="btn1" class="btn">追加</button>
        <button type="button" id="btn2" class="btn">记录</button>
      </div> 

      <div style="margin:0;padding:0;">
        <table id="dg1"></table>
      </div>   
  </div>
  </body>
  <script type="text/javascript">
    $('#btn1').click(function(){
      var row = $('#dg1').datagrid('getSelected');
      if (row){
          window.location.href='index31.php?F01='+row.F01+'&keycode='+md5(row.F01);
      }
      if(!row){
         $.messager.alert('提示','请先选择一条记录!');
      }
    });
    $('#btn2').click(function(){
      var row = $('#dg1').datagrid('getSelected');
      if (row){
          window.location.href='index32.php?F01='+row.F01+'&keycode='+md5(row.F01);
      }
      if(!row){
         $.messager.alert('提示','请先选择一条记录!');
      }
    });    
    $(document).ready(function(){

          $('#dg1').datagrid({
    
              height: 450,
              idField:'id',
              singleSelect: true,
              pageNumber: 1,
              pageSize: 10,
              pagination: true,
              rownumbers: true,
              idField: 'id',
              url: 'getData03.php',             
              columns: [[
                  { field: 'ck', checkbox: true, hidden: false },
                  { field: 'F01', title: '序号', width: 100, hidden: false },
                  { field: 'F07', title: '账号', width: 100},
                  { field: 'F04', title: '价格', width: 100},
                  { field: 'F03', title: '数量', width: 100},
                  { field: 'F08', title: '完成', width: 100},
                  { field: 'F02', title: '链接', width: 450,
                    formatter: function (value, row, index) {
                        return "<a target='_blank' href="+value+">"+value+"</a>";                    
                        
                    }
                  },  
                  { field: 'F06', title: '状态', width: 150},
                  { field: 'F05', title: '创建时间',width:150}
              ]],
              onLoadSuccess:function(data){  

              }
          });
     
    });
  </script>  
</html>