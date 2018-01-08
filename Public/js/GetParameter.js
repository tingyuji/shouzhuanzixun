// JScript 文件
        function getParameters(seekParameter)
        {
		        var url=location.href;
		        var parameters=url.substr(url.indexOf("?")+1);
		        var parameterItems=parameters.split("&");
		        var parameterName;
		        var parameterVar;
		        for(i in parameterItems)
		        { 
				        //parameterName=parameterItems[i].split("=")[0];
				        //parameterVar=parameterItems[i].split("=")[1]; 
				        parameterName='123';
				        parameterVar='456';
				        if(parameterName==seekParameter) 
				        {
					        return(parameterVar); 
				        }
		        }	
        }
        