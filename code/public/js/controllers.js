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
                                $scope.message = data.message;
                                if (!$.cookie('firstTime')) {
                                    $.cookie('firstTime', true, {expires: 20, path: '/'});
                                }
                                $(function () {
                                    var notice = (new PNotify({
                                        type: 'notice',
                                        title: 'Tracking de Correos',
                                        text: $scope.message + '\nIniciando aplicación...',
                                        desktop: {
                                            desktop: true
                                        }
                                    }));
                                });
                                $window.location.href = rootFactory.root + '/dashboard';
                                loginButton.stop();
                            }

                            $scope.message = data.message;
                            $(function () {
                                var notice = (new PNotify({
                                    type: 'notice',
                                    title: 'Tracking de Correos',
                                    text: $scope.message,
                                    desktop: {
                                        desktop: true
                                    }
                                }));
                            });
                            loginButton.stop();
                        })
                        .error(function (data, status, headers, config) {
                            loginButton.stop();
                            console.log(data);
                            $(function () {
                                var notice = (new PNotify({
                                    type: 'notice',
                                    title: 'Tracking de Correos',
                                    text: data,
                                    desktop: {
                                        desktop: true
                                    }
                                }));
                            });
                            $window.location.href = rootFactory.root + '/';
                            loginButton.stop();
                        });
                } else {
                    $scope.message = response.messsage;
                    new PNotify({
                        type: 'notice',
                        title: 'Atención!',
                        text: $scope.message,
                        desktop: {
                            desktop: true
                        }
                    });
                    loginButton.stop();
                }
            })
            .catch(function (errorMsg) {
                console.log(errorMsg);
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
