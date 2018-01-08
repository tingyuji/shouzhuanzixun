<?php if (!defined('THINK_PATH')) exit();?>﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/Public/js/jquery-1.7.2.min.js"></script>
<script type='text/javascript' src='/Public/js/easyui/jquery.easyui.min.js'></script>
<script type='text/javascript' src='/Public/js/easyui/locale/easyui-lang-zh_CN.js'></script>
<link rel='stylesheet' href='/Public/js/easyui/themes/default/easyui.css' type='text/css'>
<link rel='stylesheet' href='/Public/js/easyui/themes/icon.css' type='text/css'>

<script type="text/javascript" src="/Public/js/zDialog/zDrag.js"></script>
<script type="text/javascript" src="/Public/js/zDialog/zDialog.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="Public/js/bootstrap/css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="Public/js/bootstrap/css/bootstrap-theme.min.css">

<script type="text/javascript">
$(document).ready(function(){
  $('#b1').click(function(){
        $.ajax({
        url: '__URL__/addData6',
        type: 'post',
        data: {
            mingcheng: $('#mingcheng').val(),
            wangzhi: $('#wangzhi').val(),
            dianhua: $('#dianhua').val(),
            shouji: $('#shouji').val(),
            weixin: $('#weixin').val(),
            lianxiren: $('#lianxiren').val(),
            dizhi: $('#dizhi').val(),
            beizhu: $('#beizhu').val()          
        },
        async:false,
        dataType: "text",
        success: function(data){
              alert('添加成功');
              Dialog.close();    
              
           } 
        });
  });
});
</script>
</head>

<body style="width:350px;height:300px;margin:0 auto;padding:0;">
   <div style="margin:0 auto;">
        <div class="content">
            <table>
                <tbody>
                    <tr>
                        <td style="width:78px;"><span class="del-order">名称</span></td>
                        <td><input name="type" id="mingcheng" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>                       
                    </tr>                    
                    <tr>
                        <td style="width:78px;"><span class="del-order">网址</span></td>
                        <td><input name="type" id="wangzhi" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>                       
                    </tr>                    
                    <tr>
                        <td style="width:78px;"><span class="del-order">电话</span></td>
                        <td><input name="type" id="dianhua" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr> 
                    <tr>
                        <td style="width:78px;"><span class="del-order">手机</span></td>
                        <td><input name="type" id="shouji" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                     
                    <tr>
                        <td style="width:78px;"><span class="del-order">微信</span></td>
                        <td><input name="type" id="weixin" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                     
                    <tr>
                        <td style="width:78px;"><span class="del-order">联系人</span></td>
                        <td><input name="type" id="lianxiren" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                                                             
                    <tr>
                        <td style="width:78px;"><span class="del-order">地址</span></td>
                        <td><input name="type" id="dizhi" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                                                             
                    <tr>
                        <td style="width:78px;"><span class="del-order">备注</span></td>
                        <td><input name="type" id="beizhu" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                                                                                                     
                </tbody>
            </table>
        </div>
        <div style="padding-left:150px;padding-top:5px;">
            <button type="button" id="b1" class="btn btn-success">确定</button>
            <button type="button" id="b2" class="btn btn-warning">取消</button> 
        </div>
      </div>
</body>
</html>