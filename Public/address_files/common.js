var funParabola=function(d,t,g){var i={speed:166.67,curvature:0.001,progress:function(){},complete:function(){}};var p={};g=g||{};for(var v in i){p[v]=g[v]||i[v]}var u={mark:function(){return this},position:function(){return this},move:function(){return this},init:function(){return this}};var e="margin",r=document.createElement("div");if("oninput" in r){["","ms","webkit"].forEach(function(b){var a=b+(b?"T":"t")+"ransform";if(a in r.style){e=a}})}var s=p.curvature,q=0,o=0;var k=true;if(d&&t&&d.nodeType==1&&t.nodeType==1){var n={},j={};var h={},m={};var f={},l={};u.mark=function(){if(k==false){return this}if(typeof f.x=="undefined"){this.position()}d.setAttribute("data-center",[f.x,f.y].join());t.setAttribute("data-center",[l.x,l.y].join());return this};u.position=function(){if(k==false){return this}var b=document.documentElement.scrollLeft||document.body.scrollLeft,a=document.documentElement.scrollTop||document.body.scrollTop;if(e=="margin"){d.style.marginLeft=d.style.marginTop="0px"}else{d.style[e]="translate(0, 0)"}n=d.getBoundingClientRect();j=t.getBoundingClientRect();h={x:n.left+(n.right-n.left)/2+b,y:n.top+(n.bottom-n.top)/2+a};m={x:j.left+(j.right-j.left)/2+b,y:j.top+(j.bottom-j.top)/2+a};f={x:0,y:0};l={x:-1*(h.x-m.x),y:-1*(h.y-m.y)};q=(l.y-s*l.x*l.x)/l.x;return this};u.move=function(){if(k==false){return this}var a=0,b=l.x>0?1:-1;var c=function(){var z=2*s*a+q;a=a+b*Math.sqrt(p.speed/(z*z+1));if((b==1&&a>l.x)||(b==-1&&a<l.x)){a=l.x}var w=a,A=s*w*w+q*w;d.setAttribute("data-center",[Math.round(w),Math.round(A)].join());if(e=="margin"){d.style.marginLeft=w+"px";d.style.marginTop=A+"px"}else{d.style[e]="translate("+[w+"px",A+"px"].join()+")"}if(a!==l.x){p.progress(w,A);window.requestAnimationFrame(c)}else{p.complete();k=true}};window.requestAnimationFrame(c);k=false;return this};u.init=function(){this.position().mark().move()}}return u};(function(){var b=0;var c=["webkit","moz"];for(var a=0;a<c.length&&!window.requestAnimationFrame;++a){window.requestAnimationFrame=window[c[a]+"RequestAnimationFrame"];window.cancelAnimationFrame=window[c[a]+"CancelAnimationFrame"]||window[c[a]+"CancelRequestAnimationFrame"]}if(!window.requestAnimationFrame){window.requestAnimationFrame=function(h,e){var d=new Date().getTime();var f=Math.max(0,16.7-(d-b));var g=window.setTimeout(function(){h(d+f)},f);b=d+f;return g}}if(!window.cancelAnimationFrame){window.cancelAnimationFrame=function(d){clearTimeout(d)}}}());
function getStyle(b,a){if(b.currentStyle){return b.currentStyle[a]}else{return getComputedStyle(b,false)[a]}}
function startMove(e,b,c,a,d){d = d || 4;clearInterval(e.timer);e.timer=setInterval(function(){var g=true;for(var f in b){var i=0;if(f=="opacity"){i=parseInt(parseFloat(getStyle(e,f))*100)}else{if(a){i=parseInt(e[f])}else{i=parseInt(getStyle(e,f))}}if(isNaN(i)){i=0}var h=(b[f]-i)/d;h=h>0?Math.ceil(h):Math.floor(h);if(i!=b[f]){g=false}if(f=="opacity"){e.style.filter="alpha(opacity:"+(i+h)+")";e.style.opacity=(i+h)/100}else{if(a){e[f]=i+h}else{e.style[f]=i+h+"px"}}}if(g){clearInterval(e.timer);if(c){c()}}},30)};
//alternative map
var qqMap = (function () {

    var promptUrl = 'http://apic.map.qq.com/?qt=sg&tp=0&output=jsonp&pf=jsapi&cb=qqMap.promptCb';
    var searchUrl = 'http://apic.map.qq.com/?qt=poi&pn=0&rn=30&nj=0&output=jsonp&pf=jsapi&cb=qqMap.searchCb';

    function fireJsonp(url) {
        var script = document.createElement('script');
        script.id = 'script';
        script.src = url;
        document.body.appendChild(script);
    }

    return {
        promptCb: function(){},
        searchCb: function(){},
        inputPrompt: function (val, city, callback) {
            var url = promptUrl + '&wd=' + encodeURI(val) + '&c=' + encodeURI(city);
            this.promptCb = callback;
            fireJsonp(url);
        },
        byKeywords: function (street, city, callback) {
            var url = searchUrl + '&wd=' + encodeURI(street) + '&c=' + encodeURI(city);
            this.searchCb = callback;
            fireJsonp(url);
        }
    }
})();
(function(angular){
    var aForm = angular.module("dh.form", [],["$httpProvider",function($httpProvider) {
      $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
      var param = function(obj) {
        var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

        for(name in obj) {
          value = obj[name];
          if(value instanceof Array) {
            for(i=0; i<value.length; ++i) {
              subValue = value[i];
              fullSubName = name + '[' + i + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if(value instanceof Object) {
            for(subName in value) {
              subValue = value[subName];
              fullSubName = name + '[' + subName + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if(value !== undefined && value !== null)
            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
        }

        return query.length ? query.substr(0, query.length - 1) : query;
      };
      $httpProvider.defaults.transformRequest = [function(data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
      }];
    }]);
    aForm.directive("loginBox", function () {
        return{
            restrict: "A",
            link: function (scope, elem) {
                scope.$watch("loginInfo", function (v) {
                    if (v) {
                        var memberWrap=document.getElementById("member-wrap");
                        if(memberWrap){
                            var html=' <span class="username">Hey，'+v+' ! </span>'+
                            '<span class="my_account"><a target="_blank" href="/account/center/manage/">个人中心</a></span>'+
                            '<span class="split">|</span>'+
                            '<span class="logout"><a id="logout" href="/account/logout/">退出</a></span>';
                        }else{
                            var html='<li><a href="/" title="首页" class="index">首页</a></li>'+
                            '<li class="userName">'+
                                '<a href="/account/center/manage/" rel="nofollow" draw-user>'+v+'<em></em></a>'+
                                '<div>'+
                                    '<p><a href="/account/center/manage/"  rel="nofollow">账号管理</a></p>'+
                                    '<p><a href="/account/center/address/"  rel="nofollow">地址管理</a></p>'+
                                    '<p class="no-bo"><a id="logout" href="/account/logout/" referer-url rel="nofollow">退出</a></p>'+
                                '</div>'+
                            '</li>'+
                            '<li><a href="/account/center/orders/" class="order-center"  rel="nofollow">我的订单</a></li>'+
                            '<li><a href="/account/center/favorite/"  rel="nofollow">我的收藏</a></li>'+
                            '<li><a href="/account/gift/center/"  rel="nofollow">氪星礼品站</a></li>'+
                            '<li class="phone-client"><a href="/app/"  rel="nofollow" target="_blank"><span>手机客户端</span></a></li>';
                        }
                        elem.addClass('logging').html(html);
                    }
                })
            }
        }
    })
    aForm.directive("dhCheckbox", function () {
        return {
            restrict: 'E',
            template: '<label class="checkbox"><div class="checker"><span ng-class="{checked:model}">'+
            '<input type="checkbox" ng-disabled="disable" ng-true-value="{{value ? value : true}}" ng-model="model"></span></div><span>{{title}}</span></label>',
            scope: {
                title: '@',
                model: '=',
                disable:'=',
                value:'='
            },
            replace: true
        };
    });
    aForm.directive("dhRadio", function () {
        return {
            restrict: 'E',
            template: '<label class="checkbox"><div class="checker radio"><span ng-class="{checked:model==value}">'+
            '<input ng-value="value" type="radio" ng-model="model"></span></div><span>{{title}}</span></label>',
            scope: {
                title: '@',
                model: '=',
                value: '='
            },
            replace: true
        };
    });
    aForm.directive("dhSelect", function () {
        return {
            restrict: "E",
            replace: true,
            template: ['<div class="dropdown-box" ng-click="innerChange($event)">',
                        '<div class="dropdown-select">',
                            '<span class="dropdown-text" ng-bind="index ? datas[index].text : datas[0].text"></span>',
                            '<span class="caret"></span>',
                        '</div>',
                        '<ul class="dropdown-menu" ng-class="{active : isOpen}" >',
                            '<li ng-repeat="item in datas" index="{{$index}}" class="{{item.className}}" ng-class="{selected:(index==$index)}" ng-bind="item.text"></li>',
                        '</ul>',
                    '</div>'].join(''),
            scope: {
                datas: "=data",
                index: "=selectedindex",
                change: '&',
                width:'@',
                showrow:'@'
            },
            link: function (scope,elem) {
                scope.isOpen = false;
                if(scope.showrow){
                    if(scope.datas.length<=14&&scope.datas.length>7){
                        elem.addClass("db");
                    }else if(scope.datas.length>14){
                         elem.addClass("dbthree");
                    }
                }
                scope.innerChange = function ($event) {
                    scope.isOpen = !scope.isOpen;
                    if (scope.isOpen) {
                        setTimeout(function () {
                            var $elem = angular.element(document);
                            try{$elem.off('click')}catch(e){}
                            $elem.on('click',function(e){
                                scope.isOpen = false;
                                scope.$apply();
                                angular.element(this).off('click');
                                return false;
                            })
                        }, 0)
                    }
                    if ($event.target.nodeName == 'LI') {
                        var index = angular.element($event.target).attr("index");
                        scope.index = index;
                        if (scope.change) {
                            scope.change({
                                index: index
                            });
                        }
                    }
                }
                if(scope.width){
                    angular.element(angular.element(elem.children()[0]).children()[0]).css('width',scope.width + 'px');
                }
            }
        }
    });
    aForm.directive('dhCaptcha', function() {
        return {
            restrict: "E",
            replace: true,
            template: '<img class="captcha" alt="验证码">',
            scope: {
                src : '@',
                change:'='
            },
            link: function(scope, elem, attrs) {
                var imgCaptchaTimeoutId = null;
                elem[0].src = scope.src;
                function changeCaptcha () {
                    clearTimeout(imgCaptchaTimeoutId);
                    imgCaptchaTimeoutId = setTimeout(function() {
                        elem[0].src = scope.src + '?r=' + Math.random();
                    }, 200)
                }
                scope.$watch("change",function(src){
                    changeCaptcha()
                });
                elem.on('click',function(){
                    changeCaptcha()
                })
            }
        };
    });
    aForm.directive("autocompleteBox", ["$timeout", 'mapApi', function (timeout, mapApi) {
        return{
            restrict: "E",
            template:'<div><div style="display:inline-block">' +
                        '<input type="text" placeholder="例：武定西路1189号" ng-model="keyword"/>' +
                        '<ul ng-class="{disblock:searchResultIsShow}" style="width: 428px;" class="search-result-box">' +
                            '<li ng-repeat="item in datas track by $index" ng-click="searchResultSelect(item)">' +
                                '<h5 ng-bind="item"></h5>' +
                            '</li>' +
                        '</ul>' +
                    '</div>' +
                    '<button class="btn btn-success" ng-click="searchResultSelect(keyword)">开始校验</button></div>',
            replace:true,
            scope:{
                keyword:'=',
                city:'@',
                selectedResult:'&callback'
            },
            link: function (scope, elem) {
                var currentTimeout = null;
                var $input = angular.element(elem.find("input")[0]);
                scope.$watch("keyword", function (val) {
                    val = val && val.replace(/(^\s*)|(\s*$)/g, "");
                    if (!val || (val.length < 2)) {
                        scope.searchResultIsShow = false;
                        scope.datas = [];
                        return false;
                    }
                    if (currentTimeout) {
                        timeout.cancel(currentTimeout);
                    }
                    $input.addClass("loading");
                    currentTimeout = timeout(function () {
                        mapApi.inputPrompt(val, scope.city).then(function (data) {
                            $input.removeClass("loading");
                            data = data && data.list;
                            if (data && data.length > 0) {
                                scope.searchResultIsShow = true;
                                scope.datas = data;
                            }
                        });
                    }, 300);
                });
                scope.searchResultSelect = function(keyword){
                    if(keyword == ""){return false;}
                    scope.selectedResult({text:keyword})
                }
                scope.autocompleteFocus = function () {
                    elem[0].focus();
                }
                elem.on("keypress", function (e) {
                    if (e.keyCode == 13) {
                        scope.searchResultSelect(scope.keyword);
                    }
                });
                angular.element(document).on('click', function (e) {
                    if (e.target.className.indexOf('search-result-box') != -1) {
                        return false;
                    }
                    scope.searchResultIsShow = false;
                    scope.$apply();
                })
            }
        }
    }]);
    aForm.directive("mobile",["formVaildate",function(formVaildate){
        return{
            restrict: "A",
            require:'ngModel',
            link:function(scope,elem,attrs,ctrl){
                ctrl.$parsers.push(function(v){
                    if(formVaildate.MOBILE_REG.test(v)){
                        ctrl.$setValidity('mobile',true);
                        return v;
                    }else{
                        ctrl.$setValidity('mobile',false);
                        return undefined;
                    }
                })
            }
        }
    }])
    aForm.directive('page',["$location",function($location){
        return{
            restrict: "E",
            replace:true,
            template:'<ul class="pager select-none"></ul>',
            compile:function(elem,attrs){
                var searchStr = location.search.substr(1),
                    routeMode = attrs['routeMode'],
                    searchArr = searchStr.split('&');
                    searchObj = {}
                for(var i = 0, len = searchArr.length; i < len; i++){
                    var arr = searchArr[i].split('=');
                    searchObj[arr[0]] = arr[1];
                }

                var total = parseInt(attrs['total']),
                    num = parseInt(attrs['show']) || 2,
                    curPage = parseInt(searchObj['page']) || 1,
                    prevPage = true ,
                    nextPage = true ,
                    html = '' ,
                    page = 0,
                    pathname = location.pathname,
                    search = '';
                if(total <= 1){
                    elem.remove();
                    return false;
                }
                if(routeMode == '1'){
                    var arr = pathname.match(/\/(\d+)\//) || [0,1];
                    curPage = parseInt(arr[1]);
                }
                for(var item in searchObj){
                    if(item){
                        if(item == 'page'){
                            continue;
                        }
                        search += '&' + item + '=' + searchObj[item];
                    }
                }

                function bulidUrl(page){
                    if(routeMode == '1'){
                        return pathname.replace(/\/\d+\//, '/'+page+'/');
                    }
                    var searchStr = search.substr(1) ?  ('&' + search.substr(1)) : "";
                    return pathname + '?page=' + page + searchStr;
                }
                if(curPage <= 1){
                    curPage = 1;
                    prevPage = false;
                }
                if(curPage >= total){
                    curPage = total;
                    nextPage = false;
                }

                for(var i = num; i >= 1 ; i--){
                    page = curPage - i;
                    if(page < 1){
                        continue;
                    }
                    else{
                        html += '<li class="pager-item"><a href="' + bulidUrl(page) + '">' + page + '</a></li>';
                    }
                }
                html += '<li class="pager-current">' + curPage + '</li>';
                for(i = 1; i <= num; i++){
                    page = i + curPage;

                    if(page > total){
                        break;
                    }
                    html += '<li class="pager-item"><a href="' + bulidUrl(page) + '">' + page + '</a></li>';
                }

                if(prevPage){
                    html = '<li class="pager-previous"><a title="返回上一页面" href="' + bulidUrl(curPage - 1) + '">上一页</a></li>' + html;
                }else{
                    html = '<li class="pager-previous"><span>上一页</span></li>' + html;
                }

                if(curPage == 1){
                    html = '<li class="pager-first first"><span>« 首页</span></li>' + html;
                }else{
                    html = '<li class="pager-first first"><a title="到第一页" href="' + bulidUrl(1) + '">« 首页</a></li>' + html;
                }

                if(nextPage){
                    html = html + '<li class="pager-next"><a title="去下一页面" href="' + bulidUrl(curPage + 1) + '">下一页</a></li>';
                }else{
                    html = html + '<li class="pager-next"><span>下一页</span></li>';
                }

                if(curPage == total){
                    html = html + '<li class="pager-last last"><span>尾页 »</span></li>';
                }else{
                    html = html + '<li class="pager-last last"><a title="到最后一页" href="' + bulidUrl(total) + '">尾页 »</a></li>';
                }
                elem.append(html);
            }
        }
    }])
    aForm.directive('refererUrl',function(){
        return function(scope,elem,attrs){
            var href = elem[0].href;
            href += '?redirect_url=' + encodeURIComponent(location.pathname + location.search);
            elem[0].href = href;
        }
    });
    aForm.directive('drawUser',['commonApi',function(commonApi){
        return function(scope,elem,attrs){
            var $parent=elem.parent(),$draw=elem.next(),timer;
            if(commonApi.isMobile.any()){
                elem.attr("href","javascript:");
                elem.on("click",function(){
                    $parent.toggleClass("active");
                });
            }else{
                elem.on("mouseover",function(){
                    if(timer){
                        clearTimeout(timer);
                    }
                    $parent.addClass("active");
                });
                elem.on("mouseout",function(){
                    timer=setTimeout(function(){$parent.removeClass("active");},300);
                });
                $draw.on("mouseover",function(){
                    if(timer){
                        clearTimeout(timer);
                    }
                    $parent.addClass("active");
                });
                $draw.on("mouseout",function(){
                    timer=setTimeout(function(){$parent.removeClass("active");},300);
                });
            }
        }
    }]);
    aForm.directive('lazyImgLoad',function(){
        return function(scope,elem){
            var oImages = elem[0].getElementsByTagName("img"),
                _src = 'data-src',
                getPosition = function(obj) {
                   var top = 0;
                       //left = 0,
                       //width = obj.offsetWidth,
                       //height = obj.offsetHeight;

                   while(obj.offsetParent){
                       top += obj.offsetTop;
                       //left += obj.offsetLeft;
                       obj = obj.offsetParent;
                   }
                   return {"top":top}//,"left":left,"width":width,"height":height};
                },
                isLoad = function(curImg,src){
                    curImg.src = src;
                    curImg.removeAttribute(_src);
                },
                loadImg = function(){
                    for(var i = 0, len = oImages.length; i < len; i++){
                        var curImg = oImages[i] ,
                            imgTop = getPosition(curImg).top,
                            scrollTop = document.documentElement.scrollTop || document.body.scrollTop,
                            bodyHeight = document.documentElement.clientHeight,
                            src = curImg.getAttribute(_src);
                        if(src){
                            if((scrollTop + bodyHeight / 2) > (imgTop - bodyHeight / 2)&&(imgTop+50)>scrollTop){
                                isLoad(curImg,src);
                            }
                        }
                    }
                },
                init = function(){
                    var timer = null;
                    loadImg();
                    window.onscroll = function(){
                        clearTimeout(timer);
                        timer = setTimeout(function(){
                            loadImg();
                        },300);
                    }
                };
            init();
        }
    })
    aForm.directive('commonFile', ['requestUpload', function(requestUpload) {
        return {
            restrict: 'A',
            scope: {
                success: '&',
                error: '&',
                data: '=',
                beforeChange :'&'
            },
            link: function(scope, elem, attrs) {
                if (!window.FileReader) {
                    elem.uploadify({
                        'height' : 86,
                        'swf':'/static/desktop/js/uploadify.swf',
                        'uploader': 'http://up.qiniu.com',
                        'buttonText': '',
                        'fileTypeDesc': 'Image Files',
                        'fileTypeExts': '*.gif; *.jpg; *.png',
                        'fileObjName':"file",
                        'fileSizeLimit':'5MB',
                        'queueID': 'fileQueue',
                        'formData': {
                            "token":scope.data.token
                        },
                        width: 86,
                        'onUploadSuccess':function(file,data,reponse){
                            if (angular.isFunction(scope.success)) {
                                scope.success({'data': angular.fromJson(data)});
                            }
                        },
                        'onUploadError':function(file,errorCode,erorMsg,errorString){
                            if (angular.isFunction(scope.error)) {
                                scope.error();    
                            }  
                        }
                    });
                } else {
                    elem.on('change', function() {
                        var formData = new FormData();
                        formData.append("token",scope.data.token);
                        formData.append("file", elem[0].files[0]);
                        if(elem[0].files[0].size >5242880 ){
                            scope.error({'data': '图片不能超过5M'});
                            return false;
                        }
                        requestUpload(formData).then(function(d) {
                            if (angular.isFunction(scope.success)) {
                                scope.success({'data': angular.fromJson(d)});
                            }
                        }, function(d) {
                            if (angular.isFunction(scope.error)) {
                                scope.error();    
                            } 
                        })
                    })
                }
            }
        }
    }])
})(angular);

(function(angular){
    var aDialog = angular.module("dh.dialog", []) , dialogIndex = 1 , openDialog = [] ,
        oSection = document.getElementById("wrapBackground"),oFooter = document.getElementById("footer");
    aDialog.directive("dhDialog", ["$sce","commonApi",function (sce,commonApi) {
        return {
            restrict: 'E',
            transclude: true,
            replace:true,
            template: '<div class="common-dialog"><div class="fs16 header"><span ng-bind-html="to_trusted(title)"></span>' +
                '<i ng-show="!hideclose" class="icon close-icon" ng-click="show=false"></i>' +
                '</div><div class="common-dialog-main" ng-transclude></div></div>',
            scope: {
                show : '=',
                title : '@header',
                addClass :'@feeedbackclass',
                width :'@',
                height:'@',
                index : '@',
                hideclose : '@'
            },
            link: function (scope, elem, attrs) {
                elem.removeClass("disnone");
                if(scope.addClass){
                    elem.addClass(scope.addClass);
                }
                scope.to_trusted = function(html_code) {
                    return sce.trustAsHtml(html_code);
                }
                var oLayer = document.getElementById("layer" + dialogIndex);
                if(!oLayer){
                    oLayer = document.createElement("div");
                    oLayer.id = "layer" + dialogIndex;
                    oLayer.className = "common-layer";
                    document.body.appendChild(oLayer);
                }
                if(scope.index){
                    oLayer.style.zIndex = scope.index;
                    elem[0].style.zIndex = parseInt(scope.index) + 1;
                }
                var elem = elem[0], w = elem.offsetWidth/2 , h = elem.offsetHeight/2;
                if(scope.width){
                    w = parseInt(scope.width) / 2;
                }
                if(scope.height){
                    h = parseInt(scope.height) / 2;
                }
                elem.style["marginLeft"] = ( w * -1 ) + "px";
                elem.style["marginTop"]  = ( h * -1 ) + "px";
                elem['dialogLayer'] = oLayer;
                dialogIndex += 1;
                var isClick = false;
                var watchDialogShow = function (v,o) {
                     w = elem.offsetWidth/2 , h = elem.offsetHeight/2;
                    if(scope.width){
                        w = parseInt(scope.width) / 2;
                    }
                    if(scope.height){
                        h = parseInt(scope.height) / 2;
                    }
                     elem.style["marginLeft"] = ( w * -1 ) + "px";
                     elem.style["marginTop"]  = ( h * -1 ) + "px";
                    if(typeof v == 'undefined'){
                        elem.className = elem.className + " scale50 op0";
                        return false;
                    }
                    if(v){
                        elem.style['visibility'] = 'visible';
                        if(scope.addClass){
                            elem.className = 'common-dialog trans '+scope.addClass;
                        }else{
                            elem.className = 'common-dialog trans';
                        }
                        elem['dialogLayer'].style.display = 'block';
                        if(isAddBlur()){
                            setTimeout(function(){
                                    angular.element(oSection).addClass('blur');
                                    angular.element(oFooter).addClass('blur');
                            },0);
                        }
                        openDialog.push(0);
                    }else {
                        if(!+[1,]){
                            elem.style['visibility'] = 'hidden';
                        }else{
                            elem.className = elem.className + " scale50 op0";
                            setTimeout(function(){
                                elem.style['visibility'] = 'hidden';
                            },300);
                        }
                        elem['dialogLayer'].style.display = 'none';
                        openDialog.pop();
                        if(openDialog.length == 0){
                            angular.element(oSection).removeClass('blur');
                            angular.element(oFooter).removeClass('blur');
                        }
                    }
                }
                scope.$watch("show", watchDialogShow);
                function isAddBlur(){
                    return !commonApi.isMobile.any() && !commonApi.browser.safari;
                }
                /*angular.element(oLayer).on('click', function(){
                    scope.show = false;
                    scope.$apply();
                });*/
            }
        }
    }]);
    aDialog.directive('dhLoading',function(){
        return {
            restrict: 'E',
            replace:true,
            template:'<div><div class="fullscreen-loading"></div><div class="fullscreen-loading-img"></div></div>',
            scope:{
                show:'='
            },
            link:function(scope,elem){
                scope.$watch("show", function (v) {
                    if(v){
                        elem.css('display','block');
                    }else{
                        elem.css('display','none');
                    }
                })
            }
        }
    })
})(angular);

(function(angular){
    var other = angular.module("dh.other",[]);
    other.directive("accordion",function(){
        return{
            restrict:"A",
            link:function(scope,elem,attrs){
                var h = 0,
                    $this = angular.element(elem),
                    next = $this.next(),
                    disStr = getStyle(next[0],'display');
                if(disStr == "none"){
                    next.css("display",'block');
                    h = next[0].offsetHeight;
                    next.css({"display":'none','height':'0px'});
                }
                elem.on("click",function(){
                    disStr = next.css("display");
                    if(disStr == "" || disStr == "block"){
                        h = h || next[0].offsetHeight;
                        startMove(next[0],{height:0},function(){
                            next.css("display",'none');
                            $this.find("i").toggleClass("expand-icon")
                        })
                    }else{
                        next.css("display",'block');
                        startMove(next[0],{height:h},function(){
                            $this.find("i").toggleClass("expand-icon")
                        })
                    }

                })
            }
        }
    })
    other.directive("scrollTop",function(){
        return{
            restrict:"C",
            link:function(scope,elem){
                elem.on("click",function(){
                    var d = document.documentElement.scrollTop ? document.documentElement : document.body;
                    startMove(d,{scrollTop:0},null,true)
                })
                angular.element(window).on('scroll',function(){
                    var stop = document.documentElement.scrollTop || document.body.scrollTop;
                    if(stop > 150){
                        startMove(elem[0],{opacity:100})
                    }else{
                        startMove(elem[0],{opacity:0})
                    }
                })

            }
        }
    })
    other.directive("dayOrNight",function(){
        return function(scope,elem){
            setInterval(isNight, 60000);
            function isNight() {
                var hours = new Date().getHours();
                if (hours > 5 && hours < 18) {
                    elem.removeClass('night');
                } else {
                    elem.addClass('night');
                }
            }
            isNight();
        }
    });
    other.directive("scrollPositionStatic",["$window",function(window){
        return function(scope,elem,attrs){
           var top = parseInt(attrs['scrollPositionStatic']),
               className = "scroll-position-static"
           if(isNaN(top) || top < 0){
                top = 0;
           }
           var height=elem[0].offsetHeight,positionTop=attrs['top']||0;
           var createObj=document.createElement("div");
           var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
           elem.after(createObj);
           angular.element(createObj).css({"height":height+"px","display":"none"});
            if(scrollTop > top){
                createObj.style.display="block";
                elem.css({'position': 'fixed','top':positionTop+"px"}).addClass(className);
            }else{
                elem.css({'position': 'static'}).removeClass(className);
                createObj.style.display="none";
            }
           angular.element(window).on('scroll',function(){
                scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                if(scrollTop > top){
                    createObj.style.display="block";
                    elem.css({'position': 'fixed','top':positionTop+"px"}).addClass(className);
                }else{
                    elem.css({'position': 'static'}).removeClass(className);
                    createObj.style.display="none";
                }
           });
        }

    }]);
    other.directive("animateTop",function(){
        return{
            restrict:'A',
            link:function(scope,elem,attrs){
                var top = attrs['animateTop'];
                if(top){
                   angular.element(window).on('scroll',function(){
                        var stop = document.documentElement.scrollTop || document.body.scrollTop;
                        stop = stop > top ? stop - top : 0;
                        startMove(elem[0],{top:stop });
                   })
                }
            }
        }
    });
    other.directive("sliderImg",function(){
        return{
            restrict:'A',
            link: function(scope,elem,attrs){
                   var slideType=attrs["sliderImg"];
                    //each
                    function each(arr, callback) {
                        if (arr.forEach) {
                            arr.forEach(callback);
                        }else {
                            for (var i = 0, len = arr.length; i < len; i++)
                                callback.call(this, arr[i], i, arr);
                        }
                    }
                    // 设置透明度
                    function setOpacity(elem, level) {
                        if (elem.filters) {
                             elem.style.filter = "alpha(opacity=" + level + ")";
                        } else {
                             elem.style.opacity = level / 100;
                        }
                    }
                    function scroll() {
                            var self=this;
                            var targetIdx=0; //目标图片序号
                            var curIndex=0; //现在图片序号
                            var wrapId=elem.children()[1];
                            var ulId=elem.children()[0];

                            var prevBtn=document.createElement("a");
                            var nextBtn=document.createElement("a");
                            prevBtn.id="prevBtn",prevBtn.className="prevBtn",prevBtn.innerHTML="上一页";
                            nextBtn.id="nextBtn",nextBtn.className="nextBtn",nextBtn.innerHTML="下一页";
                            angular.element(elem).append(prevBtn);
                            angular.element(elem).append(nextBtn);

                            status=0;
                            this.width=wrapId.clientWidth;
                            this.height=wrapId.clientHeight;
                            //添加Li按钮
                            var frag=document.createDocumentFragment();
                            num=[]; //存储各个li的应用，为下面的添加事件做准备
                            this.img = wrapId.getElementsByTagName("li");
                            var count= this.img.length;
                            if(ulId.innerHTML==""){
								for(var i=0;i<count;i++){
									(num[i]=frag.appendChild(document.createElement("li"))).innerHTML=i+1;
								}
								ulId.appendChild(frag);
							}else{
								num=angular.element(ulId).find("li");
							}
                            if(count==1){
                                ulId.style.display="none";
                            }
                            //初始化信息
                            num[0].className="on";
                            //将除了第一张外的所有图片设置为透明
                            each(this.img,function(elem,idx,arr){
                                if(slideType=="fade"){
                                    if (idx==0) {
                                        setOpacity(elem,100);
                                    }else{
                                       elem.style.display="none";
                                    }
                                 }else if(slideType=="slideLeft"){
                                     if (idx==0){
                                        elem.style.left="0px";
                                     }
                                 }else if(slideType=="slideTop"){
                                     if (idx==0){
                                        elem.style.top="0px";
                                     }
                                 }
                            });
                            //为所有的li添加点击事件
                            each(num,function(elem,idx,arr){
                                 angular.element(elem).on('click',function(){
                                    scrollType(idx,curIndex);
                                    curIndex=idx;
                                    targetIdx=idx;
                                });
                            });
                            //为左右键添加点击事件
                            prevBtn.onclick=function(){
                                if(status==0){
                                    status=1
                                   if (targetIdx >0) {
                                         targetIdx--;
                                     } else {
                                         targetIdx = self.num.length - 1;
                                     }
                                     scrollType(targetIdx,curIndex);
                                     curIndex = targetIdx;
                                }
                            };
                            nextBtn.onclick=function(){
                                if(status==0){
                                    status=1;
                                   if (targetIdx < self.num.length - 1) {
                                         targetIdx++;
                                     } else {
                                         targetIdx = 0;
                                     }
                                     scrollType(targetIdx,curIndex);
                                     curIndex = targetIdx;
                                }
                            };
                            //自动轮播效果
                             if(count>1) {
                                 var itv = setInterval(function () {
                                     if (targetIdx <num.length - 1) {
                                         targetIdx++;
                                     } else {
                                         targetIdx = 0;
                                     }
                                    scrollType(targetIdx,curIndex);
                                     curIndex = targetIdx;
                                 }, 5000);
                             }
                            if(count>1) {
                                angular.element(elem).on('mouseover',function () {
                                    clearInterval(itv)
                                });
                                 angular.element(elem).on('mouseout', function () {
                                    itv = setInterval(function () {
                                        if (targetIdx <num.length - 1) {
                                            targetIdx++;
                                        } else {
                                            targetIdx = 0;
                                        }
                                       scrollType(targetIdx,curIndex);
                                        curIndex = targetIdx;
                                    }, 5000);
                                })
                            }
                        };
                       function  scrollType(idx,lastIdx){
                            var self=this;
                                if(slideType=="fade"){
                                    fade(idx,lastIdx);
                                }else if(slideType=="slideLeft"){
                                    slideLeft(idx,lastIdx);
                                }else if(slideType=="slideTop"){
                                    slideTop(idx,lastIdx);
                                }
                        }
                        function fade(idx,lastIdx){
                                if(idx==lastIdx) return;
                                var self=this;
                                startMove(self.img[lastIdx],{"opacity":0},function(){
                                    self.img[lastIdx].style.display="none";
                                });
                                self.img[idx].style.display="block";
                                startMove(self.img[idx],{"opacity":100},function(){
                                    status=0;
                                });
                                each(num,function(elem,elemidx,arr){
                                    if (elemidx!=idx) {
                                        num[elemidx].className="";
                                    }else{
                                         num[elemidx].className="on";
                                    }
                                });
                        };
                        function slideLeft(idx,lastIdx){
                                if(idx==lastIdx) return;
                                var self=this;
                                startMove(self.img[lastIdx],{"left":"-"+self.width},function(){img[lastIdx].style.left=self.width+"px"; status=0;},"",10);
                                startMove(self.img[idx],{"left":0},function(){
                                    status=0;
                                },"",10);
                                each(self.num,function(elem,elemidx,arr){
                                    if (elemidx!=idx) {
                                        self.num[elemidx].className="";
                                    }else{
                                         self.num[elemidx].className="on";
                                    }
                                });
                        };
                        function slideTop(idx,lastIdx){
                                if(idx==lastIdx) return;
                                var self=this;
                                startMove(self.img[lastIdx],{"top":"-"+self.height},function(){img[lastIdx].style.top=self.height+"px";});
                                startMove(self.img[idx],{"top":0},function(){
                                    status=0;
                                });
                                each(self.num,function(elem,elemidx,arr){
                                    if (elemidx!=idx) {
                                        self.num[elemidx].className="";
                                    }else{
                                         self.num[elemidx].className="on";
                                    }
                                });
                        }
                        scroll();
            }
        }
    });
    other.directive("flowBox",['$sce',function(sce){
        return {
            restrict:"A",
            link:function(scope,elem,attrs){
                 function _getMaxValue(arr) {
                     var a = arr[0];
                     for (var k in arr) {
                         if (arr[k] > a) {
                             a = arr[k];
                         }
                     }
                     return a;
                 }
                //获取数字数组最小值的索引
                var _getMinKey=function(arr) {
                    var a = arr[0];
                    var b = 0;
                    for (var k in arr) {
                        if (arr[k] < a) {
                            a = arr[k];
                            b = k;
                        }
                    }
                    return b;
                }
                var flow=function(mh,mv){
                     var w = elem[0].offsetWidth;
                     var ul = elem[0];
                     var li = elem.children();
                     var iw = li[0].offsetWidth + mh;
                     var c = Math.floor(w / iw);
                     var liLen = li.length;
                     var lenArr = [];
                     for (var i = 0; i < liLen; i++) {
                         lenArr.push(li[i].offsetHeight);
                     }
                     var oArr = [];
                     for (var i = 0; i < c; i++) {
                         angular.element(li[i]).css({
                            "top":0,
                            "left":iw * i + "px",
                            "position":"absolute"
                         });
                         oArr.push(lenArr[i]);
                     }
                     for (var i = c; i < liLen; i++) {
                         var x = _getMinKey(oArr);
                         angular.element(li[i]).css({
                            "top":oArr[x] + mv + "px",
                            "left":iw * x + "px",
                            "position":"absolute"
                         });
                         oArr[x] = lenArr[i] + oArr[x] + mv;
                     }
                   elem.css({
                        "visibility":"visible",
                        "height":_getMaxValue(oArr)+"px",                       
                        "opacity":"1",
                        "filter":"alpha(opacity=100)"
                    });
                   for (var i = 0; i < liLen; i++) {
                         angular.element(li[i]).css({
                            "opacity":"1",
                            "filter":"alpha(opacity=100)"
                         });
                     }
                }
                flow(10,10);
               /* var re;
                window.onresize = function() {
                    clearTimeout(re);
                    re = setTimeout(function() {flow(10, 10);}, 200);
                }*/
            }
        }
    }]);
    other.directive("toogleNavMenu", ['$timeout',function (timeout) {
        return{
            restrict: "A",
            link: function (scope, elem, attrs) {
                timeout(function(){
                    var defaultH=elem.attr("toogle-nav-menu");
                    var h = 0 , $ul = elem.parent().children() , ul = $ul[0];
                    ul.style.height = 'auto';
                    h = ul.offsetHeight;
                    ul.style.height = defaultH+'px';
                    if (h == defaultH) {
                        elem[0].style.display = 'none';
                    }
                    var curH = h
                    elem.on("click", function () {
                        startMove(ul, {height: curH }, function () {
                            elem.toggleClass("expand-icon shrink-icon")
                        });
                        curH = curH == h ? defaultH : h;
                    })
                },0);
            }
        }
    }]);
    other.directive("scorllFeekback",['$sce','commonApi',function(sce,commonApi){
        return {
            restrict:"C",
            link:function(scope,elem,attrs){
                if(!commonApi.isMobile.any()){
                    elem.on("mouseover",function(){
                        elem.addClass("block");
                    });
                    elem.on("mouseout",function(){
                        elem.removeClass("block");
                    });
                }
            }
        }
    }]);
    other.directive('captchaBox', ["$http", "formVaildate", "$interval", "postJson", function($http, formVaildate, $interval, postJson) {
        return {
            restrict: 'C',
            link: function(scope, elem, attrs) {
                var captchaInput = angular.element(angular.element(elem.children()[0]).find('input'));
                scope.$watch('registerShow', function(v) {
                    if (v) {
                        elem.css('marginLeft', '-300px');
                        scope.registerToken = false;
                    }
                })
                scope.$watch('user.username', function(v, old) {
                    if (old && !v) {return false;}
                    var mes = formVaildate.vaildate.username(scope.user.username);
                    scope.user.usernameMessage = mes;
                    if (mes == '') {
                        if (scope.tmpUsername != scope.user.username && scope.registerToken) {
                            gotoImgCaptcha();
                        }
                        scope.imgCaptchaIsDisabled = false;
                    } else {
                        scope.imgCaptchaIsDisabled = true;
                    }
                });
                function errorCallback(d) {
                    scope.user.imgCaptchaMessage = d.failed_msg;
                    scope.captchaImgChange = Math.random();
                }
                function success() {
                    scope.tmpUsername = scope.user.username;
                    scope.captchaCountdown();
                    scope.registerToken = true;
                    scope.imgCaptchaIsDisabled = true;
                    startMove(elem[0], {'marginLeft': 0});
                    scope.user.imgCaptchaMessage = '';
                    scope.user.captcha = '';
                }
                scope.$watch('user.imgCaptcha', imgCaptchaChange);
                function imgCaptchaChange(v) {
                    if (!scope.registerToken && v && v.length == 4) {
                        postJson(ajax_customer_user_register_start, {
                            "mobile": scope.user.username,
                            "captcha": scope.user.imgCaptcha
                        }).success(function (d) {
                            if (d.status == 'ok') {
                                sendSMSCode(function(d) {
                                    if (d.status == 'ok') {
                                        success();
                                    } else {
                                        errorCallback(d)
                                    }
                                }, function(d) {
                                    errorCallback(d)
                                });
                            } else {
                                errorCallback(d);
                            }
                        }).error(function(d) {
                            errorCallback(d)
                        });
                    }
                }
                scope.getCaptcha = function () {
                    scope.captchaCountdown();
                    sendSMSCode(null, function(d) {
                        scope.user.captchaMessage = d.failed_msg;
                    });
                    return false;
                };
                captchaInput.on('focus', function() {
                    if (!formVaildate.MOBILE_REG.test(scope.user.username)) {
                        gotoImgCaptcha();
                    }
                });
                function sendSMSCode(success, error) {
                    postJson(common_sms_code, {"request_type": "customer_user_register"}).success(function(d) {
                        if (d.status == 'ok') {
                            angular.isFunction(success) && success(d);
                        } else {
                            angular.isFunction(error) && error(d);
                        }
                    }).error(function(d) {
                        angular.isFunction(error) && error(d);
                    })
                }
                function gotoImgCaptcha() {
                    $interval.cancel(scope.intervalId);
                    scope.imgCaptchaIsDisabled = false;
                    startMove(elem[0], {'marginLeft': -300});
                    scope.user.imgCaptcha = '';
                    scope.captchaImgChange = Math.random();
                    scope.registerToken = false;
                }
                scope.beforeRegister = function() {
                    if (!scope.registerToken) {
                        imgCaptchaChange(scope.user.imgCaptcha);
                        return false;
                    }
                    return true;
                };

            }
        }
    }])
})(angular);
/*global controller*/
var loginObj = (function(){
    var scope = null,$interval = null,
        loginSuccess = null,
        registerSuccess = null;
    function build(){
        var intervalId = null ,
            registerInit = function () {
                scope.captchaVal = '获取验证码';
                scope.captchaDisabled = true;
            };
        scope.user = {remember: true};
        scope.logoinDialogShow = function () {
            scope.user = {};
            scope.captchaChange = Math.random();
            scope.loginShow = true;
        }
        scope.locationRegister = function () {
            scope.loginShow = false;
            scope.registerDialogShow();
        }
        scope.locationLogin = function () {
            scope.registerShow = false;
            scope.logoinDialogShow();
        }
        scope.registerDialogShow = function () {
            scope.user = {remember: true};
            scope.captchaImgChange = Math.random();
            registerInit();
            $interval.cancel(scope.intervalId);
            scope.registerShow = true;
            scope.imgCaptchaIsDisabled = true;
        }
        scope.captchaCountdown = function () {
            $interval.cancel(scope.intervalId);
            scope.captchaDisabled = true;
            var i = 59;
            scope.captchaVal =  i + '秒后可获取';
            scope.captchaDisabled = true;
            scope.intervalId = $interval(function () {
                scope.captchaVal = (i--) + '秒后可获取';
                if (i <= 0) {
                    scope.captchaVal = '获取验证码';
                    scope.captchaDisabled = false;
                    $interval.cancel(scope.intervalId);
                }
            }, 1000)
        }
        scope.$on("register-success", function (d) {
            if(angular.isFunction(registerSuccess)){
                registerSuccess();
            }
            scope.loginInfo = d.targetScope.username;
            scope.registerShow = false;
        })
        scope.$on("login-success", function (d) {
            if(angular.isFunction(loginSuccess)){
                loginSuccess();
            }
            scope.loginInfo = d.targetScope.username;
            scope.loginShow = false;
        })
    };
    var returnObj = {
        init : function(_scope,_$interval ,_loginFunc,_registerFunc){
            if(_scope && _$interval){
                scope = _scope;
                $interval = _$interval;
                loginSuccess = _loginFunc;
                registerSuccess = _registerFunc;
                return returnObj;
            }
            return {bind:function(){}};
        },
        bind : function(){
            build();
        }
    }
    return returnObj;
})()
function colorAction($scope){
    var mainBox=document.getElementById("main-box").offsetHeight;
    if(mainBox<=700){
        $scope.threeActive=true;
    }else{
         $scope.threeActive=false;
    }
}
var loginCtrl = ["$scope", "formVaildate", "$http", function (scope, fem, $http) {
    scope.loginBtn = '登录';
    scope.loginBtnDisabled = false;
    scope.loginVaildate = function () {
        var vaildate = true;
        var mes = fem.vaildate.username(scope.user.username);
        scope.user.isLogined = false;
        scope.user.usernameMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        mes = fem.vaildate.password(scope.user.password, true);
        scope.user.passwordMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        if (scope.showCaptcha == 1) {
                mes = fem.vaildate.captcha(scope.user.captcha);
            scope.user.captchaMessage = mes;
            if (mes !== '') {
                vaildate = false;
            }
        }
        if (!vaildate) {
            return false;
        }
        scope.user.remember = scope.user.rememberme ? 1 : 0;
        scope.loginBtnDisabled = true;
        scope.loginBtn = '登录中请稍等';
        //scope.showCaptcha = 0;
        $http.post("/ajax/user_login/", scope.user)
            .success(function (d) {
                if (d.captcha == 1) {
                    scope.showCaptcha = 1;
                    scope.captchaChange = Math.random();
                }
                if (d.status == "ok") {
                    scope.username = d.username
                    scope.$emit('login-success');
                    //更新登录状态
                } else {
                    switch (d.failed_code) {
                        case '1017':
                        case '1022':
                            scope.user.isLogined = true;
                            break;
                        case '1015':
                            scope.user.passwordMessage = fem.errorMessage.lPassError;
                            break;
                        case '1021':
                            if (scope.user.captcha && scope.user.captcha.length > 0) {
                                scope.user.captchaMessage = fem.errorMessage.captchaError;
                            }
                            break;
                        default:
                            scope.user.usernameMessage = fem.errorMessage.otherError;
                    }
                }
                scope.loginBtnDisabled = false;
                scope.loginBtn = '登录';
            })
            .error(function(){
                scope.user.usernameMessage = '未知错误，请稍后在试。'
            })
    }
}]
var registerCtrl = ["$scope", "formVaildate", "$http", "postJson", function (scope, fem, $http, postJson) {
    scope.registerBtn = '确认注册';
    scope.registerVaildate = function () {
        var vaildate = true;
        if (!scope.registerToken) {
            if (!scope.user.imgCaptcha) {
                scope.user.imgCaptchaMessage = '验证码不能为空';
                vaildate = false;
            } else {
                if (scope.user.imgCaptcha.length < 4) {
                    scope.user.imgCaptchaMessage = '图片验证码不正确';
                    vaildate = false;
                } else {
                    if (!scope.beforeRegister()) return false;
                }
            }
        }
        var mes = fem.vaildate.username(scope.user.username);
        scope.user.usernameMessage = mes;
        scope.user.isRegistered = false;
        if (mes !== '') {
            vaildate = false;
        }

        mes = fem.vaildate.captcha(scope.user.captcha);
        scope.user.captchaMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }

        mes = fem.vaildate.password(scope.user.password, false);
        scope.user.passwordMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        mes = fem.vaildate.passwordAgain(scope.user.password, scope.user.password2);
        scope.user.password2Message = mes;
        if (mes !== '') {
            vaildate = false;
        }

        if (vaildate) {
            scope.registerBtn = '注册中请稍等';
            scope.registerBtnDisabled = true;
            postJson(common_validate_sms_code, {"request_type": "customer_user_register", "sms_code": scope.user.captcha})
                .success(function(d){successSMS(d)})
                .error(function(d){errorSMS(d)});

            function successSMS(d) {
                if (d && d.status == 'ok') {
                    postJson(ajax_customer_user_register_register, {"password": scope.user.password })
                        .success(success)
                        .error(error);
                } else {
                    errorSMS(d);
                }
            }
            function errorSMS(d) {
                d && (scope.user.captchaMessage = d.failed_msg);
                callback();
            }
            function success(d) {
                if(d && d.status == 'ok'){
                    scope.username = scope.user.username;
                    scope.$emit('register-success');
                } else {
                    error(d);
                }
            }
            function error(d) {
                d && (scope.user.username = d.failed_msg);
                callback();
            }
            function callback() {
                scope.registerBtn = '确认注册';
                scope.registerBtnDisabled = false;
            }
        }
    }
}]
var feedbackCtrl = ["$scope", "$http","$rootScope", 'formVaildate',function (scope, $http,$rootScope,fem) {
    var childScope = $rootScope.$$childTail;
    scope.feedback = {};
    childScope.$watch("userFeedback",function(v){
        if(v){
            scope.feedback = {};
        }
    })

    scope.feedbackCancel = function(){
        childScope.userFeedback = false;
    }
    scope.userContactFocus=function(){
        scope.feedback.phoneMessage = '';
    }
     scope.feedbacFocus=function(){
        scope.feedback.feedbackMessageTip = "";
    }
    scope.feedbackSubmit = function(){
        var vaildate = true;
        var mes = fem.vaildate.empty(scope.feedback.userContact);
        if (mes) {
            scope.feedback.phoneMessage = "联系方式不能为空";
            vaildate = false;
        } else {
            scope.feedback.phoneMessage = ''
        }
        mes = fem.vaildate.empty(scope.feedback.feedbackMessage);
        if(mes){
            scope.feedback.feedbackMessageTip = "反馈信息不能为空";
            vaildate = false;
        }else{
             scope.feedback.feedbackMessageTip = "";
        }
        if (vaildate) {
            $http.post(feedbackUrl,{"username":scope.feedback.userContact,'message':scope.feedback.feedbackMessage}).success(function(d){
                childScope.userFeedback = false;
            }).error(function(){
                childScope.userFeedback = false;
            })
        }
    }
}]