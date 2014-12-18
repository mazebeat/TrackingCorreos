'use strict';

// HomeController
trackingCorreos.controller('homeController', ['$scope', '$http', '$window', 'rootFactory', 'apiFactory', function ($scope, $http, $window, rootFactory, apiFactory) {
    $scope.user = {};
    $scope.message = '';

    $scope.submit = function () {
        var url = apiFactory.restApi + 'GestionMailWS/login/validauser/';
        var data = $.param($scope.user);

        $http({
            url: url,
            method: "POST",
            data: data,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded;"
            }
        }).success(function (data, status, headers, config) {
            if (data.ok) {
                $scope.message = '';
                $http.post('login', data)
                    .success(function (data, status, headers, config) {
                        if (data.ok) {
                            $window.location.href = rootFactory.root + '/dashboard';
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $window.location.href = rootFactory.root+'/';
                    });
            } else {
                $scope.message = data.messsage;
            }
        }).error(function (data, status, headers, config) {
            $window.location.href = rootFactory.root+'/';
        });
    };
}]);
