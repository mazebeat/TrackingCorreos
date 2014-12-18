'use strict';

trackingCorreos.factory('apiFactory', function () {
	var servicio = {};

	servicio.restApi = 'http://192.168.1.99:9800/';
	servicio.method = '';

	servicio.setMethod = function(method) {
		servicio.method = method;
	}

	servicio.post = function(data) {
		$http({
			url: servicio.method,
            method: "POST",
            data: $.param(data),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded;"
            }
        }).success(function (data, status, headers, config) {
            return { ok: true, data: data, status: status, headers: headers, config: config };
        }).error(function (data, status, headers, config) {
            return { ok: false, data: data, status: status, headers: headers, config: config };
        });
	};

	return servicio;
});