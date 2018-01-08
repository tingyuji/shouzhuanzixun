app.config(['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}])

app.controller('bodyCtrl',["$scope","$timeout","$http",function(scope,timeout,http){
    scope.showChangePass = false;
    scope.showReview = false;
    scope.reviewObj={};
    scope.reviewIndexObj={};
    scope.order={};
    scope.orderStatus={};
    scope.showChangePassword = function(){
        scope.showChangePass = true;
        scope.$broadcast('reset-change-password','')
    }
    scope.$on('change-password-success',function(){
        scope.showChangePass = false;
        scope.requestSuccess = true;
        timeout(function(){
            scope.requestSuccess = false;
        },2000);
    })
    scope.$on('change-password-error',function(){
        scope.requestError = true;
    })
    scope.$on('change-password-close',function(){
        scope.showChangePass = false;
    })
    scope.$on('close-review',function(d){
        scope.showReview = false;
    });
    scope.$on('close-refund',function(d){
        scope.refundApply = false;
    });
    scope.$on('close-refundFuc',function(d){
        scope.refundFuc = false;
    });
    scope.$on('show-refundFuc',function(d){
        scope.refundFuc = true;
    });
    scope.$on('commit-review',function(d){
        var funcId = 'closeReview' + d.targetScope.orderId;
        scope[funcId] && scope[funcId]();
        scope.showReview = false;
        if(d.targetScope.user_point>0){
            scope.giftReview=true;
            scope.giftReviewMsg="恭喜您获得"+d.targetScope.user_point+"个氪星币";
            var timer = timeout(function(){},1000);
            timer.then(function() {scope.giftReview=false;});
        }
    })
    scope.$on('error-review',function(d){
        scope.reviewError = true;
        scope.reviewErrorMsg = d.targetScope.reviewErrorMsg;
    })
    scope.$on("favorite-error",function(d){
        scope.errorMsg = d.targetScope.errorMsg;
        scope.errorShow = true;
    })
    scope.closeContact=function(){
        scope.showContact=false;
    }
    scope.reviewErrorClose = function(){
        scope.reviewError = false;
    }
    scope.closeTip=function(){
        scope.reviewtip=false;
    }
    scope.$on("overOrder",function(){
        scope.reviewtip=false;
        scope.showReview=true;
    });
    scope.toReview=function(){
         scope.$emit('overOrder');
    }
    scope.refundRightClose=function(){
        scope.refundRight = false;
    }
}])
app.controller("changePasswordCtrl",["$scope",'formVaildate','$http',function(scope,fem,http){
    scope.$on('reset-change-password',function(){
        scope.user = {}
        scope.isSubmit = false;
        scope.submitText = '确认';
    })
    scope.changePassSubmit = function(){
        var mes = fem.vaildate.password(scope.user.password,true);
        var vaildate = true;
        scope.user.passwordMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        mes = fem.vaildate.password(scope.user.newPassword, false);
        scope.user.newPasswordMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        mes = fem.vaildate.passwordAgain(scope.user.newPassword, scope.user.newPassword2);
        scope.user.newPassword2Message = mes;
        if (mes !== '') {
            vaildate = false;
        }
        if(vaildate){
            scope.isSubmit = true;
            scope.submitText = '修改中';
            http.post('/ajax/change_password/',{'old_password':scope.user.password,'new_password':scope.user.newPassword})
                .success(function(d){
                    if(d.status=='ok'){
                        scope.$emit('change-password-success');
                    }else{
                        switch (d.failed_code){
                            case '1019':
                                scope.user.passwordMessage = fem.errorMessage.lPassError;
                                break;
                            case '1028':
                                scope.user.newPasswordMessage = fem.errorMessage.rPassError
                                break;
                            default :
                                scope.user.passwordMessage = fem.errorMessage.otherError;
                        }
                    }
                    scope.isSubmit = false;
                    scope.submitText = '登录';
            }).error(function(){
                scope.$emit('change-password-error','');
            })
        }
    }
    scope.changePassCancel = function(){
        scope.$emit('change-password-close');
    }
}])
app.directive("successReview",function(){
    return{
        restrict:'A',
        link:function(scope,elem,attrs){
            elem.on('click',function(){
                var oid = attrs["oid"];
                scope.href=attrs["link"];
                scope.restaurantName = attrs["name"];
                scope.$broadcast('change-restaurant-name');
                scope.oid = oid;
                scope.$broadcast('reset-review');
                scope.statusDom=$(this).parents("td").prev();
                if(elem.attr("class").indexOf("success-review")>-1){
                    scope.reviewtip = true;
                    scope.curDom=elem;
                }else{
                    scope.showReview = true;
                }
                scope.$apply();
                scope['closeReview' + oid] = function(){
                    elem.off('click');
                    elem.remove();
                    scope.statusDom.text("完成");
                    //elem.attr("href",scope.href);
                }
            });
        }
    }
});
app.controller("reviewCtrl",["$scope",'$http',function(scope,http){
    scope.selectStar = function(k,v){
         scope[k] = v;
         scope.isReviewError = false;
    }
    scope.reviewErrorMsg = '';
    scope.expandText = "展开";
    scope.datas = [
        {id:'0',text:'请选择时间'},
        {id:'15',text:'15分钟'},
        {id:'30',text:'30分钟'},
        {id:'45',text:'45分钟'},
        {id:'60',text:'60分钟'},
        {id:'70',text:'60分钟以上'}
    ];
    scope.$on('reset-review' , function(d){
        scope.reviewObj={};
        scope.reviewIndexObj={};
        scope.reviewText = '';
        scope.isReviewError = false;
        scope.isTimeError = false;
        scope.isShow = false;
        scope.timeSelectedIndex = 0;
        scope.expandText = "展开";
        scope.orderId = d.targetScope.oid;
    })
    scope.expand = function(){
        scope.isShow = !scope.isShow;
        scope.expandText = scope.isShow ? '收起' : '展开';
    }
    scope.timeIndexChange=function(index){
        if(index!=0){
            scope.isTimeError = false;
        }
    }
    scope.submitReview = function(){
        if(scope.reviewObj.totalReview == null){
            scope.isReviewError = true;
            return false;
        }
        if(scope.timeSelectedIndex==0){
             scope.isTimeError = true;
             return false;
        }
        var data = {
            total_star : scope.reviewObj.totalReview,
            taste_star : scope.reviewObj.tasteReview,
            service_star : scope.reviewObj.serveReview,
            speed_star : scope.reviewObj.speedReview,
            review_text : scope.reviewText,
            delivery_time : scope.datas[scope.timeSelectedIndex].id,
            order_id : scope.orderId
        }
        http.post(reviewUrl,data).success(function(d){
            if(d.status == 'ok'){
                scope.user_point=d.user_point;
                scope.$emit('commit-review');
            }else{
                scope.reviewErrorMsg = d.failed_msg;
                scope.$emit('error-review');
            }
        }).error(function(){
            scope.reviewErrorMsg ="访问失败，请稍后再试。"
            scope.$emit('error-review');
        })
    }
    scope.$on("change-restaurant-name",function(d){
        scope.restaurantName = d.targetScope.restaurantName;
    })
    scope.cancelReview = function(){
        scope.$emit('close-review');
    }
}]);
//申请退款
app.directive("refundApply",function(commonApi){
    return{
        restrict:'A',
        link:function(scope,elem,attrs){
            elem.on('click',function(){
                scope.phone = attrs["phone"];
                scope.oid = attrs['oid'];
                scope.num = attrs['num'];
                scope.money = attrs['totalmoney'];
                scope.refundApply = true;
                scope.IETips = false;
               /* scope.refundDom=elem;
                scope.refundNextDom=elem.next();*/
                scope.$broadcast('user-refund');
                scope.$apply();
            });
        }
    }
});
//申诉维权
app.directive("refundRights",function(commonApi){
    return{
        restrict:'A',
        link:function(scope,elem,attrs){
            elem.on('click',function(){
               scope.refundRight = true;
               scope.$apply();
            });
        }
    }
});

app.controller("refundCtrl",["$scope",'$http','formVaildate','$timeout','postJson',function(scope,http,fem,timeout,postJson){
    scope.refundMoneyData = [
        {id:'0','name':'请选择退款类型'},
        {id:'1','name':'全额退款'},
        {id:'2','name':'非全额退款'}
    ];
    scope.reasonData = [
        {id:'0','name':'请选择退款理由'},
        {id:'1','name':'送餐速度过慢'},
        {id:'2','name':'菜品质量有问题'},
        {id:'3','name':'老板漏送了'},
        {id:'4','name':'其他'}
    ];
    scope.imgKey = '';
    scope.$on("user-refund",function(d){
        scope.refundForm = {
            "refundMoney":scope.refundMoneyData[0],
            "reason":scope.reasonData[0]
        };
        scope.refundForm.phone = d.targetScope.phone;
        scope.oid = d.targetScope.oid;
        scope.totalmoney = d.targetScope.money;
        scope.num = d.targetScope.num;
        scope.IETips = d.targetScope.IETips;
        /*scope.refundDom = d.targetScope.refundDom;
        scope.refundNextDom = d.targetScope.refundNextDom;*/
    });

    scope.refundApplyCancel=function(){
        scope.$emit("close-refund");
    }
    scope.refundMoneyChange = function(){
        scope.refundForm.money = '';
        scope.refundForm.moneyMessage = "";
        if(scope.refundForm.refundMoney.id != 0){
            scope.refundForm.refundMoneyMessage = "";
        }
    }
    scope.refundReasonChange = function(){
        scope.refundForm.otherReason = '';
        if(scope.refundForm.reason.id != 0){
            scope.refundForm.reasonDataMessage = "";
            scope.refundForm.otherReasonMessage = "";
        }
    }
    //删除上传过的图片
    scope.removeImg = function(){
        scope.refundForm.imgRemove = false;
        scope.refundForm.imgSrc= '';
        scope.imgKey = '';
        scope.IETips = false;
    }

    scope.fileSuccess = function(data){
        try{
            var reader = new FileReader();  
            reader.onload = function(e) {   
                scope.refundForm.imgSrc = this.result;  
                setTimeout(function(){ scope.$apply();},0);
            }  
            reader.readAsDataURL(document.getElementById("imgInp").files[0]);  
        }catch(e){
           scope.refundForm.imgSrc = static+"desktop/img/suc_upload.jpg";
           scope.IETips = true;
           setTimeout(function(){ scope.$apply();},0);
        }
       scope.imgKey = data.key;
       scope.refundForm.imgRemove = true;
       scope.refundForm.upimgError = '';
       
    }
    scope.fileError = function(data){
        if(data){
            scope.refundForm.upimgError = data.error;
        }else{      
            scope.refundForm.upimgError = '上传图片失败,请确认图片大小规格是否正确，刷新重试'; 
        }
       setTimeout(function(){ scope.$apply(); });
    }
    scope.formData ={
        "token":token
    }

    scope.refundApplyOk=function(){
        var vaildate = true;
        //验证手机
        mes = fem.vaildate.username(scope.refundForm.phone);
        scope.refundForm.phoneMessage = mes;
        if (mes !== '') {
            vaildate = false;
        }
        //验证退款金额
        if(scope.refundForm.refundMoney.id == 0){
            scope.refundForm.refundMoneyMessage = '请选择退款类型';
             vaildate = false;
        }else if(scope.refundForm.refundMoney.id == 2){
            mes = fem.vaildate.money(scope.refundForm.money);
            scope.refundForm.moneyMessage = mes;
            if (mes !== '') {
                vaildate = false;
            }
            if(parseFloat(scope.refundForm.money) > parseFloat(scope.totalmoney)){
                scope.refundForm.moneyMessage = '退款金额不能大于 '+scope.totalmoney+' 元';
                vaildate = false;
            }
            if(parseFloat(scope.refundForm.money) <= 0){
                scope.refundForm.moneyMessage = '退款金额不能小于等于0元';
                vaildate = false;
            }
        }
        //验证退款理由
        if(scope.refundForm.reason.id == 0){
            scope.refundForm.reasonDataMessage = '请选择退款理由';
             vaildate = false;
        }else if(scope.refundForm.reason.id == 4){
            mes = fem.vaildate.empty(scope.refundForm.otherReason);
            if(mes){
                scope.refundForm.otherReasonMessage = "退款理由不能为空";
                vaildate = false;
            }else{
                scope.refundForm.otherReasonMessage = '';
            }
        }
        //提交
        var ajaxRefund = function (url,data){
            scope.refundSubmit = true;
            postJson(url,data).success(function(d){
                scope.refundSubmit = false;
                if(d.status == 'ok'){
                    scope.$emit("close-refund");
                    scope.$emit("show-refundFuc"); 
/*                    scope.refundDom.hide();
                    scope.refundNextDom.show();*/
                    timeout(function(){
                        window.location.reload();
                    },1200)
                    /*timeout(function(){
                       scope.$emit("close-refundFuc");  
                    },5000); */
                }else{
                    scope.$emit("close-refund");
                    scope.reviewErrorMsg = d.failed_msg;
                    scope.$emit("error-review"); 
                }
           }).error(function(d){
                scope.refundSubmit = false;
                scope.$emit("close-refund");
                scope.reviewErrorMsg = d.failed_msg;
                scope.$emit("error-review");
           }); 
        }
        //校验表单
        if(vaildate){
            var ajaxUrl = orderRefund.replace("0",scope.oid);
            var data = {
                "customer_phone": scope.refundForm.phone,
                "money": scope.refundForm.refundMoney.id == 2 ? scope.refundForm.money.toString() : scope.totalmoney.toString(),
                "refund_reason": scope.refundForm.reason.id == 4 ? scope.refundForm.otherReason : scope.refundForm.reason.name ,
                "image_key":scope.imgKey || ''
            };
            ajaxRefund(ajaxUrl,data);
        }
    }

}])

app.directive("phoneIcon",function(){
    return{
        restrict:'A',
        link:function(scope,elem,attrs){
            elem.on('click',function(){
                var oid = attrs["oid"];
                var phones= attrs["phone"];
                scope.showContact = true;
                scope.phones="餐厅电话："+phones;
                scope.orderOids="订单编号："+oid;
                scope.$apply();
            });
        }
    }
});
var orderBody = document.getElementById('orderBody'),
    orderBodyOffsetHeight = orderBody && orderBody.offsetHeight +20;
app.directive("orderNumber",["commonApi","$http","$timeout",function(commonApi,http,timeout){
    return{
        restrict:'C',
        link:function(scope,elem){
            var orderId=elem.attr('orderId');
            var next=elem.next();
            var ajaxReg=true;
            var ajaxFunc=function(aDiv,close){
                    scope.orderStatus[orderId+"_error"]=false;
                   if(!elem.attr('orderId')){
                        calcMarginTop(aDiv);
                        return false;
                    }
                    if(ajaxReg){
                       ajaxReg=false;
                       http.get("/ajax/order_detail/"+orderId+"/").success(function (d) {
                            if (d && d.code == 0) {
                                scope.order[orderId]=d;
                                scope.orderStatus[orderId]=true;
                                elem.removeAttr('orderId');
                                timeout(function(){                               
                                    if(close){
                                        calcMarginTop(aDiv,close);  
                                    }else{
                                        calcMarginTop(aDiv);
                                    }  
                                },10);
                            } else {
                               ajaxReg=true;
                               scope.orderStatus[orderId+"_error"]=true;
                            }
                        }).error(function (d) {
                            scope.orderStatus[orderId+"_error"]=true;
                           ajaxReg=true;
                        });
                    }
                }

            var oElem = elem[0],
                elemOffsetHeight = oElem.offsetTop + oElem.offsetParent.offsetTop ,
                //isFirstHover = true,
                calcMarginTop = function(aDiv,close){
                    //if (isFirstHover) {
                        var aDivHeight = aDiv[0].offsetHeight - 25 ,
                            subNum = aDivHeight + elemOffsetHeight - orderBodyOffsetHeight;
                        if(subNum > 0){
                            aDiv.children()[0].style.marginTop = subNum * -1 + 'px';
                            if(close){
                                close.style.top = (subNum + 8) * -1 + 'px';
                            }
                        }
                        //isFirstHover = false;
                    //}
                }
            if(!commonApi.isMobile.any()){
                elem.parent().on("mouseover",function(e){
                        next.css("display","block");
                        ajaxFunc(next);
                }).on("mouseout",function(e){
                    var e = window.event || e;
                    var target_element = e.toElement || e.relatedTarget;
                    if (document.all) {
                        if (!this.contains(target_element)) {
                            elem.next().css("display","none");
                        }
                    } else {
                        var res = this.compareDocumentPosition(target_element);
                        if (!( res == 20 || res == 0)) {
                           next.css("display","none");
                        }
                    }
                })
            }
        }
    }
}])
app.directive("restaurantItem",["commonApi","$window",'$http',function(commonApi,window,http){
    return{
        restrict:'C',
        link: function(scope,elem){
            var favoriteError = function(msg){
                    scope.errorMsg = msg;
                    scope.$emit('favorite-error');
                },
                removeFavorite = function(elem){
                    if(elem.parent().children().length == 1){
                        var pageArr = window.location.search.match(/page=(\d+)/),href = window.location.href;
                        if(angular.isArray(pageArr) && pageArr[1] && pageArr[1] > 1 ){
                            var reg = new RegExp("page=" + pageArr[1]);
                            window.location.href = href.replace(reg,"page=" + (parseInt(pageArr[1]) -1));
                        }else{
                            elem.parent().replaceWith('<div class="favorite-empty">暂无您收藏的餐厅</div>');
                        }
                    }
                    elem.remove();
                },
                url = '';
            elem.on('click',function(e){
                var oTarget = e.target, rid = angular.element(oTarget).attr('data-rid');
                if(oTarget.nodeName == 'DIV' && oTarget.className.indexOf('close-favorite') != -1 && rid){
                    url = favoriteUrl.replace('/0/','/' + rid + '/');
                    http['delete'](url).success(function(d){
                        if(d.status == 'ok'){
                            elem.addClass("restaurant-item-close");
                            if(commonApi.browser.chrome){
                                setTimeout(function(){
                                    removeFavorite(elem);
                                },1400);
                            }else{
                                removeFavorite(elem);
                            }
                        }else{
                            favoriteError(d.failed_msg);
                        }
                    }).error(function(){
                        favoriteError('未知错误，请稍后在重试。');
                    })
                }else{
                    var $div = elem.children()[0] ,
                    oA = angular.element($div).children()[0];
                    window.open(oA.href, "_blank");
                }
                e.preventDefault();
                e.returnValue = false
            })
        }
    };
}]);
app.directive("bigStar",function(commonApi){
    return{
        restrict:'C',
        link:function(scope,elem,attrs){
            var data=[{
                "num":"很不满意",
                "des":"很不满意，餐厅食品口味差，服务也不好，很糟糕的一次订餐经历。"
            },{
                "num":"不满意",
                "des":"不满意，餐厅食品口味一般，服务不太好。"
            },{
                "num":"一般",
                "des":"一般，餐厅食品口味一般，服务也一般，没有想象中好。"
            },{
                "num":"满意",
                "des":"满意，餐厅食品口味不错，服务也好，下次还会光顾。"
            },{
                "num":"非常满意",
                "des":"非常满意，餐厅食品口味非常不错，服务也好，下次一定还来。"
            }];
            scope.reviewData={};
            if(!commonApi.isMobile.any()){
                elem.on('mouseover',function(e){
                    scope.reviewObj.totalReview=null;
                    var e=e||window.event;
                    var oTarget = e.target||e.srcElement;
                    var _this=angular.element(oTarget);
                    var index=_this.attr("bigstarindex");
                    var top=elem[0].offsetTop+26;
                    var left=elem[0].offsetLeft;
                    var leftLen=left+(parseInt(index)+1)*23-104;
                    scope.bigStyle={
                        "left":leftLen+"px",
                        "top":top+"px"
                    };
                    scope.reviewData=data[index];
                    scope.showBig=true;
                    scope.$apply();
                });
                elem.on('mouseout',function(e){
                    scope.showBig=false;
                    scope.reviewObj.totalReview=scope.reviewIndexObj.totalReview;
                    scope.reviewData={};
                    scope.$apply();
                });
            }
            elem.on('click',function(e){
                var e=e||window.event;
                var oTarget = e.target||e.srcElement;
                var _this=angular.element(oTarget);
                var index=_this.attr("bigstarindex");
                scope.reviewObj.totalReview=scope.reviewIndexObj.totalReview=parseInt(index)+1;
                scope.isReviewError = false;
                scope.$apply();
            });
        }
    }
});
app.directive("smallStar",function(commonApi){
    return{
        restrict:'C',
        link:function(scope,elem,attrs){
            var data=["很不满意","不满意","一般","满意","非常满意"];
            scope.reviewSmallData="";
            var reviewType=elem.attr("reviewType");
            if(!commonApi.isMobile.any()){
                elem.on('mouseover',function(e){
                    scope.reviewObj[reviewType]=null;
                    var showSmallObj=document.getElementById("show-samll");
                    var e=e||window.event;
                    var oTarget = e.target||e.srcElement;
                    var _this=angular.element(oTarget);
                    var index=_this.attr("bigstarindex");
                    var top=elem[0].offsetTop+22;
                    angular.element(showSmallObj).removeClass("show-samll0 show-samll1 show-samll2 show-samll3 show-samll4");
                    angular.element(showSmallObj).addClass("show-samll"+index);
                    scope.samllStyle={
                        "top":top+"px"
                    };
                    scope.reviewSmallData=data[index];
                    scope.showSmall=true;
                    scope.$apply();
                });
                elem.on('mouseout',function(e){
                    scope.showSmall=false;
                    scope.reviewSmallData="";
                    scope.reviewObj[reviewType]=scope.reviewIndexObj[reviewType];
                    scope.$apply();
                });
            }
            elem.on('click',function(e){
                var e=e||window.event;
                var oTarget = e.target||e.srcElement;
                var _this=angular.element(oTarget);
                var index=_this.attr("bigstarindex");
                scope.reviewObj[reviewType]=scope.reviewIndexObj[reviewType]=parseInt(index)+1;
                scope.$apply();
            });
        }
    }
});
