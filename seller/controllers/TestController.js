angular.module('myApp')
    .controller('TestController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');


        $scope.requestPermission = function () {
            if ("Notification" in window) {
                Notification.requestPermission().then(function (permission) {
                    if (permission === "granted") {
                        alert("Notification permission granted!");
                    } else {
                        alert("Notification permission denied!");
                    }
                });
            } else {
                alert("Your browser does not support notifications.");
            }
        };

        // Function to show a browser notification
        $scope.showNotification = function () {
            if ("Notification" in window && Notification.permission === "granted") {
                new Notification("Hello!", {
                    body: "This is a browser notification!",
                    icon: "https://via.placeholder.com/100", // Optional: Replace with your own icon
                });
            } else if (Notification.permission === "denied") {
                alert("You have denied notification permissions.");
            } else {
                alert("Please grant notification permission first.");
            }
        };


    }]);
