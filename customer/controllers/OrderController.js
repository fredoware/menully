angular.module('myApp')
    .controller('OrderController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        var deviceId = sessionStorage.getItem('userIdSession');

        // Fetch data from the API
        $scope.fetchData = function () {
            ApiService.getOrderData(storeCode, deviceId).then(function (data) {
                $scope.orderList = data;
            });
        };

        // Initial data fetch
        $scope.fetchData();

        $scope.orderModalContent = function (item) {
            $scope.openBottomSheet();
            $scope.orderItemList = item.items;
            $scope.orderInfo = item.main;
            $scope.orderMainTotal = item.total;
            if (item.main.voucherId) {
                $scope.orderVoucher = item.voucher;
            }

            switch (item.main.status) {
                case "Pending":
                    $scope.nextStatus = "Confirmed";
                    break;

                case "Confirmed":
                    $scope.nextStatus = "Ready";
                    break;

                case "Ready":
                    $scope.nextStatus = "Delivered";
                    break;

                default:
                    break;
            }
        };

        $scope.cardColor = function (isPaid) {
            $result = "card unpaid-order-card";
            if (isPaid) {
                $result = "card paid-order-card";
            }
            return $result;
        }


        $scope.paymentStatus = function (isPaid) {
            $result = "Unpaid";
            if (isPaid) {
                $result = "Paid";
            }
            return $result;
        };


        $scope.markAsPaid = function (itemId) {
            $scope.spinner(true);
            $scope.closeBottomSheet();
            ApiService.markOrderAsPaid(itemId, 1).then(function (data) {
                $scope.orderInfo.isPaid = 1;
                $scope.spinner(false);
            });
        }

        $scope.changeOrderStatus = function (itemId, status) {
            $scope.closeBottomSheet();
            $scope.spinner(true);
            ApiService.changeOrderStatus(itemId, status).then(function (data) {
                $scope.fetchData(storeCode, status);
                $scope.spinner(false);
            });
        }

    }]);