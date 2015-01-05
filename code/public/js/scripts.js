$(window).resize(function () {
    if ('matchMedia' in window) {
        // Chrome, Firefox, and IE 10 support mediaMatch listeners
        window.matchMedia('print').addListener(function (media) {
            chart.validateNow();
        });
    } else {
        // IE and Firefox fire before/after events
        window.onbeforeprint = function () {
            chart.validateNow();
        }
    }
});

$(window).load(function () {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut(function () {
        $('body').delay(350).css({'overflow': 'visible'});
    });
});

$(document).ready(function () {
    $('.panel .tools .fa-chevron-down').click(function () {
        var el = $(this).parents(".panel").children(".panel-body");
        if ($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });
    
    // panel close
    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });

    var steps = [
        {
            element: "#menuHome",
            title: "Inicio",
            content: "Es la pantalla principal de la aplicación donde podrás apreciar dos gráficos con resumen de la última información entregada por la aplicación.",
            placement: "right",
            onShow: function (tour) {
                if (!$('#menuHome').hasClass('current')) {
                    $('#menuHome').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuHome').hasClass('current')) {
                    $('#menuHome').removeClass('active');
                }
            }
        },
        {
            element: "#menuConsultas",
            title: "Consultas",
            content: "",
            placement: "bottom",
            onShow: function (tour) {
                if (!$('#menuConsultas').hasClass('current')) {
                    $('#menuConsultas').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuConsultas').hasClass('current')) {
                    $('#menuConsultas').removeClass('active');
                }
            }
        },
        {
            element: "#menuReportes",
            title: "Reportes",
            content: "",
            placement: "bottom",
            onShow: function (tour) {
                if (!$('#menuReportes').hasClass('current')) {
                    $('#menuReportes').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuReportes').hasClass('current')) {
                    $('#menuReportes').removeClass('active');
                }
            }
        },
        {
            element: "#menuTracking",
            title: "Tracking",
            content: "En esta sección podrás realizar la busquedas de todos los movimientos relacionados a una campaña y una fecha específica.",
            placement: "bottom",
            onShow: function (tour) {
                if (!$('#menuTracking').hasClass('current')) {
                    $('#menuTracking').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuTracking').hasClass('current')) {
                    $('#menuTracking').removeClass('active');
                }
            }
        },
        {
            element: "#menuAdmin",
            title: "Administración",
            content: "Solo es visible para los usuarios con permisos de administrador. Aquí es donde se encuentra la administración de usuarios y más. ",
            placement: "bottom",
            onShow: function (tour) {
                if (!$('#menuAdmin').hasClass('current')) {
                    $('#menuAdmin').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuAdmin').hasClass('current')) {
                    $('#menuAdmin').removeClass('active');
                }
            }
        },
        {
            element: "#menuUsuario",
            title: "Usuario",
            content: "Menú en el cual encontrarás todo lo relacionado a tu usuario.",
            placement: "left",
            onShow: function (tour) {
                if (!$('#menuUsuario').hasClass('current')) {
                    $('#menuUsuario').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuUsuario').hasClass('current')) {
                    $('#menuUsuario').removeClass('active');
                }
            }
        },
        {
            element: "#menuHelp",
            title: "Ayuda",
            content: "Presionando este botón habilitaremos el tour de ayuda por el menu pricipal del sitio.",
            placement: "left",
            onShow: function (tour) {
                if (!$('#menuHelp').hasClass('current')) {
                    $('#menuHelp').addClass('active');
                }
            },
            onHide: function (tour) {
                if (!$('#menuHelp').hasClass('current')) {
                    $('#menuHelp').removeClass('active');
                }
            }
        }
    ];
    var config = {
        name: "tour",
        steps: steps,
        container: "body",
        keyboard: true,
        storage: false,
        debug: false,
        backdrop: true,
        backdropPadding: 0,
        redirect: true,
        orphan: false,
        duration: false,
        delay: false,
        basePath: "",
        template: "<div class='popover popover-all tour'>" +
        "<div class='arrow'></div>" +
        "<h3 class='popover-title'></h3>" +
        "<div class='popover-content'></div>" +
        "<div class='popover-navigation'>" +
        "<button class='btn btn-default' data-role='prev'><i class='fa fa-arrow-left'></i></button>" +
        "<span data-role='separator'></span>" +
        "<button class='btn btn-default' data-role='next'><i class='fa fa-arrow-right'></i></button>" +
        "<button class='btn btn-danger' data-role='end'><i class='fa fa-power-off'></i></button>" +
        "</div>" +
        "</div>"
    };
    var tour = new Tour(config);
    $('#helpPopover').click(function (e) {
        e.preventDefault();
        localStorage.removeItem("tour_current_step");
        localStorage.removeItem("tour_end");
        //tour.init();
        tour.restart();
    });
    var steps = [
        {
            element: "#chartdiv1",
            title: "Gráfico por campañas",
            content: "Gráfico que resume los documentos por campaña registrados el mes actual.",
            placement: "top"
        },
        {
            element: "#chartdiv2",
            title: "Gráfico por meses",
            content: "Gráfico de resumen en el cual podemos visualizar los documentos generados dentro de un periodo de meses determinado por el usuario.",
            placement: "left"
        },
        {
            element: "#searchForm",
            title: "Cantidad de meses",
            content: "Filtro utilizado para mostrar un rango de meses determinado desde la fecha actual hasta el numero escogido.",
            placement: "left"
        },
        {
            element: "#searchFormButton",
            title: "Botón refrescar",
            content: "Luego de haber escogido la cantidad de meses, debes presionar este botón para actualizar los datos a mostrar.",
            placement: "left"
        }


    ];
    var config = {
        name: "dsTour",
        steps: steps,
        container: "body",
        keyboard: true,
        storage: false,
        debug: false,
        backdrop: true,
        backdropPadding: 0,
        redirect: true,
        orphan: false,
        duration: false,
        delay: false,
        basePath: "",
        template: "<div class='popover popover-all tour'>" +
        "<div class='arrow'></div>" +
        "<h3 class='popover-title'></h3>" +
        "<div class='popover-content'></div>" +
        "<div class='popover-navigation'>" +
        "<button class='btn btn-default' data-role='prev'><i class='fa fa-arrow-left'></i></button>" +
        "<span data-role='separator'></span>" +
        "<button class='btn btn-default' data-role='next'><i class='fa fa-arrow-right'></i></button>" +
        "<button class='btn btn-danger' data-role='end'><i class='fa fa-power-off'></i></button>" +
        "</div>" +
        "</div>"
    };

    var tourDashboard = new Tour(config);
    $('#dashboardTour').click(function (e) {
        e.preventDefault();
        localStorage.removeItem("tour_current_step");
        localStorage.removeItem("tour_end");
        //tour.init();
        tourDashboard.restart();
    });

    $(".buttonExport").click(function () {
        var exp = new AmCharts.AmExport(chart);
        var output = "pdf";
        var id = this.id;
        switch (id) {
            case ('btnPDF'):
                output = 'pdf';
                break;
            case ('btnJPG'):
                output = 'jpg';
                break;
            case ('btnPNG'):
                output = 'png';
                break;
        }
        exp.init();
        exp.output({
            format: output,
            output: 'save'
        });
    });

});
