'use strict';

// homeControlleruserFactory
trackingCorreos.controller('homeController', ['$scope', '$http', '$window', 'rootFactory', 'apiFactory', '$cookies', '$cookieStore', function ($scope, $http, $window, rootFactory, apiFactory, $cookies, $cookieStore) {
    $scope.user = {};
    $scope.message = '';
    $scope.loading = false;

    $scope.submit = function () {
        $scope.loading = true;
        loginButton.start();
        apiFactory.url('GestionMailWS/login/validauser/');
        apiFactory.post($scope.user)
            .then(function (response) {
                if (response.ok) {
                    $scope.message = '';
                    $http.post('login', response.data)
                        .success(function (data, status, headers, config) {
                            if (data.ok) {
                                $scope.message = data.message;
                                apiFactory.notify('Tracking de Correos', $scope.message, 'success');
                                if ($cookieStore.get("firstTime") != 'true') {
                                    $cookieStore.put("firstTime", 'true');
                                }
                                $window.location.href = rootFactory.root + '/dashboard';
                                $scope.user = {};
                                loginButton.stop();
                            } else {
                                $scope.message = data.message;
                                apiFactory.notify('Tracking de Correos', $scope.message);
                                $scope.user = {};
                                loginButton.stop();
                            }
                        })
                        .error(function (data, status, headers, config) {
                            loginButton.stop();
                            apiFactory.notify('Tracking de Correos', data);
                            $window.location.href = rootFactory.root + '/';
                            $scope.user = {};
                            loginButton.stop();
                        });
                } else {
                    $scope.message = response.message;
                    apiFactory.notify('Atención!', $scope.message);
                    $scope.user = {};
                    loginButton.stop();
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                $scope.user = {};
                loginButton.stop();
            });
    };
}]);

// adminController
trackingCorreos.controller('adminController', ['$scope', '$http', '$window', 'rootFactory', 'apiFactory', function ($scope, $http, $window, rootFactory, apiFactory) {
    //console.log(apiFactory);
}]);

// trackingController
trackingCorreos.controller('trackingController', ['$scope', '$http', '$q', 'rootFactory', 'apiFactory', function ($scope, $http, $q, rootFactory, apiFactory) {
    $scope.tracking = {};
    $scope.campanas = [];
    $scope.user = {};
    $scope.message = '';
    $scope.result = [];
    $scope.loading = false;


    if ($scope.campanas.length == 0) {
        $http.get(rootFactory.root + '/dashboard/authUser')
            .success(function (data) {
                $scope.user = data;
                apiFactory.url('GestionMailWS/Resumen/ConsultaCampana');
                apiFactory.post({negocio: $scope.user.negocio})
                    .then(function (response) {
                        if (response.ok) {
                            var camps = response.data;
                            camps = camps.substr(0, camps.length - 1);
                            $scope.setCampañas(JSON.parse('[' + camps + ']'));
                            apiFactory.notify('Tracking de Correos', 'Campañas cargadas');

                        } else {
                            $scope.message = response.messsage;
                            apiFactory.notify('Tracking de Correos', $scope.message);
                        }
                    });
            });
    }

    $scope.setCampañas = function (campanas) {
        $scope.campanas = campanas;
    };

    $scope.submit = function () {
        trackingButton.start();
        apiFactory.url('GestionMailWS/Resumen/ConsultaResumen');
        var fechas = $scope.tracking.fecha.split("-");
        var request = {
            ano: parseInt(fechas[0]),
            mes: parseInt(fechas[1]),
            campana: $scope.tracking.campana
        };
        apiFactory.post(request)
            .then(function (response) {
                console.log(response);
                if (response.ok) {
                    $scope.result = JSON.parse('[' + JSON.stringify(response.data) + ']');
                    apiFactory.notify('Tracking de Correos', 'Procesando resultados');
                    trackingButton.stop();
                } else {
                    // Cambiar messsage por message
                    $scope.message = response.messsage;
                    apiFactory.notify('Tracking de Correos', $scope.message);
                    trackingButton.stop();
                    $scope.result = [];
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                trackingButton.stop();
                $scope.result = [];
            });
    };
}]);


