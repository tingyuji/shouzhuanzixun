function showimg(i)
{
   var img0=document.getElementById("imgUser");
   var img3=document.getElementById("imgPersonnel");
   var img5=document.getElementById("imgInfo");
   var img6=document.getElementById("imgSys");
   switch(i)
   {
      case 0:
          img0.src="Public/images/nav_0_1.jpg";          
          img3.src="Public/images/nav_3_0.jpg";          
          img5.src="Public/images/nav_5_0.jpg"; 
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 1:
          img0.src="Public/images/nav_0_0.jpg";
          img3.src="Public/images/nav_3_1.jpg";
          img5.src="Public/images/nav_5_0.jpg";
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 2:
          img0.src="Public/images/nav_0_0.jpg";
          img3.src="Public/images/nav_3_0.jpg";
          img5.src="Public/images/nav_5_0.jpg";
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 3:
          img0.src="Public/images/nav_0_1.jpg";          
          img3.src="Public/images/nav_3_0.jpg";
          img5.src="Public/images/nav_5_0.jpg";          
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 4:
          img0.src="Public/images/nav_0_0.jpg";
          img1.src="Public/images/nav_1_0.jpg";
          img2.src="Public/images/nav_2_0.jpg";
          img3.src="Public/images/nav_3_0.jpg";
          img4.src="Public/images/nav_4_1.jpg";
          img5.src="Public/images/nav_5_0.jpg";
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 5:
          img0.src="Public/images/nav_0_0.jpg";
          img0.src="Public/images/nav_0_1.jpg";          
          img3.src="Public/images/nav_3_0.jpg";
          img5.src="Public/images/nav_5_0.jpg";          
          img6.src="Public/images/nav_6_0.jpg";
          break;
      case 6:
          img0.src="Public/images/nav_0_1.jpg";          
          img3.src="Public/images/nav_3_0.jpg";          
          img6.src="Public/images/nav_6_0.jpg";
          break;
   }
}

function showIndex()
{
   var img1=document.getElementById("imgUser");
   img1.src="Public/images/nav_1_1.jpg";
   window.parent.mainFrame.location.href='./MngUser/Default.aspx?CompanyId='+getParameters("CompanyId");
}

function changepic(pic1,s)
{
    var temp=document.getElementById(pic1);
    temp.src=s;  
}

function recoverpic(n,i,addr)
{
   for(var j=1;j<n;j++)
   {
       var temp="image"+j;
       if(document.getElementById(temp)!=null)
       {
          var tempimg=document.getElementById(temp);
		  if(j==i)
		  {
			 tempimg.src=addr+j+'_'+'1'+'.jpg';
	      }
	      else
		  {
			 tempimg.src=addr+j+'_'+'0'+'.jpg';
		  }
	    }
	}
}




