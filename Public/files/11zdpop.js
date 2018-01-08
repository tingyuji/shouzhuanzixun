if( /http:\/\/price.pcauto.com.cn\/serial.jsp\?sid=/i.test(window.location.href)){
    function setCookie(name,value,days,domain,path){ document.cookie = name + "=" + escape(value) +("; expires=" + new Date(new Date().getTime() + ((!!days)?days*1:1)*24*60*60*1000).toGMTString()) + ((!!path) ? "; path=" + path : "/") + ((!!domain) ? "; domain=" + domain : "domain="+window.location.host); }
	function getCookie(name){return unescape(document.cookie.replace(new RegExp(".*(?:^|; )"+name+"=([^;]*).*|.*"),"$1"));}
	function closegzBtn(){ document.getElementById("bjzdBox").style.display ="none";setCookie("cxbjPcauto",3);};
	function hidgzBtn(){ document.getElementById("bjzdBox").style.height ="25px";document.getElementById("bjzdBox").style.width ="210px";document.getElementById("opengzBtn").style.display ="block";document.getElementById("narrowgzBtn").style.display ="none";};
	function narrowgzBtn(){ document.getElementById("bjzdBox").style.height ="25px";document.getElementById("bjzdBox").style.width ="210px";document.getElementById("opengzBtn").style.display ="block";document.getElementById("narrowgzBtn").style.display ="none";setCookie("cxbjPcauto",2);};
	function opengzBtn(){ document.getElementById("bjzdBox").style.height ="230px";document.getElementById("bjzdBox").style.width ="350px";document.getElementById("opengzBtn").style.display ="none";document.getElementById("narrowgzBtn").style.display ="block";}

	(function(){
		   if(!getCookie('cxbjPcauto') && /http:\/\/price.pcauto.com.cn\/serial.jsp\?sid=/i.test(window.location.href)){
			  document.write('<script src="http:\/\/www.pcauto.com.cn\/price\/fz\/pop\/1102\/intf281.js" type="text\/javascript"><\/script>');
			  setCookie("cxbjPcauto",1); 
			  setTimeout(hidgzBtn,8000);
		  }	
		  else if((getCookie('cxbjPcauto')==1)&& /http:\/\/price.pcauto.com.cn\/serial.jsp\?sid=/i.test(window.location.href)){
			  document.write('<script src="http:\/\/www.pcauto.com.cn\/price\/fz\/pop\/1102\/intf281.js" type="text\/javascript"><\/script>');
			  setTimeout(hidgzBtn,8000);
			  }
		   else if((getCookie('cxbjPcauto')==2)&& /http:\/\/price.pcauto.com.cn\/serial.jsp\?sid=/i.test(window.location.href)){
			  document.write('<style>body #bjzdBox{height:25px;width:210px;}body #bjzdBox .btnS #opengzBtn{display:block}body #bjzdBox .btnS #narrowgzBtn{display:none}</style>');
			  document.write('<script src="http:\/\/www.pcauto.com.cn\/price\/fz\/pop\/1102\/intf281.js" type="text\/javascript"><\/script>');
			  setTimeout(hidgzBtn,8000);
			  }
		 else if((getCookie('cxbjPcauto')==3)&& /http:\/\/price.pcauto.com.cn\/serial.jsp\?sid=/i.test(window.location.href)){
			  }
	})()
}