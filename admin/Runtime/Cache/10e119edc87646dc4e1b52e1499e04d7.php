<?php if (!defined('THINK_PATH')) exit();?>﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/tel/Public/js/jquery-1.7.2.min.js"></script>
<script type='text/javascript' src='/tel/Public/js/easyui/jquery.easyui.min.js'></script>
<script type='text/javascript' src='/tel/Public/js/easyui/locale/easyui-lang-zh_CN.js'></script>
<link rel='stylesheet' href='/tel/Public/js/easyui/themes/default/easyui.css' type='text/css'>
<link rel='stylesheet' href='/tel/Public/js/easyui/themes/icon.css' type='text/css'>

<script type="text/javascript" src="/tel/Public/js/zDialog/zDrag.js"></script>
<script type="text/javascript" src="/tel/Public/js/zDialog/zDialog.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="tel/Public/js/bootstrap/css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="tel/Public/js/bootstrap/css/bootstrap-theme.min.css">
<script type="text/javascript">
$(document).ready(function(){
  $('#b1').click(function(){
        $.ajax({
        url: '__URL__/addData2',
        type: 'post',
        data: {
            type:$('#type option:selected').val(),
            duifangwangzhi: $('#duifangwangzhi').val(),
            duifangkey: $('#duifangkey').val(),
            qq: $('#qq').val(),
            dianhua: $('#dianhua').val(),
            lianxiren: $('#lianxiren').val(),
            zijiwangzhi: $('#zijiwangzhi').val(),
            zijikey: $('#zijikey').val(),
            jiaohuanshijian: $('#jiaohuanshijian').val(),
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
                        <td style="width:98px;"><span class="del-order">类型</span></td>
                        <td>
                        <select id="type" style="width:256px;height:25px;margin-top:5px;">
                          <option value="请选择">请选择</option>
                          <option value="已交换友链">已交换友链</option>
                          <option value="已删除友链">已删除友链</option>
                          <option value="储备友链">储备友链</option>
                        </select>
                        </td>                       
                    </tr>                           
                    <tr>
                        <td style="width:98px;"><span class="del-order">对方网址</span></td>
                        <td><input name="type" id="duifangwangzhi" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>                       
                    </tr>
                    <tr>
                        <td style="width:98px;"><span class="del-order">对方关键词</span></td>
                        <td><input name="type" id="duifangkey" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>                       
                    </tr>                    
                    <tr>
                        <td style="width:98px;"><span class="del-order">QQ</span></td>
                        <td><input name="type" id="qq" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr> 
                    <tr>
                        <td style="width:98px;"><span class="del-order">电话</span></td>
                        <td><input name="type" id="dianhua" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr> 
                    <tr>
                        <td style="width:98px;"><span class="del-order">联系人</span></td>
                        <td><input name="type" id="lianxiren" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                     
                    <tr>
                        <td style="width:98px;"><span class="del-order">自己网址</span></td>
                        <td><input name="type" id="zijiwangzhi" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                     
                    <tr>
                        <td style="width:98px;"><span class="del-order">自己关键词</span></td>
                        <td><input name="type" id="zijikey" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                                                             
                    <tr>
                        <td style="width:98px;"><span class="del-order">交换时间</span></td>
                        <td><input name="type" id="jiaohuanshijian" style="width:256px;height:25px;margin-top:5px;" type="text" value=""/></td>  
                    </tr>                                                             
                    <tr>
                        <td style="width:98px;"><span class="del-order">备注</span></td>
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