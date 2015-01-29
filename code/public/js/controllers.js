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

            var params = {
                negocio: $scope.negocio,
                fechaDesde: desde,
                fechaHasta: hasta,
                nEmpresa: $scope.user.empresa
            };
            apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
            apiFactory.post(params)
                .then(function (response) {
                    if (response.ok) {
                        var json = response.data;
                        json = JSON.parse('[' + json.substr(0, json.length - 1) + ']');

                        var dataPie = chartService.dashboardPieChart(json);
                        chartService.donut(chartdiv1, 'chartdiv1', dataPie, 'total', 'campana', 'campana', null);
                        btn1Pdf.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv1, 'pdf', 'Grafico_por_mes');
                        });
                        btn1Jpg.click(function (event) {
                            event.preventDefault();
                            chartService.exportGraphToFormat(chartdiv1, 'jpg', 'Grafico_por_mes');
                        });

                        var dataSerial = chartService.dashboardSerialChart(json);
                        chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
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
        var desde = new Date(date.getFullYear(), parseInt(date.getMonth() - $('#months').spinner('value')), 1);
        var hasta = new Date(date.getFullYear(), parseInt(date.getMonth() + 1), 0);
        desde = apiFactory.formatDates(desde);
        hasta = apiFactory.formatDates(hasta);

        var params = {
            negocio: $scope.negocio,
            fechaDesde: desde,
            fechaHasta: hasta,
            nEmpresa: $scope.user.empresa
        };
        apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    var json = response.data;
                    json = JSON.parse('[' + json.substr(0, json.length - 1) + ']');

                    var dataPie = chartService.dashboardPieChart(json);
                    var chartdiv1 = new AmCharts.AmPieChart();
                    chartService.donut(chartdiv1, 'chartdiv1', dataPie, 'total', 'campana', 'campana', null);
                    btn1Pdf.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv1, 'pdf', 'Grafico_por_mes');
                    });
                    btn1Jpg.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv1, 'jpg', 'Grafico_por_mes');
                    });

                    var dataSerial = chartService.dashboardSerialChart(json);
                    chartdiv2 = new AmCharts.AmSerialChart();
                    chartService.semestral(chartdiv2, 'chartdiv2', dataSerial, 'total', 'fecha', 'campana');
                    btn2Pdf.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'pdf', 'Grafico_por_rango');
                    });
                    btn2Jpg.click(function (event) {
                        event.preventDefault();
                        chartService.exportGraphToFormat(chartdiv2, 'jpg', 'Grafico_por_rango');
                    });

                    searchButton.stop();
                    chartdiv1.validateNow();
                    chartdiv2.validateNow();
                }
                else {
                    apiFactory.notify('Tracking de Correos', response.message);
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
            });
    };

    $scope.submit = function () {
        searchButton.start();

        var date = new Date();
        var desde = new Date(date.getFullYear(), parseInt(date.getMonth() - $('#months').spinner('value')), 1);
        var hasta = new Date(date.getFullYear(), parseInt(date.getMonth() + 1), 0);
        desde = apiFactory.formatDates(desde);
        hasta = apiFactory.formatDates(hasta);

        //$scope.negocio = apiFactory.splitString($scope.user.negocios);
        $scope.negocios = $scope.user.negocios.split(',');

        var params = {
            nNegocio: $scope.negocio,
            fechaDesde: desde,
            fechaHasta: hasta,
            nEmpresa: $scope.user.empresa,
        };
        apiFactory.url('GestionMailWS/Resumen/ConsultaFechaDesdeHasta');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    /* Obtiene data */
                    var json = response.data;
                    json = json.substr(0, json.length - 1);
                    json = JSON.parse('[' + json + ']');
                    /* Sentencia el nuevo grafico */
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
            then(function (data) {
                console.info('NonSupported');
                $scope.data = data.data;
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                trackingButton.stop();
                $scope.result = [];
            });
    }

    $http.get(rootFactory.root + '/dashboard/authUser')
        .then(function (data) {
            $scope.user = data.data;
            $scope.negocios = $scope.user.negocios.split(',');

            if ($scope.data != null) {
                $scope.tracking = {
                    campana: $scope.data.campana,
                    fecha: $scope.data.date,
                    negocio: $scope.data.negocio
                };

                var fechas = $scope.data.date.split("-");
                var request = {
                    ano: fechas[0],
                    mes: fechas[1],
                    campana: $scope.tracking.campana,
                    nEmpresa: $scope.user.empresa,
                    nNegocio: $scope.tracking.negocio
                };
                apiFactory.url('GestionMailWS/Resumen/ConsultaResumen');
                apiFactory.post(request)
                    .then(function (response) {
                        if (response.ok) {
                            $scope.loadCamps();
                            var json = JSON.parse('[' + response.data.substr(0, response.data.length - 1) + ']');
                            var datos = chartService.trackingPieChartGlobal(json);
                            chartService.trackingGlobal(chart, 'resumenTracking', datos, 'qEmitidos', 'campana', 'campana', '[[title]]<br>[[value]]</b>([[percents]])');
                            chart.addListener("clickSlice", eventClick2);
                            chart.validateNow();
                            chart.animateAgain();
                            $scope.result = json;

                            var fechas = $scope.tracking.fecha.split("-")
                            var desde = new Date(fechas[0], parseInt(fechas[1] - 1), 1);
                            var hasta = new Date(fechas[0], parseInt(fechas[1]), 0);

                            var params = {
                                fechaDesde: apiFactory.formatDates(desde).toString(),
                                fechaHasta: apiFactory.formatDates(hasta).toString(),
                                idcampana: json[0].idCampana,
                            };
                        } else {
                            $scope.message = response.message;
                            $scope.result = [];
                        }
                    })
                    .catch(function (errorMsg) {
                        apiFactory.notify('Atención!', errorMsg);
                        $scope.result = [];
                    });
            }
        })
        .catch(function (errorMsg) {
            apiFactory.notify('Atención!', errorMsg);
            trackingButton.stop();
            $scope.result = [];
        });

    $scope.loadCamps = function () {
        if ($scope.tracking.negocio) {
            apiFactory.url('GestionMailWS/Campana/ConsultaCampana');
            apiFactory.post({negocio: $scope.tracking.negocio, nEmpresa: $scope.user.empresa})
                .then(function (response) {
                    if (response.ok) {
                        var camps = response.data.substr(0, response.data.length - 1);
                        $scope.setCampañas(JSON.parse('[' + camps + ']'));
                    } else {
                        $scope.message = response.message;
                        apiFactory.notify('Tracking de Correos', $scope.message);
                    }
                })
                .catch(function (errorMsg) {
                    apiFactory.notify('Atención!', errorMsg);
                    trackingButton.stop();
                    $scope.result = [];
                });
        }
    };

    $scope.setCampañas = function (campanas) {
        $scope.campanas = campanas;
    };

    $scope.submit = function () {
        trackingButton.start();
        var fechas = $scope.tracking.fecha.split("-");
        var params = {
            ano: fechas[0],
            mes: fechas[1],
            campana: $scope.tracking.campana,
            nEmpresa: $scope.user.empresa,
            nNegocio: $scope.tracking.negocio
        };
        apiFactory.url('GestionMailWS/Resumen/ConsultaResumen');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    var json = JSON.parse('[' + response.data.substr(0, response.data.length - 1) + ']');
                    var datos = chartService.trackingPieChartGlobal(json);

                    var chart = new AmCharts.AmPieChart();
                    chartService.trackingGlobal(chart, 'resumenTracking', datos, 'qEmitidos', 'campana', 'campana', '[[title]]<br>[[value]]</b>([[percents]])');
                    chart.addListener("clickSlice", eventClick2);
                    chart.validateNow();
                    chart.animateAgain();
                    $scope.result = json;
                } else {
                    $scope.message = response.message;
                    apiFactory.notify('Tracking de Correos', $scope.message);
                    trackingButton.stop();
                    $scope.result = [];
                }
            })
            .then(function () {

            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                trackingButton.stop();
                $scope.result = [];
            });
    };

    function eventClick2(event) {
        var fechas = $scope.tracking.fecha.split("-");
        var params = {
            ano: fechas[0],
            mes: fechas[1],
            campana: $scope.tracking.campana,
            nEmpresa: $scope.user.empresa,
            nNegocio: $scope.tracking.negocio
        };
        apiFactory.url('GestionMailWS/Resumen/ConsultaResumen');
        apiFactory.post(params)
            .then(function (response) {
                if (response.ok) {
                    var json = JSON.parse('[' + response.data.substr(0, response.data.length - 1) + ']');
                    var datos = chartService.trackingPieChartDetalle(json);
                    chartService.trackingDetalle(gDetail, 'gDetail', datos, 'value', 'campana', 'title', '[[title]]<br>[[value]]</b>([[percents]])');
                    gDetail.validateNow();
                    gDetail.animateAgain();

                    var modal = $('#mDetail')
                    modal.find('.modal-title').text('Detalle Campaña');
                    modal.find('.modal-subtitle').text('NAVIDAD');
                    $('#mDetail').modal('show')
                    gDetail.validateNow();
                } else {
                    $scope.message = response.message;
                    $scope.result = [];
                }
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                $scope.result = [];
            });
    }

    $scope.exportData = function () {
        apiFactory.exportDataToTable('exportDetail', 'Detalle Tracking');
    };

    $scope.exportData2 = function (pIdCampana, pNombreCampana, pFecha) {
        var fechas = pFecha.split("-");
        var desde = new Date(fechas[0], parseInt(fechas[1] - 1), 1);
        var hasta = new Date(fechas[0], parseInt(fechas[1]), 0);
        var params = {
            fechaDesde: apiFactory.formatDates(desde).toString(),
            fechaHasta: apiFactory.formatDates(hasta).toString(),
            idcampana: pIdCampana,
            campana: pNombreCampana,
            url: 'http://192.168.1.99:9800/GestionMailWS/Despacho/ConsultaDespacho'
        };
        $http.get('excel', $.param(params))
            .then(function (response) {
                console.info(response);
                apiFactory.notify('Tracking de Correos', 'Generando documento a exportar');
                //readyDetail.start();
                //$('#readyDetail').attr('disabled');
                $scope.boolean = 'OK';
                if (response.ok) {
                    var details = response.data.substr(0, response.data.length - 1);
                    $scope.detail = JSON.parse('[' + details + ']');
                }
            })
            .then(function () {
                //readyDetail.stop();
                $('#readyDetail').removeAttr('disabled');
                apiFactory.notify('Tracking de Correos', 'Documento listo para exportar', 'success');
            })
            .catch(function (errorMsg) {
                apiFactory.notify('Atención!', errorMsg);
                trackingButton.stop();
                $scope.result = [];
            });
    };

    function toJSONLocal(date) {
        var local = new Date(date);
        local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    }

    $('#mDetail').on('show.bs.modal', function (event) {
        gDetail.validateData();
        //gDetail.animateAgain();
    });

    $('#mDetail').on('shown.bs.modal', function (event) {
        gDetail.validateNow();
        //gDetail.animateAgain();
    });
}]);