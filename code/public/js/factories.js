'use strict';

trackingCorreos.service('apiService', ['$http', '$q', function ($http, $q) {
    this.restApi = 'http://192.168.4.121:9800/';
    this.urlWS = '';
    this.deferred = '';

    this.isEmpty = function (obj) {
        for (var i in obj) if (obj.hasOwnProperty(i)) return false;
        return true;
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
            .success(function (data, status, headers, config) {
                self.deferred.resolve(data);
            })
            .error(function (data, status, headers, config) {
                self.deferred.resolve(data);
            })
            .catch(function (errorMsg) {
                self.deferred.resolve(data);
            });

        return self.deferred.promise;
    };

}]);
