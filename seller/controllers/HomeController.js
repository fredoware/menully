angular.module('myApp')
    .controller('HomeController', ['$scope', 'ApiService', function($scope, ApiService) {
        $scope.items = []; 
        $scope.message = sessionStorage.getItem('storeCode');
        $scope.menuButton = true;

        // Fetch data from the API
        $scope.fetchData = function() {
            ApiService.getData().then(function(data) {
                $scope.items = data;
            });
        };

        // Post data to the API
        $scope.sendData = function() {
            var postData = { name: "New Item" };
            ApiService.postData(postData).then(function(response) {
                $scope.message = response.message;
            });
        };

        // Initial data fetch
        $scope.fetchData();
    }]);
