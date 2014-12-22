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
//								apiService.notify('Tracking de Correos', $scope.message);
								$window.location.href = rootFactory.root + '/dashboard';
								$scope.user = {};
								loginButton.stop();
							}

							$scope.message = data.message;
							apiService.notify('Tracking de Correos', $scope.message);
							$scope.user = {};
							loginButton.stop();
						})
						.error(function (data, status, headers, config) {
							loginButton.stop();
							console.log(data);
							apiService.notify('Tracking de Correos', data);
							$window.location.href = rootFactory.root + '/';
							$scope.user = {};
							loginButton.stop();
						});
				} else {
					$scope.message = response.messsage;
					apiService.notify('Atención!', $scope.message);
					$scope.user = {};
					loginButton.stop();
				}
			})
			.catch(function (errorMsg) {
				apiService.notify('Atención!', errorMsg);
				$scope.user = {};
				loginButton.stop();
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
