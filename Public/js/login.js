// JScript 文件

	function valide()
	{
		if(test_string_not_null(document.all.txtName.value))
		{
			alert("用户名不能为空！");
			return false;
		}

		if(test_string_not_null(document.all.txtPwd.value))
		{
			alert("密码不能为空！");
			return false;
		}
		return true;
    }
    
    function test_string_not_null(str)
    {
        if(str=="")
        {
            return true;
        }
	    for(i=0;i<str.length;i++)
	    {
		    if(str.charAt(i,1)!=" ")
			    return false;
	    }
	    return true;
    }
    
    function rtn()
    {
        if(confirm('确定要退出吗？'))
        {
           window.opener=null;
           window.close();
        }
    }
    
     function bronfus()
     {
        if(valide())
        {
            document.getElementById("ImageButton1").focus();
        }
     }
