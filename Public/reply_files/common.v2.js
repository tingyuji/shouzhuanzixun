var $p = {
    stimo: undefined,
    id: function(id) {
        return document.getElementById(id)
    }
};
var domn=document.domain
function SetCookie(name, value, days) {
    var exp = new Date();
    exp.setTime(exp.getTime() + days * 24 * 3600000);
    document.cookie = name + "=" + encodeURI(value) + ";expires=" + exp.toGMTString() + ";path=/;domain=."+domn
};
function GetCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null) {
        return decodeURI(arr[2])
    } else {
        return ""
    }
};
function DelCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() + 0);
    document.cookie = name + "=" + encodeURI() + ";expires=" + exp.toGMTString() + ";path=/"
};
function showTebox(tit, cont) {
    //微信分享
    if(/MicroMessenger/i.test(navigator.userAgent)){
         if(!document.querySelector('#tip')){
            $(document.body).append('<div id="tip" style="display:none"><div id="tipcon"></div></div>')
        }
        $('#tip').show().bind('click',function(){
            $(this).hide()
        });
        return;
    }
    $("#showTebox").remove();
    $("body").append('<div id="showTebox"><div id="showTit"><span>' + tit + '</span><i id="close">×</i></div><div class="dowcont">' + cont + '</div></div>');
    $("#showTebox").css({
        "top": Math.floor($(window).height() / 2 + $("body").scrollTop() - $("#showTebox").outerHeight() / 2) + "px"
    });
    $("#showTit i").click(function() {
        $("#showTebox").remove()
    })
};
function showAlertBox(url) {
    $("#nav_tools").toggleClass("navhover");
    $("#showTebox").remove();
    url = (url == undefined) ? document.URL: url;
    showTebox("分享到", '<ul class="fxconte"><li><a class="weibo" href="http://service.weibo.com/share/share.php?raltateUid=&amp;url=' + encodeURIComponent(url) + '"><i></i></a>新浪微博</li><li><a class="tenct" href="http://v.t.qq.com/share/share.php?url=' + encodeURIComponent(url) + '"><i></i></a>腾讯微博</li><li><a class="qzon" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + encodeURIComponent(url) + '"><i></i></a>QQ空间</li></ul>')
};
function errorFun(msg, tim) {
	if(msg!==""){
    clearInterval($p.stimo);
    $("#arrorbox").length > 0 ? $("#arrorbox").html(msg) : $("body").append("<div id='arrorbox' style='background:rgba(0,0,0,0.7); position:absolute; left:50%;border-radius:5px; line-height:20px; text-align:center; color:#FFF; font-size:16px; padding:10px; max-width:300px;box-shadow:0px 0px 7px rgba(0,0,0,0.5); z-index:999;opacity:0;-webkit-transition:opacity 200ms ease-in-out;word-wrap:break-word;'>" + msg + "</div>");
	$("#arrorbox").css({
        "margin-left": -Math.floor($("#arrorbox").outerWidth() / 2),
        "top": Math.floor($(window).height() / 2 + $("body").scrollTop() - 50) + "px",
		"opacity":1
    });
    $p.stimo = (tim == undefined) ? setTimeout("$('#arrorbox').remove()", 3000) : setTimeout("$('#arrorbox').remove()", tim)
	}
};
function showsmObj(str, id, sty) {
    return '<div class="showsms" style="' + sty + '" kid="' + id + '">' + str + '<span></span><i>×</i></div>'
};
function shownav() {
    $("#hdnav-cont").toggleClass("shownav")
};
$(function() {
    var $backToTopEle = $('<div id="toTop"><i></i></div>').appendTo($("body")).bind("click",
    function() {
        $("html, body").animate({
            scrollTop: 0
        },
        200)
    });
    $backToTopFun = function() {
        var st = $(document).scrollTop(),
        winh = $(window).height(); (st > 500) ? $backToTopEle.show() : $backToTopEle.hide()
    };
    $(window).bind("scroll", $backToTopFun);
    $("#nav_bar").click(function() {
        $("#nav_tools").toggleClass("navhover")
    });
    if ($(".baiduad").length != 0) {
        $(".baiduad").html($(".advbox").html());
        $(".advbox").remove();
    };
	var sitename=GetCookie("sitename");
	var downapp=(/MicroMessenger/i.test(navigator.userAgent))?"http://img.pccoo.cn/wap/downapp.html":((/iPhone/i.test(navigator.userAgent))?"https://itunes.apple.com/cn/app/ccoo-cheng-shi-tong/id939332605":"http://m.webapp.ccoo.cn/download/ccoocity.apk");
	var noDown=($("#commjs").length>0)?$("#commjs").attr("src").indexOf("appDown=0")==-1:true;
	if(/Android|iPhone/i.test(navigator.userAgent)&&GetCookie("appdown") == ""&&noDown){
		//$("body").append('<div class="A14_140123W" style="visibility:visible !important"><div class="im"><img src="http://img.pccoo.cn/wap/images/ioc-logo.png"></div> <div class="tx"><h3>'+sitename+'</h3><p>把生活装进口袋</p></div><a class="down" href="'+downapp+'">客户端下载<i class="icon-A14_140123W download"></i></a><a id="closedow"><span><i class="icon-A14_140123W cross"></i></span></a></div>');
		$("#closedow").click(function(){
			SetCookie("appdown", 1, 1);
			$(".A14_140123W").remove()
		})
	}
	$("#bbs_tools").click(function () {
		$(this).toggleClass("bbstohov");
		$("#bbstobox").toggleClass("bboxhov")
	});
	$("#bbstobox a").click(function () {
		$("#bbs_tools").removeClass("bbstohov");
		$("#bbstobox").removeClass("bboxhov")
	})
	imghover()
});
window.Swipe = function(e, t) {
    if (!e) return null;
    var n = this;
    this.options = t || {},
    this.index = this.options.startSlide || 0,
    this.speed = this.options.speed || 300,
    this.callback = this.options.callback ||
    function() {},
    this.delay = this.options.auto || 0,
    this.container = e,
    this.element = this.container.children[0],
    this.container.style.overflow = "hidden",
    this.element.style.listStyle = "none",
    this.element.style.margin = 0,
    this.setup(),
    this.begin(),
    this.element.addEventListener && (this.element.addEventListener("touchstart", this, !1), this.element.addEventListener("touchmove", this, !1), this.element.addEventListener("touchend", this, !1), this.element.addEventListener("webkitTransitionEnd", this, !1), this.element.addEventListener("msTransitionEnd", this, !1), this.element.addEventListener("oTransitionEnd", this, !1), this.element.addEventListener("transitionend", this, !1), window.addEventListener("resize", this, !1))
},
Swipe.prototype = {
    setup: function() {
        this.slides = this.element.children,
        this.length = this.slides.length;
        if (this.length < 2) return null;
        this.width = "getBoundingClientRect" in this.container ? this.container.getBoundingClientRect().width: this.container.offsetWidth;
        if (!this.width) return null;
        this.container.style.visibility = "hidden",
        this.element.style.width = this.slides.length * this.width + "px";
        var e = this.slides.length;
        while (e--) {
            var t = this.slides[e];
            t.style.width = this.width + "px",
            t.style.display = "table-cell",
            t.style.verticalAlign = "top"
        }
        this.slide(this.index, 0),
        this.container.style.visibility = "visible"
    },
    slide: function(e, t) {
        var n = this.element.style;
        t == undefined && (t = this.speed),
        n.webkitTransitionDuration = n.MozTransitionDuration = n.msTransitionDuration = n.OTransitionDuration = n.transitionDuration = t + "ms",
        n.MozTransform = n.webkitTransform = "translate3d(" + -(e * this.width) + "px,0,0)",
        n.msTransform = n.OTransform = "translateX(" + -(e * this.width) + "px)",
        this.index = e
    },
    getPos: function() {
        return this.index
    },
    prev: function(e) {
        this.delay = e || 0,
        clearTimeout(this.interval),
        this.index && this.slide(this.index - 1, this.speed)
    },
    next: function(e) {
        this.delay = e || 0,
        clearTimeout(this.interval),
        this.index < this.length - 1 ? this.slide(this.index + 1, this.speed) : this.slide(0, this.speed)
    },
    begin: function() {
        var e = this;
        this.interval = this.delay ? setTimeout(function() {
            e.next(e.delay)
        },
        this.delay) : 0
    },
    stop: function() {
        this.delay = 0,
        clearTimeout(this.interval)
    },
    resume: function() {
        this.delay = this.options.auto || 0,
        this.begin()
    },
    handleEvent: function(e) {
        switch (e.type) {
        case "touchstart":
            this.onTouchStart(e);
            break;
        case "touchmove":
            this.onTouchMove(e);
            break;
        case "touchend":
            this.onTouchEnd(e);
            break;
        case "webkitTransitionEnd":
        case "msTransitionEnd":
        case "oTransitionEnd":
        case "transitionend":
            this.transitionEnd(e);
            break;
        case "resize":
            this.setup()
        }
    },
    transitionEnd: function(e) {
        this.delay && this.begin(),
        this.callback(e, this.index, this.slides[this.index])
    },
    onTouchStart: function(e) {
        $("input[type='text']").blur();
        this.start = {
            pageX: e.touches[0].pageX,
            pageY: e.touches[0].pageY,
            time: Number(new Date)
        },
        this.isScrolling = undefined,
        this.deltaX = 0,
        this.element.style.MozTransitionDuration = this.element.style.webkitTransitionDuration = 0
    },
    onTouchMove: function(e) {
        if (e.touches.length > 1 || e.scale && e.scale !== 1) return;
        this.deltaX = e.touches[0].pageX - this.start.pageX,
        typeof this.isScrolling == "undefined" && (this.isScrolling = !!(this.isScrolling || Math.abs(this.deltaX) < Math.abs(e.touches[0].pageY - this.start.pageY))),
        this.isScrolling || (e.preventDefault(), clearTimeout(this.interval), this.deltaX = this.deltaX / (!this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0 ? Math.abs(this.deltaX) / this.width + 1 : 1), this.element.style.MozTransform = this.element.style.webkitTransform = "translate3d(" + (this.deltaX - this.index * this.width) + "px,0,0)")
    },
    onTouchEnd: function(e) {
        var t = Number(new Date) - this.start.time < 250 && Math.abs(this.deltaX) > 20 || Math.abs(this.deltaX) > this.width / 3,
        n = !this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0;
        this.isScrolling || this.slide(this.index + (t && !n ? this.deltaX < 0 ? 1 : -1 : 0), this.speed)
    }
};
function imgload(t) {
    var tis = $(t);
    if (tis.width() >= 100) {
        tis.css({
            "display": "block",
            "margin": "0 auto",
			"width": "100%",
			"max-width": "400px"
        })
    }
}
function imgLoad(t,w) {
    var tis = $(t);
    if (tis.width() >= 100) {
        tis.css({
            "display": "block",
            "margin": "0 auto",
			"width": "100%",
			"max-width": "400px"
        })
    }
}
function bbsPage(i,s,url,dom,str){
	var i = i;	
	if ((document.URL).indexOf('#') > 0) {
		i = parseInt((document.URL).substring((document.URL).indexOf('#') + 1));
		insertcode(1,i*s,url,dom,str);
	}
	$("#pagepush").bind("click", function () {
		if($("#pagepush").html()!="没有了"){
			$(this).html("<img src='http://img.pccoo.cn/wap/images/load.gif' />正在加载，请稍后…")
			i++;
			insertcode(i,s,url,dom,str);
		}
	})
}
function funPage(s,url,dom,str){
	var i = 0;
	if ((document.URL).indexOf('#') > 0) {
		i = parseInt((document.URL).substring((document.URL).indexOf('#') + 1));
		insertcode(1,i*s,url,dom,str);
	} else {
		i++;
		insertcode(i,s,url,dom,str);
	}
	$("#pagepush").bind("click", function () {
		if($("#pagepush").html()!="没有了"){
			$(this).html("<img src='http://img.pccoo.cn/wap/images/load.gif' />正在加载，请稍后…")
			i++;
			insertcode(i,s,url,dom,str);
		}
	})
}
function imghover(){
	$(".imgload").each(function(){
		$(this).attr("src",$(this).attr("thissrc"))
	})
}
function insertcode(page,size,url,dom,str) {
	jQuery.ajax({
		url: url,
		type: "POST",
		data:"CurPage="+page+"&PageSize="+size+"&"+str,
		error:function(){
			errorFun("服务器请求失败，请稍后再试！");
			$("#pagepush").html("点击查看下一页");
			return false;	
		},
		success: function (data) {
			if (data != "undefined") {
				window.location.href = "#" + page;
				$(dom).append(data);
				$("#pagepush").html("点击查看下一页");
				imghover()
			}
			else {
				$("#pagepush").html("没有了");
			}
		}
	});
}
function fnFilter(id){
	var aLi = $("#"+id+" li"); 
	for(var i=0;i<aLi.length;i++){
		aLi[i].onclick = function(){
			if($(this).hasClass("open")){
				closflun();
				return false;	
			}
			$(this).addClass("open").siblings().removeClass("open");
			var mid = $(this).attr("mid");
			var kid = this.id;
			var siblings = $(this).siblings();
			var str = "";
			for(var i=0;i<siblings.length;i++){
				str += siblings[i].id + "=" + siblings[i].getAttribute('sid') + "&";
			}
			oStr = str.substring(0,str.length-1);
			$("#seleoption").html(kiList(kid,oStr,mid));	
			$("#seleoption").css({"display":"block"})	
			$("#opadiv").css("display", "block")
			if ($(window).height() > $("body").height()) {
				$("#opadiv").height($(window).height()-83)
			} else {
				$("#opadiv").height($("body").height()-83)
			}
		}
	}
	function kiList(kid,oStr,mid){
		var str = ""
		for (var v in splist[kid]) {
			if(v==mid){
				str += "<a class='cur' href='?" + kid + "=" + v + "&" + oStr + "'>" + splist[kid][v] + "<span></span></a>";
			}else{
				str += "<a href='?" + kid + "=" + v + "&" + oStr + "'>" + splist[kid][v] + "</a>"
			}
		}
		return str
	}
	function closflun() {
		$("#"+id+" li").removeClass("open")
		$("#opadiv,#seleoption").css("display", "none")
	}
	$("#opadiv").live("click",function () {
		closflun();
	})
	var oBox = '<div class="showoption"><div id="opadiv"></div><div id="seleoption"></div></div>'
	$('body').append(oBox);
}
