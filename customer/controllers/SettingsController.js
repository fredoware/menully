angular.module('myApp')
    .controller('SettingsController', ['$scope', 'ApiService', function ($scope, ApiService) {
        $scope.storeCode = sessionStorage.getItem('storeCode');
        ApiService.backButton = "./";
        ApiService.showCartBanner = false;


        $scope.customerLogout = function () {
            sessionStorage.removeItem('userSession');
            sessionStorage.removeItem('cart');
            location.href = "./";
        }





    }]).directive('qrCode', function () {
        return {
            restrict: 'E',
            scope: {
                text: '@',        // Text to encode in the QR code
                width: '@?',      // Optional: width of the QR code
                height: '@?',     // Optional: height of the QR code
                colorDark: '@?',  // Optional: dark color for QR code
                colorLight: '@?', // Optional: light color for QR code
            },
            link: function (scope, element) {
                // Set default values for optional parameters
                const defaultWidth = 300;
                const defaultHeight = 300;
                const defaultColorDark = "#000";
                const defaultColorLight = "#fff";

                new QRCode(element[0], {
                    text: scope.text || "",
                    width: scope.width || defaultWidth,
                    height: scope.height || defaultHeight,
                    colorDark: scope.colorDark || defaultColorDark,
                    colorLight: scope.colorLight || defaultColorLight,
                    correctLevel: QRCode.CorrectLevel.H,
                });
            }
        };
    });