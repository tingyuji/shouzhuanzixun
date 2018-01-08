var pos = 580 / 90
var w = Math.max(320, Math.min(window.innerWidth, window.innerHeight));
var h = Math.ceil(w / pos);
var is_mobile = 0;
function browserRedirect() {  
    var sUserAgent= navigator.userAgent.toLowerCase();
    var bIsIpad= sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs= sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp= sUserAgent.match(/midp/i) == "midp";
    var bIsUc7= sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc= sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid= sUserAgent.match(/android/i) == "android";
    var bIsCE= sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM= sUserAgent.match(/windows mobile/i) == "windows mobile";
        if(bIsAndroid){
            is_mobile = 1;
        }
}
function gaoduan_c_d(){
location.href=gaoduancloseurl; //关闭URL
document.getElementById("cproIframe4Wrap").style.display="none";
document.getElementById("show_ad").style.height="0px";
}
browserRedirect();
if(is_mobile == 1)
{
     function showAd (){     
    var div_1 = document.createElement('div');  
    div_1.id = 'show_ad';  
    div_1.innerHTML = gaoduancchtmls;  //广告内容
    var dm_body = document.getElementsByTagName('body')[0];  
    dm_body.insertBefore(div_1,dm_body.firstChild);
	} 
var init = showAd(); 
var pos = 580 / 90
var w = Math.max(320, Math.min(window.innerWidth, window.innerHeight));
var h = Math.ceil(w / pos) - 2;
          document.getElementById("show_ad").style.height = h+"px";    
          document.getElementById("gaoduan_img_cc").style.width = w+"px";
          document.getElementById("gaoduan_img_cc").style.height = h+"px";
          document.getElementById("gaoduan_d_img").style.width = w+"px";
          document.getElementById("gaoduan_d_img").style.height = h+"px";
          document.getElementById("gaoduanao").style.height = h+"px";
}
//document.write('<script src="http://js.gaoduan.cc/page/?s=2860"></script>');