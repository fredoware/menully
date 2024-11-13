angular.module('myApp')
    .controller('OrderController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');

        // Example usage: Get the 'id' query parameter
        var status = $scope.getQueryParam('status');
        console.log('ID parameter:', status);

        // Assign to scope variable to display in view
        $scope.message = status + " Orders";

        // Fetch data from the API
        $scope.fetchData = function (storeCode, status) {
            ApiService.getOrderData(storeCode, status).then(function (data) {
                $scope.orderList = data;
            });
        };

        // Initial data fetch
        $scope.fetchData(storeCode, status);

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

        $scope.changeOrderStatus = function (itemId) {
            $scope.closeBottomSheet();
            $scope.spinner(true);
            ApiService.changeOrderStatus(itemId, $scope.nextStatus).then(function (data) {
                $scope.fetchData(storeCode, status);
                $scope.spinner(false);
            });
        }

    }]);