// JScript 文件

    function sltnode(i,parent)
    {   
       if(document.getElementById("dv"+parent+"_"+i).style.display=="")
       {
           document.getElementById("dv"+parent+"_"+i).style.display="none";
           document.getElementById("img"+parent+"_"+i).src="Public/images/TvLeft.gif"
       }
       else
       {                
           var varid="0";
           var varname="所有区域";
           var varCompanyId=getParameters("CompanyId");
           document.getElementById("dv"+parent+"_"+i).style.display="";
           document.getElementById("img"+parent+"_"+i).src="Public/images/TvRight.gif";
           var  obj=MngUser_TvArea.GetArea(parent,varCompanyId);
           var ds=obj.value;
           if(ds != null && typeof(ds) == "object" && ds.Tables != null)
           {         
                document.getElementById("div"+parent+"_"+i).innerHTML="";
                for(var j=0; j<ds.Tables[0].Rows.length; j++)
                {
                    varname=ds.Tables[0].Rows[j].area_name;
                    varid=ds.Tables[0].Rows[j].area_code;      
                    document.getElementById("div"+parent+"_"+i).innerHTML+=
                    "<table cellpadding='0' cellspacing='0' style='width: 100%;' border='0'>"+
		            "<tr>"+
		            "<td width='19px'><img src='Public/images/TvLeft.gif' alt=''  id='img"+varid+"_"+j+"' style='cursor:hand' onclick='sltnode("+j+","+varid+");' /></td>"+
		            "<td style='white-space:nowrap;' align='left'><a href='UserList.aspx?AreaId="+varid+"' target='MainIframe'>"+varname+"</a></td>"+
		            "</tr>"+
		            "<tr id='dv"+varid+"_"+j+"' style='display:none'>"+
		            "<td>"+				 
		            "</td>"+
                    "<td><div id='div"+varid+"_"+j+"'></div>"+
                    "</td>"+
                    "</tr>"+
		            "</table>"
		        }
		   }
       }
    }