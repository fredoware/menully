// controllers/MainController.js
angular.module('myApp')
    .controller('MainController', ['$scope', '$route', '$location', 'ApiService', function ($scope, $route, $location, ApiService) {
        $scope.pageSpinner = false;
        $scope.settingsButton = true;
        var deviceId = sessionStorage.getItem('userIdSession');

        $scope.goTo = function (page) {
            $route.reload(); // Forces the current route to reload
            $scope.hasNotif = false;
            $location.path(page);
        }



        // for notification  
        var storeCode = sessionStorage.getItem('storeCode');
        var baseUrl = sessionStorage.getItem('baseUrl');
        $scope.hasNotif = false;

        if (sessionStorage.getItem('userSession')) {
            console.log('userSession exists in sessionStorage');
            $scope.pagesView = true;
            $scope.settingsButton = true;
        } else {
            console.log('userSession does not exist in sessionStorage');
            $scope.pagesView = false;
            $scope.settingsButton = false;
        }

        $scope.customerForm = function () {
            sessionStorage.setItem('userSession', $scope.customerName);
            let userId = localStorage.getItem('userId');
            FingerprintJS.load().then(fp => {
                fp.get().then(result => {
                    userId = result.visitorId;
                    sessionStorage.setItem('userIdSession', userId);
                    console.log('Generated User ID:', userId);
                });
            });

            $scope.pagesView = true;
            $scope.settingsButton = true;
            $scope.fetchNotification();
        }


        // Notification ==========================================================

        $scope.fetchNotification = function () {

            setInterval(function () {

                ApiService.getNotifications(storeCode, deviceId).then(function (data) {
                    console.log("notification data", data.pending);
                    if (data.pending > 0) {
                        $scope.hasNotif = true;
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


        // This is to share models from a child controller
        $scope.apiService = ApiService;
        $scope.apiService.updateCartService = function (hasBanner = true) {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            $scope.apiService.showCartBanner = hasBanner;
            $scope.apiService.totalCartQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            $scope.apiService.totalCartAmount = cart.reduce((sum, item) => sum + (item.quantity * item.price), 0);

        }
        $scope.apiService.updateCartService();


        $scope.spinner = function (value) {
            $scope.pageSpinner = value;
        }


        // Bottom Sheet ============================================================== 
        $scope.openBottomSheet = function () {
            $scope.apiService.showCartBanner = false;
            document.getElementById("bottomSheet").style.bottom = "0";
            document.getElementById("bottomBackdrop").style.width = "100vw";
        }

        $scope.closeBottomSheet = function (hasCartBanner = true) {
            $scope.apiService.showCartBanner = hasCartBanner;
            document.getElementById("bottomSheet").style.bottom = "-100%";
            document.getElementById("bottomBackdrop").style.width = "0";
        }


        // Back drop ============================================================== 

        $scope.closeBackdrop = function (hasCartBanner = true) {
            $scope.closeBottomSheet(hasCartBanner);
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