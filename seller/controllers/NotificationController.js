angular.module('myApp')
    .controller('NotificationController', ['$scope', 'ApiService', '$location', function ($scope, ApiService, $location) {
        var storeCode = sessionStorage.getItem('storeCode');
        var baseUrl = sessionStorage.getItem('baseUrl');
        $scope.hasOrder = false;

        $scope.fetchOnce = function () {
            $scope.hasNotif = false;
            ApiService.getNotifications(storeCode).then(function (data) {
                $scope.notifList = data.all;
            });
        }
        $scope.fetchOnce();


        $scope.fetchNotification = function () {

            setInterval(function () {

                ApiService.getNotifications(storeCode).then(function (data) {
                    console.log("notification all data", data.all);
                    if (data.pending > 0) {
                        $scope.notifList = data.all;
                        $scope.notificationSound();
                    }
                });

            }, 2000);

        };

        $scope.fetchNotification();


        $scope.notificationSound = function () {
            const audio = new Audio(baseUrl + "/pages/templates/audio/notification.wav");
            audio.play();
        }


        $scope.readNotif = function (item) {
            $location.path("/orders").search({ status: "Pending" });
            ApiService.changeNotifStatus("Order", "Read").then(function (data) {
            });
        }

    }]);
