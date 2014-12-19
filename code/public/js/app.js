'use strict';

// Init app
var trackingCorreos = angular.module('trackingCorreos', []);

trackingCorreos.config(['$httpProvider', '$provide', function ($httpProvider, $provide) {
    $httpProvider.defaults.useXDomain = true;
    $httpProvider.defaults.withCredentials = false;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
    $httpProvider.defaults.headers.common["Accept"] = "*/*";

    $provide.decorator("$exceptionHandler", function ($delegate, $injector) {
        return function (exception, cause) {
            var $rootScope = $injector.get("$rootScope");
            $rootScope.addError({message: "Exception", reason: exception});
            $delegate(exception, cause);
        };
    });
}]);
