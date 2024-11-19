angular.module('myApp')
    .controller('ReportController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');


        $scope.fetchData = function () {
            $scope.spinner(true);
            ApiService.getReports(storeCode).then(function (data) {
                console.log("report key", Object.keys(data.menuItems));
                console.log("report value", Object.values(data.menuItems));
                // $scope.categoryList = data.list;
                $scope.data = data.menuItems;
                $scope.spinner(false);
            });
        };

        // Initial data fetch
        $scope.fetchData();


        // Max bar width in pixels
        $scope.maxBarWidth = 500;


    }]);

