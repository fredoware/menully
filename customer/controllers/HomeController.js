angular.module('myApp')
    .controller('HomeController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        ApiService.backButton = null;
        ApiService.showCartBanner = true;


    }]);
