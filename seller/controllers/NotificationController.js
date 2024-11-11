angular.module('myApp')
    .controller('NotificationController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        var baseUrl = sessionStorage.getItem('baseUrl');
        $scope.hasOrder = false;
        $scope.totalOrders = 0;

        $scope.fetchData = function () {

            setInterval(function () {

                ApiService.getPendingOrders(storeCode).then(function (data) {
                    if (data > 0) {
                        $scope.hasOrder = true;
                        if (data > $scope.totalOrders) {

                            $scope.totalOrders = data;
                            $scope.notificationSound();
                        }
                    }
                });


            }, 2000);

        };
        // Initial data fetch
        $scope.fetchData();


        $scope.notificationSound = function () {
            const audio = new Audio(baseUrl + "/pages/templates/audio/notification.wav");
            audio.play();
        }

    }]);
