
var module = (function(){
    var scope = {},
        http = {},
        ajaxData = {},
        cache = {},
        error = function(msg){
            scope.errorMsg = msg;
            scope.errorShow = true;
        }
    var initUserAddress = function(){
        var key = cache.buildCacheKey('delivery-address');
        ajaxData.addAllDeliveryAddress(ajax_add_all_delivery_addresses,key).then(
            function(d){
                scope.userAddressList = d;
            },
            function(){
                scope.userAddressList = userAddress
            }
        )
        scope.addUserAddress = function(){
            scope.userAddressForm.submit = true;
            if(scope.userAddressForm.$valid){
                scope.userAddressForm.submit = false;
                http.post(ajax_add_delivery_address,scope.userAddress)
                    .success(function(d){
                        if(d.status == 'ok'){
                            scope.userAddress.id = d.id;
                            scope.userAddressList.push(scope.userAddress);
                            scope.userAddressForm.submit = false;
                            scope.userAddress = {}
                        }else{
                            error(d.failed_msg)
                        }
                    })
                    .error(function(){
                        error('未知错误，请稍后再试。')
                    })
            }
        }
        scope.deleteUserAddress = function(index){
            scope.currentSelectedAddress = angular.copy(scope.userAddressList[index]);
            scope.currentSelectedAddress["index"] = index;
            scope.confirmMsg = '确认要删除吗？'
            scope.confirm = true;
        }
        scope.cancelConfirm = function(){
            scope.confirm = false;
        }
        scope.submitConfirm = function(){
            var url = ajax_update_delivery_address.replace('/0/','/' + scope.currentSelectedAddress.id + '/');
            http['delete'](url)
                .success(function(d){
                    if(d.status == 'ok'){
                        scope.userAddressList.splice(scope.currentSelectedAddress.index,1);
                    }else{
                        scope.showError = true;
                        scope.errorMsg = d.failed_msg;
                    }
                    scope.confirm = false;
                })
                .error(function(){
                    scope.confirm = false;
                    scope.showError = true;
                    scope.errorMsg = '未知错误，请稍后再试。';
                })
        }

        scope.editUserAddress = function(index){
            scope.currentSelectedAddress = angular.copy(scope.userAddressList[index]);
            scope.currentSelectedAddress["index"] = index;

            scope.showEditUserAddress = true;
            scope.$broadcast('update-user-address');
        }
        scope.cancelUserAddress = function(){
            scope.showEditUserAddress = false;
        }
        scope.$on("update-submit-success",function(e){
            var updateObj = e.targetScope.editUserAddress;
            scope.userAddressList[updateObj.index] = updateObj;
            scope.showEditUserAddress = false;
        })
        scope.$on("cancel-user-address",function(e){
            scope.showEditUserAddress = false;
        })
        scope.$on('request-error',function(e){
            scope.errorShow = true;
            scope.errorMsg = e.targetScope.errorMsg;
        })
    }
    return {
        init : function(_scope,_http,_ajaxData,_cache){
            scope = _scope;
            http = _http;
            ajaxData = _ajaxData;
            cache = _cache;
        },
        userAddress : initUserAddress
    }
})()
app.controller('bodyCtrl',["$scope",'$http','ajaxData','cache',function(scope,http,ajaxData,cache){
    module.init(scope,http,ajaxData,cache);
    module.userAddress();
}])
app.controller("userAddressCtrl",["$scope","$http",function(scope,http){
    var isAdd = true , initForm = function(){scope.userAddressForm.submit = false;}
    scope.$on("update-user-address",function(e){
        var selectedObj = e.targetScope.currentSelectedAddress;
        scope.editUserAddress = selectedObj;
    })

    scope.submitUserAddress = function(){
        scope.editUserAddressForm.submit = true;
        if(scope.editUserAddressForm.$valid){
            scope.editUserAddressForm.submit = false;
            var url = ajax_update_delivery_address.replace('/0/','/' + scope.editUserAddress.id + '/');
            http.post(url,scope.editUserAddress)
                .success(function(d){
                    if(d.status == 'ok'){
                        scope.$emit("update-submit-success");
                    }else{
                        scope.errorMsg = d.failed_msg;
                        scope.$emit("request-error");
                    }
                })
                .error(function(){
                    scope.errorMsg = '未知错误，请稍后再试。';
                    scope.$emit("request-error");
                })
        }
    }
    scope.cancelUserAddress = function(){
        scope.$emit("cancel-user-address");
    }
}]);