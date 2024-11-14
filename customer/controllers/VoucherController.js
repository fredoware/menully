angular.module('myApp')
    .controller('VoucherController', ['$scope', '$location', 'ApiService', function ($scope, $location, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');
        var deviceId = sessionStorage.getItem('userIdSession');
        ApiService.showCartBanner = false;
        ApiService.backButton = './cart';

        $scope.fetchData = function () {
            $scope.spinner(true);
            ApiService.getVouchers(storeCode, deviceId).then(function (data) {
                $scope.spinner(false);
                console.log("storeCode", storeCode);
                console.log("deviceId", deviceId);
                console.log("vouchers", data);
                $scope.vouchers = data.vouchers;
                $scope.myVouchers = data.myVouchers;
            });
        };

        // Initial data fetch
        $scope.fetchData();


        $scope.claimVoucher = function (item) {
            ApiService.claimVoucher(deviceId, item.voucher.Id).then(function (data) {
                $scope.fetchData();
                Swal.fire({
                    title: "Congratulations!",
                    text: "You successfully claimed this voucher!",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Use now!",
                    cancelButtonText: "Next Time"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $scope.useVoucher(item);
                    }
                });
            });
        }

        $scope.useVoucher = function (item) {
            console.log("minSpend", item.voucher.minimumSpend);
            console.log("totalAmount", ApiService.totalCartAmount);
            if (item.voucher.minimumSpend > ApiService.totalCartAmount) {
                Swal.fire({
                    title: "Warning",
                    text: "Minimum spend must be " + item.voucher.minimumSpend,
                    icon: "error"
                });
            }
            else {
                sessionStorage.setItem('voucherId', item.voucher.Id);
                sessionStorage.setItem('voucherName', item.voucher.name);
                sessionStorage.setItem('voucherMinSpend', item.voucher.minimumSpend);
                $location.path("/cart");
            }
        }


        // ===============================================================

        $scope.clearForm = function () {
            $scope.formData = {
                storeCode: storeCode,
                Id: 0,
                discount: null,
                type: 'Discount',
                name: '',
                minimumSpend: '',
                quantity: '',
                validUntil: '',
                validUntilFormatted: '',
                status: 'Active',
            };
        }
        $scope.clearForm();

        // This is to help modify the format of date time
        $scope.updateDateTime = function (event) {
            $scope.formData.validUntil = event.target.value;
            $scope.formData.validUntilFormatted = $scope.dateTimeToString($scope.formData.validUntil);
        };


        $scope.updateVoucher = function (item) {
            $scope.formData.Id = item.Id;
            $scope.formData.type = item.type;
            $scope.formData.discount = item.discount;
            $scope.formData.quantity = item.currentQuantity;
            $scope.formData.minimumSpend = item.minimumSpend;
            $scope.formData.validUntil = $scope.stringToDateTime(item.validUntil);
            $scope.formData.validUntilFormatted = item.validUntil;
            $scope.formData.status = item.status;
            $scope.formData.name = $scope.decodeHtml(item.name);
            $scope.openBottomSheet();
        }


        $scope.newCategory = function () {
            $scope.openBottomSheet();
            $scope.clearForm();
        }

        $scope.deleteVoucher = function (item) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    ApiService.deleteVoucher(item.Id).then(function (data) {
                        $scope.fetchData(storeCode);
                        Swal.fire({
                            title: "Deleted!",
                            text: "Voucher has been deleted.",
                            icon: "success"
                        });
                    });
                }
            });
        }


        $scope.submitForm = function () {
            console.log('Form data:', $scope.formData);
            $scope.closeBottomSheet();
            ApiService.saveVoucher($scope.formData)
                .then(function (response) {
                    // Handle success response
                    console.log('Data submitted successfully:', response.data);
                    // Reset form
                    $scope.clearForm();
                    $scope.fetchData(storeCode);
                })
                .catch(function (error) {
                    // Handle error response
                    console.error('Error occurred:', error);
                    $scope.message = "An error occurred while submitting data.";
                });
        };


    }]);