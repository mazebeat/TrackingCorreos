'use strict';

/* Api Service */
trackingCorreos.service('apiFactory', ['$http', '$q', function ($http, $q) {
    //this.restApi = 'http://192.168.4.121:9800/';
    this.restApi = 'http://192.168.1.99:9800/';
    this.urlWS;
    this.deferred;

    this.isEmpty = function (obj) {
        for (var i in obj) if (obj.hasOwnProperty(i)) return false;
        return true;
    };

    this.formatDates = function (today) {
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        return yyyy + '' + mm + '' + dd;
    };

    this.url = function (method) {
        this.urlWS = this.restApi + method;
    };

    this.post = function (datos) {
        if (this.isEmpty(datos)) {
            return {ok: false};
        }

        var self = this;
        self.deferred = $q.defer();

        var configs = {
            url: this.urlWS,
            method: "POST",
            data: $.param(datos),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded;"
            }
        };

        $http(configs)
            .success(function (data) {
                self.deferred.resolve(data);
            })
            .error(function (data) {
                self.deferred.resolve(data);
            })
            .catch(function (errorMsg) {
                self.deferred.resolve(errorMsg);
            });
        return self.deferred.promise;
    };

    this.notify = function (title, message, type) {
        var title = typeof title !== 'undefined' && title.length ? title : '';
        var message = typeof message !== 'undefined' && message.length ? message : 'Error en el servidor, por favor espere.';
        var type = typeof type !== 'undefined' && type.length ? type : 'notice';

        if (message instanceof Array) {
            angular.forEach(message, function (v, k) {
                new PNotify({
                    type: type,
                    title: title,
                    text: v,
                    animate_speed: "fast",
                    desktop: {
                        desktop: true
                    },
                    sticker: false
                });
            });
        } else {
            new PNotify({
                type: type,
                title: title,
                text: message,
                animate_speed: "fast",
                desktop: {
                    desktop: true
                },
                sticker: false
            });
        }
    };

    this.stackNotify = function (type, position) {
        var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
        var stack_bottomleft = {"dir1": "right", "dir2": "up", "push": "top"};
        var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
        var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};

        var opts = {
            title: "Over Here",
            text: "Check me out. I'm in a different stack.",
            addclass: "stack_bottomleft",
            cornerclass: "",
            width: "60%"
        };
        switch (type) {
            case 'error':
                opts.title = "Oh No";
                opts.text = "Watch out for that water tower!";
                opts.type = "error";
                break;
            case 'info':
                opts.title = "Atención!";
                opts.text = "No se encontraron datos";
                opts.type = "info";
                break;
            case 'success':
                opts.title = "Good News Everyone";
                opts.text = "I've invented a device that bites shiny metal asses.";
                opts.type = "success";
                break;
        }
        switch (position) {
            case 'top':
                opts.stack = stack_bar_top;
                break;
            case 'topleft':
                opts.stack = stack_topleft;
                break;
            case 'bottom':
                opts.stack = stack_bottomleft;
                break;
        }
        new PNotify(opts);
    };

    this.getMonth = function (date) {
        var month = date.getMonth();
        return month < 10 ? '0' + month : month;
        /* ('' + month) for string result */
    };

    this.   exportDataToTable = function (id, name) {
        var blob = new Blob([document.getElementById(id).innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8"
        });
        //console.log(name + ".xls");
        saveAs(blob, name + ".xls");
    };

    this.splitString = function(string, nb) {
        //console.log(string);
        var array = string.split(',');
        return array[nb];
    }
}]);

/* Chart Service */
trackingCorreos.service('chartService', ['rootFactory', '$http', '$window', 'storageService', function (rootFactory, $http, $window, storageService) {
    this.urlImages = rootFactory.root + '/js/amcharts/images/';

    this.dashboardPieChart = function (data) {
        var result = [], campana = '', count = 0;

        angular.forEach(data, function (v, k) {
            while (count < 1) {
                if (v.hasOwnProperty('campana')) {
                    campana = v.campana.nombre;
                }
                if (v.hasOwnProperty('nombreCampana')) {
                    campana = v.nombreCampana;
                }
                result.push({
                    campana: campana,
                    total: v.qelectronicos
                });
                count++;
            }
        });

        return result;
    };

    this.dashboardSerialChart = function (data) {
        var arreglo = [], config = [], campañas = [], temp = [], fecha = '', id = '', campana = '';
        angular.forEach(data, function (v, k) {
            fecha = v.ano + '-' + v.mes;
            id = v.ano + '' + v.mes;
            if (v.hasOwnProperty('campana')) {
                campana = v.campana.nombre;
            }
            if (v.hasOwnProperty('nombreCampana')) {
                campana = v.nombreCampana;
            }

            campañas.push(campana);

            if (arreglo.hasOwnProperty(id)) {
                arreglo[id][campana] = v.qelectronicos;
                arreglo[id]['idcampana'] = v.id_campana;
            } else {
                arreglo[id] = {'fecha': fecha};
                arreglo[id][campana] = v.qelectronicos;
                arreglo[id]['idcampana'] = v.id_campana;
            }
        });

        arreglo.forEach(function (elemento) {
            if (elemento != null) {
                temp.push(elemento);
            }
        });
        config['data'] = temp;
        config['graphs'] = this.unique(campañas);
        //console.log(config);
        return config;
    };

    this.trackingPieChart = function (data) {
        var mes = 0, ano = 0, titulo = '', campana = '', qClick = 0, qDesinscritos = 0, qElectronicos = 0, qEmitidos = 0, qEnviosFallidos = 0,
            qFisicos = 0, qLeidos = 0, qNoLeidos = 0, qRebotes = 0, qRetenidos = 0, temp = [], result = [];

        angular.forEach(data, function (v, k) {
            mes = v.mes;
            ano = v.ano;
            if (v.hasOwnProperty('campana')) {
                campana = v.campana.nombre;
            }
            if (v.hasOwnProperty('nombreCampana')) {
                campana = v.nombreCampana;
            }
            //console.log(campana);

            angular.forEach(v, function (v, k) {
                switch (k) {
                    case 'qclick':
                        titulo = k;
                        qClick += v;
                        break;
                    case 'qdesinscritos':
                        qDesinscritos += v;
                        titulo = k;
                        break;
                    case 'qelectronicos':
                        qElectronicos += v;
                        titulo = k;
                        break;
                    case 'qemitidos':
                        qEmitidos += v;
                        titulo = k;
                        break;
                    case 'qenviosfallidos':
                        qEnviosFallidos += v;
                        titulo = k;
                        break;
                    case 'qfisicos':
                        qFisicos += v;
                        titulo = k;
                        break;
                    case 'qleidos':
                        qLeidos += v;
                        titulo = k;
                        break;
                    case 'qnoleidos':
                        qNoLeidos += v;
                        titulo = k;
                        break;
                    case 'qrebotes':
                        qRebotes += v;
                        titulo = k;
                        break;
                    case 'qretenidos':
                        qRetenidos += v;
                        titulo = k;
                        break;
                }
            });
        });
        temp.push({
            campana: campana,
            qclick: qClick,
            qdesinscritos: qDesinscritos,
            qelectronicos: qElectronicos,
            qemitidos: qEmitidos,
            qenviosfallidos: qEnviosFallidos,
            qfisicos: qFisicos,
            qleidos: qLeidos,
            qnoleidos: qNoLeidos,
            qrebotes: qRebotes,
            qretenidos: qRetenidos
        });
        angular.forEach(temp, function (v, k) {
            var date = new Date(ano + '-' + mes + '-' + '1');
            var camp = '';
            angular.forEach(v, function (v, k) {
                if (k == 'campana') {
                    camp = v;
                } else {
                    result.push({
                        campana: camp,
                        date: date,
                        title: k,
                        value: v
                    });
                }
            });
        });

        return result;
    };

    this.unique = function (origArr) {
        var newArr = [],
            origLen = origArr.length,
            found, x, y;

        for (x = 0; x < origLen; x++) {
            found = undefined;
            for (y = 0; y < newArr.length; y++) {
                if (origArr[x] === newArr[y]) {
                    found = true;
                    break;
                }
            }
            if (!found) {
                newArr.push(origArr[x]);
            }
        }
        return newArr;
    };

    this.sort = function (array) {
        array = array.sort(function (a, b) {
            return a.item.localeCompare(b.item);
        });
        //console.log(array);
    };

    /* 123 || 321 */
    this.sortJSON = function (data, key, way) {
        return data.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            if (way === '123') {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            }
            if (way === '321') {
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            }
        });
    };

    this.donut = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.titleField = title;
        chart.valueField = ejeX;
        chart.outlineColor = "#FFFFFF";
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
        chart.labelTexto = labelTexto;
        /* <--- titulo de cada parte del gráfico */
        chart.balloonTex = "[[title]]<br><span style='font-size:11px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();
        /* */
        chart.labelRadius = 5;
        chart.radius = "35%";
        chart.innerRadius = "60%";
        chart.dataDateFormat = "YYYY-MM-DD HH:NN";
        this.animation(chart, true);
        this.legend(chart);

        //chart.exportConfig = this.export();

        chart.dataProvider = data;
        chart.write(div);
    };

    this.semestral = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        /* <--- */
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();
        chart.dataDateFormat = "YYYY-MM";

        var chartScrollbar = new AmCharts.ChartScrollbar();
        chartScrollbar.updateOnReleaseOnly = true;
        chartScrollbar.autoGridCount = true;
        chartScrollbar.scrollbarHeight = 20;
        chart.addChartScrollbar(chartScrollbar);

        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 1;
        valueAxis.axisColor = "#DADADA";
        valueAxis.axisAlpha = 1;
        /* valueAxis.unit = "$"; */
        valueAxis.unitPosition = "left";
        chart.addValueAxis(valueAxis);

        var count = 0;
        angular.forEach(data.graphs, function (v, k) {
            var graph = new AmCharts.AmGraph();
            var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
            graph.title = v;
            graph.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]: <b>[[value]]</b></span>";
            graph.type = "line";
            graph.valueField = v;
            /* <--- */
            graph.lineColor = color;
            graph.lineThickness = 3;
            graph.bullet = "round";
            graph.bulletColor = color;
            graph.bulletBorderColor = "#ffffff";
            graph.bulletBorderAlpha = 1;
            graph.bulletBorderThickness = 3;
            graph.bulletSize = 15;
            if (count > 2) {
                graph.hidden = true;
            }
            chart.addGraph(graph);
            count++;
        });

        chart.dataProvider = data.data;

        this.animation(chart, false);
        this.legend(chart);
        this.categoryAxis(chart, true);

        var chartCursor = new AmCharts.ChartCursor();
        chart.addChartCursor(chartCursor);

        //chart.exportConfig = this.export();

        chart.addListener("clickGraphItem", eventClick);
        chart.write(div);
    };

    function eventClick(event) {
        var date = event.item.dataContext.fecha;
        var campana = event.item.dataContext.idcampana;
        var data = {date: date, campana: campana};
        if (storageService.isSupported) {
            if (storageService.create('searchTracking', data)) {
                $window.location.href = rootFactory.root + '/dashboard/tracking/';
            }
        } else {
            $http.post(rootFactory.root + '/dashboard/setSearchTracking', data).
                success(function (data) {
                    //console.log('NonSupported');
                    //console.log(data);
                });
        }
    }
    this.dots = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        /* <--- */
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();

        chart.dataDateFormat = "YYYY-MM";

        this.categoryAxis(chart, true);

        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 1;
        valueAxis.axisColor = "#DADADA";
        valueAxis.axisAlpha = 1;
        /* valueAxis.unit = "$"; */
        valueAxis.unitPosition = "left";
        chart.addValueAxis(valueAxis);

        this.animation(chart, false);

        this.legend(chart);

        var graph = new AmCharts.AmGraph();
        graph.title = title;
        graph.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]: <b>[[value]]</b></span>";
        graph.type = "line";
        graph.valueField = ejeX;
        /* <--- */
        graph.lineColor = "#60c6cf";
        graph.lineThickness = 3;
        graph.bullet = "round";
        graph.bulletColor = "#60c6cf";
        graph.bulletBorderColor = "#ffffff";
        graph.bulletBorderAlpha = 1;
        graph.bulletBorderThickness = 3;
        graph.dashLengthLine = "dashLengthLine";
        graph.bulletSize = 15;
        chart.addGraph(graph);

        //chart.exportConfig = this.export();

        var chartCursor = new AmCharts.ChartCursor();
        chart.addChartCursor(chartCursor);

        chart.dataProvider = data;
        chart.write(div);
    };

    this.animation = function (chart, bool) {
        if (bool) {
            chart.sequencedAnimation = true;
            chart.startDuration = 1;
            chart.startAlpha = 0;
        } else {
            chart.sequencedAnimation = false;
            chart.startDuration = 0;
            chart.startAlpha = 0;
        }
    };

    this.export = function () {
        var exportConfig = {
            menuTop: "-10px",
            menuBottom: "0px",
            menuRight: "0px",
            backgroundColor: "#efefef",
            menuItems: [{
                textAlign: 'center',
                icon: this.urlImages + 'export.png',
                items: [{
                    title: 'JPG',
                    format: 'jpg'
                }, {
                    title: 'PNG',
                    format: 'png'
                }, {
                    title: 'SVG',
                    format: 'svg'
                }, {
                    title: 'PDF',
                    format: 'pdf'
                }]
            }]
        };

        return exportConfig;
    };

    this.legend = function (chart, legenddiv, text) {
        legenddiv = typeof legenddiv !== 'undefined' && legenddiv.length != 0 ? legenddiv : false;
        text = typeof text !== 'undefined' && text.length != 0 ? text : false;

        var legend = new AmCharts.AmLegend();
        legend.align = "center";
        legend.markerType = "circle";
        legend.valueText = "";
        legend.useGraphSettings = false;

        if (!text) {
            legend.labelTexto = "[[title]]";
        } else {
            legend.labelTexto = text;
        }

        if (!legenddiv) {
            chart.addLegend(legend);
        } else {
            chart.addLegend(legend, legenddiv);
        }
    };

    this.margin = function (chart) {
        chart.autoMargins = false;
        chart.marginRight = 10;
        chart.marginLeft = 80;
        chart.marginBottom = 20;
        chart.marginTop = 20;
    };

    this.formatNumber = function () {
        return {
            decimalSeparator: ",",
            thousandsSeparator: ".",
            precision: parseInt(-1)
        };
    };

    this.categoryAxis = function (chart, parse) {
        parse = typeof parse !== 'undefined' && parse.length != 0 ? parse : true;
        var categoryAxis = chart.categoryAxis;
        categoryAxis.inside = false;
        categoryAxis.axisAlpha = 0;
        categoryAxis.gridAlpha = 0;
        categoryAxis.tickLength = 0;
        categoryAxis.minPeriod = "MM";
        categoryAxis.equalSpacing = false;
        categoryAxis.equalSpacing = true;
        categoryAxis.boldPeriodBeginning = true;
        if (parse) {
            categoryAxis.parseDates = true;
            /*
             //categoryAxis.dateFormats = [
             //    {
             //        period: 'fff',
             //        format: 'JJ:NN:SS'
             //    }, {
             //        period: 'ss',
             //        format: 'JJ:NN:SS'
             //    }, {
             //        period: 'mm',
             //        format: 'JJ:NN'
             //    }, {
             //        period: 'hh',
             //        format: 'JJ:NN'
             //    }, {
             //        period: 'DD',
             //        format: 'MMM DD'
             //    }, {
             //        period: 'WW',
             //        format: 'MMM DD'
             //    }, {
             //        period: 'MM',
             //        format: 'MMM YYYY'
             //    }, {
             //        period: 'YYYY',
             //        format: 'MMM YYYY'
             //    }
             //];
             */
        }
    };

    this.exportGraphToFormat = function (chart, format, fileName) {
        var exp = new AmCharts.AmExport(chart);
        exp.init();
        exp.output({
            format: format,
            output: 'save',
            backgroundColor: '#FFFFFF',
            fileName: fileName,
            dpi: 90
        });

        //exp.userCFG = {
        //    menuTop: 'auto',
        //    menuLeft: 'auto',
        //    menuRight: '0px',
        //    menuBottom: '0px',
        //    menuItems: [{
        //        textAlign: 'center',
        //        icon: '../amcharts/images/export.png',
        //        iconTitle: 'Save chart as an image',
        //        onclick: function () {
        //        },
        //        items: [{
        //            title: 'JPG',
        //            format: 'jpg'
        //        }, {
        //            title: 'PNG',
        //            format: 'png'
        //        }, {
        //            title: 'SVG',
        //            format: 'svg'
        //        }]
        //    }],
        //    menuItemStyle: {
        //        backgroundColor: 'transparent',
        //        opacity: 1,
        //        rollOverBackgroundColor: '#EFEFEF',
        //        color: '#000000',
        //        rollOverColor: '#CC0000',
        //        paddingTop: '6px',
        //        paddingRight: '6px',
        //        paddingBottom: '6px',
        //        paddingLeft: '6px',
        //        marginTop: '0px',
        //        marginRight: '0px',
        //        marginBottom: '0px',
        //        marginLeft: '0px',
        //        textAlign: 'left',
        //        textDecoration: 'none',
        //        fontFamily: 'Arial', // Default: charts default
        //        fontSize: '12px', // Default: charts default
        //    },
        //    menuItemOutput: {
        //        backgroundColor: '#FFFFFF',
        //        fileName: 'amCharts',
        //        format: 'png',
        //        output: 'dataurlnewwindow',
        //        render: 'browser',
        //        dpi: 90,
        //        onclick: function (instance, config, event) {
        //            event.preventDefault();
        //            instance.output(config);
        //        }
        //    },
        //    removeImagery: true
        //}
    }
}]);

/* Storage Service */
trackingCorreos.factory('storageService', ['localStorageService', function (localStorageService) {
    var storage = {
        create: function (key, val) {
            return localStorageService.set(key, val);
        },
        getItem: function (key) {
            return localStorageService.get(key);
        },
        removeItem: function (key) {
            return localStorageService.remove(key);
        },
        clearNumbers: function () {
            return localStorageService.clearAll(/^\d+$/);
        },
        clearAll: function () {
            return localStorageService.clearAll();
        },
        getLength: function () {
            return localStorageService.length();
        },
        getKeys: function () {
            return localStorageService.keys();
        },
        isSupported: function () {
            if (localStorageService.isSupported) {
                return true;
            }

            return false;
        }
    };

    return storage;
}]);
