'use strict';

// HomeController
trackingCorreos.controller('homeController', ['$scope', '$http', '$window', 'rootFactory', 'apiService', function ($scope, $http, $window, rootFactory, apiService) {
    $scope.user = {};
    $scope.message = '';
    $scope.loading = false;

    $scope.submit = function () {
        $scope.loading = true;
        loginButton.start();
        apiService.url('GestionMailWS/login/validauser/');
        apiService.post($scope.user)
            .then(function (response) {
                if (response.ok) {
                    $scope.message = '';
                    $http.post('login', response.data)
                        .success(function (data, status, headers, config) {
                            if (data.ok) {
                                $window.location.href = rootFactory.root + '/dashboard';
                            }
                        })
                        .error(function (data, status, headers, config) {
                            loginButton.start();
                            $window.location.href = rootFactory.root + '/';
                        });
                } else {
                    $scope.message = response.messsage;
                    loginButton.stop();
                }
            });
    };
}]);

// AdminController
trackingCorreos.controller('adminController', ['$scope', '$http', '$window', 'rootFactory', 'apiService', function ($scope, $http, $window, rootFactory, apiService) {
    $scope.graficos = {};
    $scope.message = '';

    $scope.submit = function () {
        apiService.url('GestionMailWS/login/validauser/');
        apiService.post($scope.graficos)
            .then(function (response) {
                if (response.ok) {
                    $scope.message = '';
                    console.log(response.data);
                } else {
                    $scope.message = response.messsage;
                }
            });
    };
}]);
