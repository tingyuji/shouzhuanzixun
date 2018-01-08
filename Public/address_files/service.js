var aService = angular.module("dh.service",[]);
aService.service('cache',function(){
    var judgeModeReg=false;
        try{
           localStorage.setItem("judgeMode",""); 
           localStorage.removeItem("judgeMode");
           judgeModeReg = true;
        }catch(e){
            judgeModeReg=false;
        }

    this.judgeMode=function(){
        return judgeModeReg;
    }

    this.setCookie=function(name,value)
    {
        var Days = 365;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    }
 
    this.getCookie=function(name)     
    {
          var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
         if(arr != null) return unescape(arr[2]); return null;
    }
    
    this.removeCookie=function(name)
    {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }

    this.buildCacheKey = function(key){
        return 'D-' + key;
    }
    this.setValue = function(key,value){
        if(judgeModeReg){
            localStorage.setItem(key,value);
        }else{
            this.setCookie(key,value);
        }
    }
    this.setValueJson = function(key,value){
         if(judgeModeReg){
            localStorage.setItem(key, angular.toJson(value));
        }else{
            this.setCookie(key,angular.toJson(value));
        }
    }
    this.getValue = function(key){
        if(judgeModeReg){
            return localStorage.getItem(key);
        }else{
            this.getCookie(key);
        }
    }
    this.getValueJson = function(key){
        if(judgeModeReg){
            return angular.fromJson(localStorage.getItem(key));
        }else{
            return angular.fromJson(this.getCookie(key));
        }
    }
    this.removeItem = function(key){
        if(judgeModeReg){
            localStorage.removeItem(key);
        }else{
           this.removeCookie(key); 
        }
    }
})
aService.service("mapApi",["$q","$http",function($q,http){
    var MSearch=null,auto=null; 

    var clearScript = function() {
        var script = document.getElementById('script');
        if (script) {
            script.parentNode.removeChild(script);
        }
    }

    this.inputPrompt=function(val,city){
        var defered = $q.defer();
        var promise = defered.promise;

        var qqDataAdaptor = function(data) {
            var d = {};
            var arr;
            d.list = [];
            if (data && angular.isArray(data.detail)) {
                arr = data.detail;
                for (var j = 0, len = arr.length; j < len; ++j) {
                    if (arr[j].name) {
                        d.list.push(arr[j].name);
                    }
                }
            }
            return d;
        }
        var gdDataAdaptor = function(data) {
            var d = {};
            var arr;
            d.list = [];
            if (data && angular.isArray(data.tips)) {
                arr = data.tips;
                for (var j = 0, len = arr.length; j < len; ++j) {
                    if (arr[j].name) {
                        d.list.push(arr[j].name);
                    }
                }
            }
            return d;
        }
        try {
            //加载输入提示插件
            AMap.service(["AMap.Autocomplete"], function() {
                var autoOptions = {
                        city: city
                    };
                auto = new AMap.Autocomplete(autoOptions);
                //查询成功时返回查询结果
                auto.search(val, function(status, result){
                    if(status == 'complete' && result.info === 'OK'){
                            defered.resolve(gdDataAdaptor(result));
                    }else{
                       qqMap.inputPrompt(val, city, function(result) {
                            clearScript();
                            defered.resolve(qqDataAdaptor(result));
                        }) 
                    }
                });
            });
        } catch (e) {
            qqMap.inputPrompt(val, city, function(data) {
                clearScript();
                defered.resolve(qqDataAdaptor(data));
            })
        }
        return promise;
    }
    this.byKeywords = function(val,city){
        var defered = $q.defer();
        var promise = defered.promise;
        var resolveData = function(data){
            defered.resolve(data);
        }
        var qqDataAdaptor = function(data) {
            var d = {};
            var arr;
            d.list = [];
            if (data && data.detail && angular.isArray(data.detail.pois)) {
                arr = data.detail.pois;
                for (var j = 0, len = arr.length; j < len; ++j) {
                    d.list.push({
                        name: arr[j].name,
                        address: arr[j].addr,
                        x: arr[j].pointx,
                        y: arr[j].pointy
                    });
                }
            }
            return d;
        }
        var gdDataAdaptor = function(data) {
            var d = {};
            var arr;
            d.list = [];
            if (data && data.poiList && angular.isArray(data.poiList.pois)) {
                arr = data.poiList.pois;
                for (var j = 0, len = arr.length; j < len; ++j) {
                    d.list.push({
                        name: arr[j].name,
                        address: arr[j].address,
                        y: arr[j].location.lat,
                        x: arr[j].location.lng,
                        pguid:arr[j].id
                    });
                }
            }
            return d;
        }

        try {
            AMap.service(["AMap.PlaceSearch"], function() {
                var searchOptions={
                    pageSize:30,//条数
                    pageIndex:1,//页码
                    city:city
                }      
                MSearch = new AMap.PlaceSearch(searchOptions);
                MSearch.search(val, function(status, data){
                    //取回搜索结果
                    if(status === 'complete' && data.info === 'OK'){
                        var list = gdDataAdaptor(data).list || [];
                        var searchData=gdDataAdaptor(data);
                        if (list.length == 0) {
                            http.get("http://115.29.235.21:23456/locationservice/keyword/?keyword=" + val).success(function (d) {
                                if (d && d.code == 0) {
                                    resolveData({list: d.message});
                                } else {
                                    resolveData(searchData)
                                }
                            }).error(function () {
                                resolveData(searchData)
                            })
                        } else {
                            var pguidStr = '';
                            for (var i = 0 , len = list.length; i < len; i++) {
                                pguidStr += list[i].pguid + ',';
                            }
                            http.get("http://115.29.235.21:23456/locationservice/pguidlist/?plist=" + pguidStr).success(function (d) {
                                if (d && d.code == 0) {
                                    var mes = d.message;
                                    for (var i = 0 , listLen = list.length; i < listLen; i++) {
                                        var pguid = list[i].pguid;
                                        for (var j = 0 , len = mes.length; j < len; j++) {
                                            if (pguid == mes[j].pguid) {
                                                list[i] = mes[j]
                                                break;
                                            }
                                        }
                                    }
                                    defered.resolve(searchData);
                                } else {
                                    resolveData(searchData);
                                }
                            }).error(function () {
                                defered.resolve(searchData);
                            })
                        }  
                    }else{
                        qqMap.byKeywords(val, city, function(data) {
                            clearScript();
                            defered.resolve(qqDataAdaptor(data));
                        })
                    }
                });
            })
        } catch (e) {
            qqMap.byKeywords(val, city, function (data) {
                clearScript();
                defered.resolve(qqDataAdaptor(data));
            })
        }
        return promise;
    }
}])
aService.service('ajaxData',["$q","$http",'cache',function($q,$http,cache){
    var getGridLocationUrl = '/ajax/customer/location/get_grid_location/',
        setSessionUrl = '/ajax/set_session_variable/';
    this.getGridLocationId = function(get_grid_location_data){
        var defered = $q.defer();
        var promise = defered.promise;
        $http.post(getGridLocationUrl, get_grid_location_data)
            .success(function(data){
                var grid_location_id = data['grid_location_id'];
                $http.post(setSessionUrl,{
                        'varname': 'last_used_grid_location',
                        'varvalue': get_grid_location_data.description + ',' + grid_location_id
                    })
                    .success(function(){
                        defered.resolve(grid_location_id);
                    })
            }
        );
        return promise;
    }
    this.addAllDeliveryAddress = function(url,key){
        var defered = $q.defer();
        var promise = defered.promise;
        if(cache.judgeMode()){
            var localAddressStr = cache.getValue(key);
        }else{
            var localAddressStr ="";
        }
        if(localAddressStr){
            $http.post(ajax_add_all_delivery_addresses,{data:localAddressStr})
                .success(function(d){
                    if(d.status == 'ok'){
                        var obj = angular.fromJson(d.delivery_addresses);
                        cache.removeItem(key);
                        defered.resolve(obj);
                    }else{
                        defered.reject();
                    }
                })
                .error(function(){
                    defered.reject();
                })
        }else{
            defered.reject();
        }
        return promise;
    }
    this.getpayUrl = function(getPayUrl,oid){
        var defered = $q.defer();
        var promise = defered.promise;
        var getPayUrl = getPayUrl.replace("0",oid);
        $http.get(getPayUrl)
            .success(function(d){
                if(d.status == 'ok'){
                    defered.resolve(d);
                }else{
                    defered.reject(d);
                }
            })
            .error(function(d){
                defered.reject(d);
            })
        return promise;
    }
}])
aService.service("formVaildate",function(){
        var errorMessage = {
            phoneEmpty : "手机号码不能为空！",
            phoneError : "请输入正确的手机号码！",
            phoneNotRegister : '该手机号码尚未注册！<a href="#">立即注册</a>',
            phoneIsRegister : '该手机号码已经注册！您可以<a href="javascript:;" ng-click="alert(1)">立即登录</a>',
            moneyEmpty : "退款金额不能为空！",
            moneyError : "金额格式不正确",
            phonePageNotRegister : '该手机号码尚未注册！<a href="/account/register">立即注册</a>',
            phonePageIsRegister : '该手机号码已经注册！您可以<a href="/account/login">立即登录</a>',

            lPassEmpty : "登录密码不能为空！",
            lPassError : "您输入的密码有误，请确认后重新输入！",
            captchaEmpty : "验证码不能为空",
            captchaOfter : "验证码请求太频繁",
            captchaError : '验证码错误！',
            rPassEmpty : '注册密码不能为空！',
            rPassError : '密码为6 - 10位字符',
            passAgain : '二次密码输入不一致',
            agree : '请同意外卖超人"注册条款"',
            otherError : '未知错误，请稍后再尝试'
        }
    var MOBILE_REG = /^(13[0-9]|15[012356789]|18[0-9]|14[57]|17[0-9])[0-9]{8}$/;
    var MONEY_REG = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
    this.MOBILE_REG = MOBILE_REG;
    this.MONEY_REG = MONEY_REG;
    this.errorMessage = errorMessage;
        this.vaildate={
            empty:function(val){
                if(typeof val =='undefined'){
                    return true
                }
                val = val.replace(/(^\s*)|(\s*$)/g,"");
                if(val == ""){
                    return true;
                }
                return false;
            },
            city:function(val){
                val=val.replace(/(^\s*)|(\s*$)/g,"");
                if(val=="请选择城市"){
                    return true
                }
            },
            money:function(val){
                if(typeof val =='undefined'){
                    return errorMessage.moneyEmpty;
                }
                val = val.replace(/(^\s*)|(\s*$)/g,"");
                if(val == ""){
                    return errorMessage.moneyEmpty;
                }
                if(!MONEY_REG.test(val)){
                    return errorMessage.moneyError;
                }
                return '';
            },
            username : function(username){
                if(typeof username =='undefined'){
                    return errorMessage.phoneEmpty;
                }
                username = username.replace(/(^\s*)|(\s*$)/g,"");
                if(username == ""){
                    return errorMessage.phoneEmpty;
                }
                if(!MOBILE_REG.test(username)){
                    return errorMessage.phoneError;
                }
                return '';
            },
            password : function(val , isOnlyEmpty){
                if(typeof val =='undefined' ){
                    return errorMessage.lPassEmpty;
                }
                val = val.replace(/(^\s*)|(\s*$)/g,"");
                if(val == ""){
                    return errorMessage.lPassEmpty;
                }
                if(!isOnlyEmpty){
                    if(val.length < 6 || val.length > 10){
                        return errorMessage.rPassError;
                    }
                }
                return '';
            },
            passwordAgain : function(val,val2){
                if(val !== val2){
                    return errorMessage.passAgain
                }
                return '';
            },
            captcha : function(val , isOnlyEmpty){
                isOnlyEmpty = isOnlyEmpty || true;
                if(typeof val =='undefined' || val.replace(/(^\s*)|(\s*$)/g,"") == ""){
                    return errorMessage.captchaEmpty;
                }
                return '';
            }

        }
});

aService.factory('requestUpload', function($q){
    return function(formData){

        if (!(formData instanceof FormData)) {return false}

        var deferred  = $q.defer();
        var xhr = new XMLHttpRequest();
        xhr.timeout = 5000;
        xhr.ontimeout = function(){
            deferred.reject('上传图片出错,请稍后再试');
            xhr.abort();
        }
        xhr.onerror = function(){
           deferred.reject();
        }
        xhr.open('POST','http://up.qiniu.com');
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                deferred.resolve(angular.fromJson(xhr.response));
            } else if (xhr.readyState == 4 && xhr.status != 200) {
                deferred.reject();
            }
        }
        xhr.send(formData);
        return deferred.promise; 
    }
});
aService.service("commonApi",function(){
    var isMobile =  {
        Android: function() {
            return navigator.userAgent.match(/Android/i) ? true : false;
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i) ? true : false;
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i) ? true : false;
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
        }
    }
    var Sys = {};
    var ua = navigator.userAgent.toLowerCase();
    var s;
    (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
    (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
    (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
    (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
    (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;

    var isIE = {
        ie8 : function(){
            return navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/8./i)=="8."
        },
        ie9 : function(){
           return navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/9./i)=="9." 
        },
        ie10 : function(){
           return navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/10./i)=="10." 
        },
        ie11 : function(){
           return navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/11./i)=="11." 
        }
    }

    this.isMobile = isMobile;
    this.browser = Sys;
    this.isIE = isIE;
    this.merchantData = {
        citys : ['请选择城市','上海', '宁波', '南京','苏州','杭州','重庆','合肥','青岛','福州','广州','天津','郑州','武汉','北京','深圳','济南'],
        zones : {
            '请选择城市':['请选择区域'],
            '上海': ['黄浦', '徐汇', '长宁', '静安', '普陀', '闸北', '虹口', '杨浦', '浦东', '卢湾', '闵行', '松江', '嘉定','宝山'],
            '宁波': ['海曙', '江东', '江北', '镇海', '北仑', '鄞州', '宁海', '象山', '慈溪', '余姚', '奉化'],
            '南京': ['玄武', '秦淮', '鼓楼', '建邺', '雨花台', '浦口', '六合', '栖霞', '江宁', '溧水', '高淳'],
            '苏州': ['沧浪区', '平江区', '金阊区', '高新区', '吴中区', '相城区', '工业园区'],
            '杭州': ['拱墅区', '上城区', '下城区', '江干区', '西湖区', '滨江区', '萧山区', '余杭区'],
            '重庆': ['渝中区', '大渡口区', '江北区', '沙坪坝区', '九龙坡区', '南岸区','北碚区', '万盛区', '双桥区', '渝北区', '巴南区', '万州区','涪陵区',' 黔江区','长寿区','江津区','合川区','永川区','南川区'],
            '合肥': ['瑶海区', '庐阳区', '蜀山区', '包河区', '长丰县', '肥东县', '肥西县', '庐江县', '巢湖市'],
            '青岛': ['市南区', '市北区', '四方区', '黄岛区', '崂山区', '李沧区', '城阳区', '胶州市', '即墨市', '平度市', '胶南市', '莱西市'],
            '福州': ['鼓楼区','台江区','仓山区','马尾区','晋安区','闽侯县','连江县','罗源县','闽清县','永泰县','平泰县','平潭县','福清县','长乐市'],
            '广州': ['天河区','海珠区','越秀区','荔湾区','番禺区','白云区'],
            '天津': ['和平区','河西区','河东区','河北区','红桥区','南开区','滨海新区','环城四区','武清区','宝坻区','静海县','宁河县','蓟县'],
            '郑州': ['中原区','二七区','金水区','惠济区','上街区','管城回族区','巩义市','新郑市','登封市','新密市','荥阳市','中牟县'],
            '武汉': ['江岸区','江汉区','硚口区','汉阳区','武昌区','青山区','洪山区','东西湖区','汉南区','蔡甸区','江夏区','黄陂区','新洲区'],
            '北京': ['海锭区','东城区','西城区','朝阳区','崇文区','丰台区','宣武区','大兴区','房山区','通州区','顺义区','昌平区','怀柔区','门头沟区','石景山区'],
            '深圳': ['福田区','罗湖区','南山区','盐田区','宝安区','龙岗区','龙华新区','光明新区','坪山新区','大鹏新区'],
            '济南': ['历下区','市中区','槐荫区','天桥区','历城区','长清区','平阴区','济阳区','商河区','章丘区']
        }
    }
});
//叠加附加物
aService.service("getAdditives",function(){
    this.getValue=function(data){
        var _data=angular.copy(data);
        var additivesData=[];
        if(angular.isArray(_data)){
            for(var i=0;i<_data.length;i++){
               var quantity=_data[i].quantity;
               var addition=_data[i].additions;
               if(!addition){
                    addition=[];
               }
               for(var t=0;t<addition.length;t++){
                    for(var f=0;f<additivesData.length;f++){
                        if(additivesData[f].id==addition[t].id){
                            additivesData[f].quantity+=parseInt(quantity);
                            addition[t]="";
                            break;
                        }
                    }
                    if(addition[t]!=""){
                        addition[t].quantity=quantity;   
                        additivesData.push(addition[t]);    
                    }
               }
            }
        }
        return additivesData;
    }
});
aService.factory("postJson", ['$http', function($http) {
    return function (url, data) {
        return $http({
            'method': 'POST',
            'url': url,
            'data': angular.toJson(data),
            'headers': {
                'Content-Type': "application/json"
            }
        })
    }
}])
