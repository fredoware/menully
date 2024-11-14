angular.module('myApp')
    .controller('CartController', ['$scope', 'ApiService', '$location', function ($scope, ApiService, $location) {
        var storeCode = sessionStorage.getItem('storeCode');
        $scope.storeLogo = sessionStorage.getItem('storeLogo');
        $scope.customerName = sessionStorage.getItem('userSession');
        $scope.tableId = sessionStorage.getItem('tableId');
        $scope.tableName = sessionStorage.getItem('tableName');
        $scope.customerId = sessionStorage.getItem('userIdSession');
        $scope.voucherId = sessionStorage.getItem('voucherId');
        $scope.voucherName = sessionStorage.getItem('voucherName');
        $scope.voucherMinSpend = sessionStorage.getItem('voucherMinSpend');
        ApiService.showCartBanner = false;
        ApiService.backButton = true;
        $scope.orderFormDisplay = true;
        let cart = JSON.parse(sessionStorage.getItem('cart')) || [];


        // Fetch data from the API
        $scope.fetchData = function () {
            ApiService.getCart(cart).then(function (data) {
                $scope.cartList = data.list;
            });
        };
        // Initial data fetch
        $scope.fetchData();


        $scope.updateItemQuantity = function (item, number) {
            item.quantity = parseInt(item.quantity) + parseInt(number);
            item.total = item.variation.price * item.quantity;

            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

            var id = item.variation.Id;
            var quantity = item.quantity;

            // Check if the item with the given ID already exists in the cart
            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                // If the item exists, update its quantity
                existingItem.quantity = quantity;
            }

            // Save the updated cart back to sessionStorage
            sessionStorage.setItem('cart', JSON.stringify(cart));

            console.log('Updated Cart:', cart);
            ApiService.cart = cart.length;
            $scope.apiService.updateCartService(false);
        };


        $scope.openOrderForm = function () {
            $scope.orderFormDisplay = false;
            $scope.openBottomSheet();
        }

        $scope.closeCartSheet = function () {
            $scope.orderFormDisplay = true;
            $scope.closeBottomSheet(false);
        }

        $scope.removeVoucher = function () {
            sessionStorage.removeItem('voucherId');
            sessionStorage.removeItem('voucherName');
            sessionStorage.removeItem('voucherMinSpend');

            $scope.voucherId = sessionStorage.getItem('voucherId');
            $scope.voucherName = sessionStorage.getItem('voucherName');
            $scope.voucherMinSpend = sessionStorage.getItem('voucherMinSpend');
        }

        $scope.submitOrder = function () {
            if ($scope.voucherId) {
                console.log("submit status", "with voucher");
                console.log("submit totalAmount", $scope.apiService.totalCartAmount);
                console.log("submit minSpend", $scope.voucherMinSpend);
                if ($scope.voucherMinSpend > $scope.apiService.totalCartAmount) {
                    Swal.fire({
                        title: "Warning",
                        text: "Minimum spend must be " + $scope.voucherMinSpend,
                        icon: "error"
                    });
                    return;
                }
            }

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
                    });
                }
            });
            ApiService.submitOrder(storeCode, $scope.customerName, $scope.customerId, $scope.customerNotes, $scope.voucherId, cart, $scope.tableId).then(function (data) {
                $scope.closeCartSheet();
                sessionStorage.removeItem('cart');
                sessionStorage.removeItem('voucherId');
                sessionStorage.removeItem('voucherName');
                sessionStorage.removeItem('voucherMinSpend');

                $location.path('/');

                ApiService.updateCartService();
            });
        }

    }]);
