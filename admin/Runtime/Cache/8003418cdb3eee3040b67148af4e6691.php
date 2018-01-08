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
        url: '__URL__/updateData7',
        type: 'post',
        data: {
            id: $('#id').val(),
            title: $('#title').val(),
            keyword: $('#keyword').val(),
            content: $('#content').val()         
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
                        <td style="width:78px;"><span class="del-order">标题</span></td>
                        <td><input name="type" id="title" style="width:256px;height:25px;margin-top:5px;" type="text" value="<?php echo ($data["title"]); ?>"/></td>                       
                    </tr>                    
                    <tr>
                        <td style="width:78px;"><span class="del-order">关键字</span></td>
                        <td><input name="type" id="keyword" style="width:256px;height:25px;margin-top:5px;" type="text" value="<?php echo ($data["keyword"]); ?>"/></td>                       
                    </tr>                    
                    <tr>
                        <td style="width:78px;"><span class="del-order">内容</span></td>
                        <td><textarea id="content" style="width:256px;height:250px;margin-top:5px;"><?php echo ($data["content"]); ?></textarea></td>  
                    </tr>                                                                                                 
                </tbody>
            </table>
        </div>
        <div style="padding-left:150px;"><a id="b"  href="#" class="easyui-linkbutton" >确定</a></div>
      </div>
<input type="hidden" id="id" value="<?php echo ($data["id"]); ?>"/>            
</body>
</html>