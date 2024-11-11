angular.module('myApp')
    .controller('FeedbackController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        $scope.rating = 2; // Set this dynamically as needed

        $scope.getStars = function () {
            return [1, 2, 3, 4, 5]; // Array representing 5 stars
        };


        $scope.fetchData = function (storeCode) {
            $scope.spinner(true);
            ApiService.getFeedbacks(storeCode).then(function (data) {
                $scope.feedbackList = data.list;
                $scope.spinner(false);
            });
        };

        // Initial data fetch
        $scope.fetchData(storeCode);


    }]);
