'use strict';

// Init app
var trackingCorreos = angular.module('trackingCorreos', []);

trackingCorreos.config(['$httpProvider', function ($httpProvider) {
	$httpProvider.defaults.useXDomain = true;
	$httpProvider.defaults.withCredentials = false;
	delete $httpProvider.defaults.headers.common['X-Requested-With'];
	$httpProvider.defaults.headers.common["Accept"] = "*/*";
}]);
