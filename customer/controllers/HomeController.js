angular.module('myApp')
    .controller('HomeController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        $scope.apiService.backButton = null;
        $scope.apiService.showCartBanner = true;

    }]);
