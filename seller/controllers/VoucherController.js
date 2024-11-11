angular.module('myApp')
    .controller('VoucherController', ['$scope', '$location', 'ApiService', function ($scope, $location, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');

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

        $scope.fetchData = function (storeCode) {
            $scope.spinner(true);
            ApiService.getVouchers(storeCode).then(function (data) {
                $scope.voucherList = data;
                $scope.spinner(false);
            });
        };

        // Initial data fetch
        $scope.fetchData(storeCode);

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