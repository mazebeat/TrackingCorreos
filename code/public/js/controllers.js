'use strict';

/* homeControlleruserFactory */
trackingCorreos.controller('homeController', ['$scope', '$http', '$window', 'rootFactory', 'apiFactory', 'storageService', function ($scope, $http, $window, rootFactory, apiFactory, storageService) {
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
                        .success(function (data) {
                            if (data.ok) {
                                $scope.message = data.message;
                                apiFactory.notify('Tracking de Correos', $scope.message, 'success');
                                if (storageService.getItem('firstTime') != true) {
                                    storageService.create('firstTime', true);
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
                        .error(function (data) {
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
trackingCorreos.controller('adminController', ['$scope', '$http', '$window', 'rootFactory', 'apiFactory', 'chartService', 'storageService', function ($scope, $http, $window, rootFactory, apiFactory, chartService, storageService) {
    $scope.months = $('#months').spinner('value');
    var btn1Pdf = $('#exportG1Pdf');
    var btn1Jpg = $('#exportG1Jpg');
    var btn2Pdf = $('#exportG2Pdf');
    var btn2Jpg = $('#exportG2Jpg');

    $http.get(rootFactory.root + '/dashboard/authUser')
        .success(function (data) {
            $scope.user = data;

            var date = new Date();
            var desde = new Date(date.getFullYear(), parseInt(date.getMonth() - $scope.months), 1);
            var hasta = new Date(date.getFullYear(), parseInt(date.getMonth() + 1), 0);
            desde = apiFactory.formatDates(desde);
            hasta = apiFactory.formatDates(hasta);

            $scope.negocios = $scope.user.negocios.split(',');
            $scope.negocio = $scope.negocios[0];

            var params = {negocio: $scope.negocio, fechaDesde: desde, fechaHasta: hasta};

            apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
            apiFactory.post(params)
                .then(function (response) {
                    if (response.ok) {
                        var json = response.data;
                        json = JSON.parse('[' + json.substr(0, json.length - 1) + ']');
                        var dataPie = chartService.dashboardPieChart(json);
                        //console.log(dataPie);
                        chartService.donut(chartdiv1, 'chartdiv1', dataPie, 'total', 'campana', 'campana', null);
                        /* Botones para exportar */
                        btn1Pdf.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv1, 'pdf', 'Grafico_por_mes');
                        });
                        btn1Jpg.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv1, 'jpg', 'Grafico_por_mes');
                        });
                        var dataSerial = chartService.dashboardSerialChart(json);
                        //console.log(dataSerial);
                        chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
                        /* Botones para exportar */
                        btn2Pdf.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv2, 'pdf', 'Grafico_por_rango');
                        });
                        btn2Jpg.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv2, 'jpg', 'Grafico_por_rango');
                        });
                        searchButton.stop();
                    }
                    else {
                        apiFactory.notify('Tracking de Correos', response.message);
                    }
                })
                .catch(function (errorMsg) {
                    apiFactory.notify('Atención!', errorMsg);
                });
        });

    $scope.changeChart = function () {
        var date = new Date();
        var desde = new Date(date.getFullYear(), parseInt(date.getMonth() - $scope.months), 1);
        var hasta = new Date(date.getFullYear(), parseInt(date.getMonth() + 1), 0);
        desde = apiFactory.formatDates(desde);
        hasta = apiFactory.formatDates(hasta);

        var params = {negocio: $scope.negocio, fechaDesde: desde, fechaHasta: hasta};
        apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    var json = response.data;
                    json = JSON.parse('[' + json.substr(0, json.length - 1) + ']');
                    var dataPie = chartService.dashboardPieChart(json);
                    //console.log(dataPie);
                    chartService.donut(chartdiv1, 'chartdiv1', dataPie, 'total', 'campana', 'campana', null);
                    /* Botones para exportar */
                    btn1Pdf.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv1, 'pdf', 'Grafico_por_mes');
                    });
                    btn1Jpg.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv1, 'jpg', 'Grafico_por_mes');
                    });
                    var dataSerial = chartService.dashboardSerialChart(json);
                    //console.log(dataSerial);
                    chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
                    /* Botones para exportar */
                    btn2Pdf.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'pdf', 'Grafico_por_rango');
                    });
                    btn2Jpg.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'jpg', 'Grafico_por_rango');
                    });
                    searchButton.stop();
                    chartdiv1.validateData();
                    chartdiv2.dataProvider.cleanChart();
                    chartdiv2.validateData();
                }
                else {
                    apiFactory.notify('Tracking de Correos', response.message);
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
            });
    };

    //var data = [
    //    {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 1,
    //        "qelectronicos": 1
    //    },
    //    {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 2,
    //        "qelectronicos": 2
    //    },
    //    {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 3,
    //        "qelectronicos": 8
    //    }, {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 4,
    //        "qelectronicos": 2
    //    }
    //    , {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 5,
    //        "qelectronicos": 6
    //    }
    //    , {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 6,
    //        "qelectronicos": 3
    //    }
    //
    //];
    //var data2 = [
    //    {
    //        "ano": 2014,
    //        "nombreCampana": "CampanaPrueba",
    //        "ciclo": "1",
    //        "fechaEnvio": "1969-12-31T21:00:01.234",
    //        "id": 1,
    //        "mes": 6,
    //        "qelectronicos": 3
    //    }
    //];

    //var dataPie = chartService.dashboardPieChart(data2);
    //chartService.donut(chartdiv1, 'chartdiv1', dataPie, 'total', 'campana', 'campana', null);
    //var dataSerial = chartService.dashboardSerialChart(data);
    //chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
    //

    $scope.submit = function () {
        searchButton.start();

        var date = new Date();
        var desde = new Date(date.getFullYear(), parseInt(date.getMonth() - $scope.months), 1);
        var hasta = new Date(date.getFullYear(), parseInt(date.getMonth() + 1), 0);
        desde = apiFactory.formatDates(desde);
        hasta = apiFactory.formatDates(hasta);

        //$scope.negocio = apiFactory.splitString($scope.user.negocios);
        $scope.negocios = $scope.user.negocios.split(',');

        var params = {negocio: $scope.negocio, fechaDesde: desde, fechaHasta: hasta};

        apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    /* Obtiene data */
                    var json = response.data;
                    json = json.substr(0, json.length - 1);
                    json = JSON.parse('[' + json + ']');
                    /* Sentencia el nmuevo grafico */
                    var chartdiv2 = new AmCharts.AmSerialChart();
                    var dataSerial = chartService.dashboardSerialChart(json);
                    /* Crea el nuevo grafico */
                    chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
                    /* Botones para exportar */
                    btn2Pdf.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'pdf', 'Grafico_por_rango');
                    });
                    btn2Jpg.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'jpg', 'Grafico_por_rango');
                    });
                    /* Notifica nuevo grafico */
                    apiFactory.notify('Tracking de Correos', 'Gráfico actualizado');
                    searchButton.stop();
                }
                else {
                    apiFactory.notify('Tracking de Correos', response.message);
                    searchButton.stop();
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                searchButton.stop();
            });
    };


}]);

/* trackingController */
trackingCorreos.controller('trackingController', ['$scope', '$http', '$q', 'storageService', 'rootFactory', 'apiFactory', 'chartService', function ($scope, $http, $q, storageService, rootFactory, apiFactory, chartService) {
    $scope.tracking = {};
    $scope.campanas = [];
    $scope.user = {};
    $scope.message = '';
    $scope.result = [];
    $scope.loading = false;

    if (storageService.isSupported) {
        $scope.data = storageService.getItem('searchTracking');
        storageService.removeItem('searchTracking');
    } else {
        $http.get(rootFactory.root + '/dashboard/getSearchTracking').
            success(function (data) {
                console.log('NonSupported');
                console.log(data);
                $scope.data = data;
            });
    }

    if ($scope.data != null) {
        $scope.tracking = {campana: $scope.data.campana, fecha: $scope.data.date};
        apiFactory.url('GestionMailWS/Resumen/ConsultaResumen');
        var fechas = $scope.data.date.split("-");
        var request = {
            ano: parseInt(fechas[0]),
            mes: parseInt(fechas[1]),
            campana: $scope.data.campana
        };
        apiFactory.post(request)
            .then(function (response) {
                if (response.ok) {
                    var deferred = $q.defer();
                    apiFactory.notify('Tracking de Correos', 'Listo!');
                    var json = JSON.parse('[' + JSON.stringify(response.data) + ']');
                    var datos = chartService.trackingPieChart(json);
                    chartService.donut(chart, 'resumenTracking', datos, 'value', 'title', 'title', '[[title]]<br>[[value]]</b>([[percents]])');
                    $scope.result = json;
                } else {
                    /* Cambiar messsage por message */
                    $scope.message = response.messsage;
                    apiFactory.notify('Tracking de Correos', $scope.message);
                    $scope.result = [];
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                $scope.result = [];
            });
    }

    $http.get(rootFactory.root + '/dashboard/authUser')
        .success(function (data) {
            console.log(data);
            $scope.user = data;
            $scope.negocios = $scope.user.negocios.split(',');
        });

    $scope.loadCamps = function () {
        if ($scope.tracking.negocio) {
            apiFactory.url('GestionMailWS/Campana/ConsultaCampana');
            apiFactory.post({negocio: $scope.tracking.negocio})
                .then(function (response) {
                    if (response.ok) {
                        var camps = response.data.substr(0, response.data.length - 1);
                        $scope.setCampañas(JSON.parse('[' + camps + ']'));
                        apiFactory.notify('Tracking de Correos', 'Campañas cargadas');
                    } else {
                        $scope.message = response.message;
                        apiFactory.notify('Tracking de Correos', $scope.message);
                    }
                });
        }
    };

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
                if (response.ok) {
                    var deferred = $q.defer();
                    apiFactory.notify('Tracking de Correos', 'Listo!');
                    var json = JSON.parse('[' + JSON.stringify(response.data) + ']');
                    var datos = chartService.trackingPieChart(json);
                    chartService.donut(chart, 'resumenTracking', datos, 'value', 'title', 'title', '[[title]]<br>[[value]]</b>([[percents]])');
                    $scope.result = json;
                    trackingButton.stop();
                } else {
                    /* Cambiar message por message */
                    $scope.message = response.message;
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

    $scope.exportData = function () {
        apiFactory.exportDataToTable('exportDetail', 'Tracking');
    };

}]);
