angular.module('myApp')
    .controller('CartController', ['$scope', 'ApiService', '$location', function ($scope, ApiService, $location) {
        var storeCode = sessionStorage.getItem('storeCode');
        $scope.storeLogo = sessionStorage.getItem('storeLogo');
        ApiService.showCartBanner = false;
        ApiService.backButton = true;
        $scope.orderFormDisplay = true;


        // Fetch data from the API
        $scope.fetchData = function () {
            ApiService.getCart().then(function (data) {
                $scope.cartList = data.list;
            });
        };
        // Initial data fetch
        $scope.fetchData();


        $scope.updateItemQuantity = function (item, number) {
            item.quantity = parseInt(item.quantity) + parseInt(number);
            item.total = item.variation.price * item.quantity;

            if (parseInt(number) < 1) {
                $scope.apiService.totalCartAmount = parseInt($scope.apiService.totalCartAmount) - parseInt(item.variation.price);
            } else {
                $scope.apiService.totalCartAmount = parseInt($scope.apiService.totalCartAmount) + parseInt(item.variation.price);
            }

            $scope.updateCart(item);
        };

        $scope.updateCart = function (item) {
            ApiService.updateCart(item.variation.Id, item.quantity).then(function (data) {
                // $scope.cartList = data.list;
            });

        };

        $scope.openOrderForm = function () {
            $scope.orderFormDisplay = false;
            $scope.openBottomSheet();
        }

        $scope.closeCartSheet = function () {
            $scope.orderFormDisplay = true;
            $scope.closeBottomSheet(false);
        }

        $scope.submitOrder = function () {
            Swal.fire({
                title: 'Submitting Order...',
                html: '<div style="font-size: 18px;">Your request is on the way! 🚀</div>',
                iconHtml: '<img src="../media/' + $scope.storeLogo + '" width="100%" style="border-radius:45px;">', // Use a custom emoji/icon
                customClass: {
                    icon: 'custom-icon' // Apply custom styles
                },
                timer: 2000, // 5 seconds
                timerProgressBar: true, // Show progress bar
                showConfirmButton: false, // Hide the confirm button
                allowOutsideClick: false, // Prevent closing by clicking outside
                didOpen: () => {
                    Swal.showLoading(); // Show loading spinner
                },
                willClose: () => {
                    console.log('Exciting alert closed after 5 seconds!');
                    Swal.fire({
                        title: "Order Sent!",
                        text: "Your order in on queue.",
                        icon: "success"
                    }).then((result) => {

                        // $location.path('./menu');
                        location.href = './';
                    });
                }
            });
            ApiService.submitOrder(storeCode, $scope.customerName, $scope.customerId, $scope.customerNotes).then(function (data) {
                $scope.fetchData();
                $scope.closeCartSheet();
                $scope.apiService.totalCartAmount = 0;
            });
        }


    }]);
