// controllers/MainController.js
angular.module('myApp')
    .controller('MainController', ['$scope', '$route', '$location', 'ApiService', function ($scope, $route, $location, ApiService) {
        $scope.sideBarView = 'fragments/sideBar.php';
        $scope.pageSpinner = false;
        $scope.menuButton = true;

        // for notification  
        var storeCode = sessionStorage.getItem('storeCode');
        var baseUrl = sessionStorage.getItem('baseUrl');
        $scope.hasOrder = false;
        $scope.totalOrders = 0;

        $scope.goTo = function (page) {
            $route.reload(); // Forces the current route to reload
            $scope.hasNotif = false;
            $location.path(page);
        }


        $scope.spinner = function (value) {
            $scope.pageSpinner = value;
        }

        // Notification ==========================================================

        $scope.fetchNotification = function () {

            setInterval(function () {

                ApiService.getNotifications(storeCode).then(function (data) {
                    console.log("notification data", data.pending);
                    if (data.pending > 0) {
                        $scope.hasNotif = true;
                        $scope.notificationSound();
                    }
                });

            }, 2000);

        };
        // Initial data fetch
        $scope.fetchNotification();


        $scope.notificationSound = function () {
            const audio = new Audio(baseUrl + "/pages/templates/audio/notification.wav");
            audio.play();
        }

        // Side Nav ============================================================== 
        $scope.openNav = function () {
            $scope.menuButton = false;
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("sideBackdrop").style.width = "100vw";
        }

        $scope.closeNav = function () {
            $scope.menuButton = true;
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("sideBackdrop").style.width = "0";
        }

        // Bottom Sheet ============================================================== 
        $scope.openBottomSheet = function () {
            document.getElementById("bottomSheet").style.bottom = "0";
            document.getElementById("bottomBackdrop").style.width = "100vw";
        }

        $scope.closeBottomSheet = function () {
            document.getElementById("bottomSheet").style.bottom = "-100%";
            document.getElementById("bottomBackdrop").style.width = "0";
        }


        // Back drop ============================================================== 

        $scope.closeBackdrop = function () {
            $scope.closeNav();
            $scope.closeBottomSheet();
        }


        // Decove string with special characters 
        $scope.decodeHtml = function (html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        // Retrieve query parameter by name
        $scope.getQueryParam = function (param) {
            return $location.search()[param];
        };


        // Function to format datetime for MySQL before saving
        $scope.dateTimeToString = function (myDateTime) {
            if (myDateTime) {
                // Format the datetime to "YYYY-MM-DD HH:MM:SS"
                const date = new Date(myDateTime);
                const formattedDateTime = date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2) + ' ' +
                    ('0' + date.getHours()).slice(-2) + ':' +
                    ('0' + date.getMinutes()).slice(-2) + ':' +
                    ('0' + date.getSeconds()).slice(-2);

                return formattedDateTime;
            }
            return null;
        };

        $scope.stringToDateTime = function (datetime) {
            const date = new Date(datetime);
            return date.getFullYear() + '-' +
                ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                ('0' + date.getDate()).slice(-2) + 'T' +
                ('0' + date.getHours()).slice(-2) + ':' +
                ('0' + date.getMinutes()).slice(-2);
        }



    }]);