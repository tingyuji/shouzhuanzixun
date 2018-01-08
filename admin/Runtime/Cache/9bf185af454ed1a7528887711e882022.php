<?php if (!defined('THINK_PATH')) exit();?>﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/Public/js/jquery-1.7.2.min.js"></script>
<script type='text/javascript' src='/Public/js/easyui/jquery.easyui.min.js'></script>
<script type='text/javascript' src='/Public/js/easyui/locale/easyui-lang-zh_CN.js'></script>
<link rel='stylesheet' href='/Public/js/easyui/themes/default/easyui.css' type='text/css'>
<link rel='stylesheet' href='/Public/js/easyui/themes/icon.css' type='text/css'>

<script type="text/javascript" src="/Public/js/zDialog/zDrag.js"></script>
<script type="text/javascript" src="/Public/js/zDialog/zDialog.js"></script>
<script type="text/javascript">
$(document).click(function(){
  $('#b').click(function(){
        $.ajax({
        url: '__URL__/updateData6',
        type: 'post',
        data: {
            id: $('#id').val(),
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
              alert('修改成功');
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
                        <th><span class="del-order">名称</span></th>
                        <td><input name="type" id="mingcheng" type="text" value="<?php echo ($data["mingcheng"]); ?>"/></td>                       
                    </tr>                    
                    <tr>
                        <th><span class="del-order">网址</span></th>
                        <td><input name="type" id="wangzhi" type="text" value="<?php echo ($data["wangzhi"]); ?>"/></td>                       
                    </tr>                    
                    <tr>
                        <th><span class="del-order">电话</span></th>
                        <td><input name="type" id="dianhua" type="text" value="<?php echo ($data["dianhua"]); ?>"/></td>  
                    </tr> 
                    <tr>
                        <th><span class="del-order">手机</span></th>
                        <td><input name="type" id="shouji" type="text" value="<?php echo ($data["shouji"]); ?>"/></td>  
                    </tr>                     
                    <tr>
                        <th><span class="del-order">微信</span></th>
                        <td><input name="type" id="weixin" type="text" value="<?php echo ($data["weixin"]); ?>"/></td>  
                    </tr>                     
                    <tr>
                        <th><span class="del-order">联系人</span></th>
                        <td><input name="type" id="lianxiren" type="text" value="<?php echo ($data["lianxiren"]); ?>"/></td>  
                    </tr>                                                             
                    <tr>
                        <th><span class="del-order">地址</span></th>
                        <td><input name="type" id="dizhi" type="text" value="<?php echo ($data["dizhi"]); ?>"/></td>  
                    </tr>                                                             
                    <tr>
                        <th><span class="del-order">备注</span></th>
                        <td><input name="type" id="beizhu" type="text" value="<?php echo ($data["beizhu"]); ?>"/></td>  
                    </tr>                                                                                                     
                </tbody>
            </table>
        </div>
        <div style="padding-left:150px;"><a id="b"  href="#" class="easyui-linkbutton" >确定</a></div>
      </div>
<input type="hidden" id="id" value="<?php echo ($data["id"]); ?>"/>            
</body>
</html>