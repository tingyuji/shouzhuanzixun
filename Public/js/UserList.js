// JScript 文件

      function chgSearchKey()
      {
          document.getElementById("DvTempContent").style.height=document.body.offsetHeight-45;
          var varValue=document.getElementById("ddlKey").value;
          if(varValue=="4" || varValue=="5" )
          {
                document.getElementById("tdTempKey0").style.display="none";
                document.getElementById("tdTempKey1").style.display="";
                document.getElementById("tdTempKey2").style.display="";
                document.getElementById("tdTempKey3").style.display="";
                document.getElementById("tdTempKey4").style.display="";
          }
          else
          {
                document.getElementById("tdTempKey0").style.display="";
                document.getElementById("tdTempKey1").style.display="none";
                document.getElementById("tdTempKey2").style.display="none";
                document.getElementById("tdTempKey3").style.display="none";
                document.getElementById("tdTempKey4").style.display="none"; 
          }
      }
      
      function chgSearchKey_2()
      {
          var varValue=document.getElementById("ddlKey").value;
          if(varValue=="4" || varValue=="5" )
          {
                document.getElementById("txtBegin").value='';
                document.getElementById("txtEnd").value='';
                document.getElementById("tdTempKey0").style.display="none";
                document.getElementById("tdTempKey1").style.display="";
                document.getElementById("tdTempKey2").style.display="";
                document.getElementById("tdTempKey3").style.display="";
                document.getElementById("tdTempKey4").style.display="";
          }
          else
          {
                document.getElementById("tdTempKey0").style.display="";
                document.getElementById("tdTempKey1").style.display="none";
                document.getElementById("tdTempKey2").style.display="none";
                document.getElementById("tdTempKey3").style.display="none";
                document.getElementById("tdTempKey4").style.display="none"; 
          }
      }