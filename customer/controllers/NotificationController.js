angular.module('myApp')
    .controller('NotificationController', ['$scope', 'ApiService', '$location', function ($scope, ApiService, $location) {
        var storeCode = sessionStorage.getItem('storeCode');
        var baseUrl = sessionStorage.getItem('baseUrl');
        var deviceId = sessionStorage.getItem('userIdSession');
        ApiService.backButton = "./";


        $scope.fetchOnce = function () {
            $scope.hasNotif = false;
            ApiService.getNotifications(storeCode, deviceId).then(function (data) {
                $scope.notifList = data.all;
            });
        }
        $scope.fetchOnce();


        $scope.fetchNotification = function () {

            setInterval(function () {

                ApiService.getNotifications(storeCode, deviceId).then(function (data) {
                    console.log("notification all data", data.all);
                    if (data.pending > 0) {
                        $scope.notifList = data.all;
                        $scope.notificationSound();
                    }
                });

            }, 2000);

        };
        // Initial data fetch
        if (deviceId) {
            $scope.fetchNotification();
        }


        $scope.notificationSound = function () {
            const audio = new Audio(baseUrl + "/pages/templates/audio/notification.wav");
            audio.play();
        }


        $scope.readNotif = function (item) {
            item.status = "Read";
            ApiService.changeNotifStatus(item.Id, "Read").then(function (data) {
            });

            if (item.type == "Order") {
                Swal.fire({
                    title: item.message,
                    confirmButtonText: "Close" // Change the button text here
                });
            }
            if (item.type == "Feedback") {
                $location.path("/feedback");
            }
        }

    }]);
