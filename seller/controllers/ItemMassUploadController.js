angular.module('myApp')
    .controller('ItemMassUploadController', ['$scope', 'ApiService', function ($scope, ApiService) {
        $scope.title = "ooo";
        $scope.storeLogo = sessionStorage.getItem('storeLogo');
        var storeCode = sessionStorage.getItem('storeCode');

        var queryKey = "status";
        var queryValue = "Draft";

        $scope.clearForm = function () {
            $scope.formData = {
                Id: 0,
                storeCode: storeCode,
                catId: null,
                quantity: 0,
                name: '',
                description: '',
                isAvailable: 1,
                isBestSeller: 0,
                description: '',
                image: null
            };

            $scope.varations = [];
            $scope.varations.push({ unit: null, price: null });
        }
        $scope.clearForm();

        $scope.handleFileChange = function (element) {
            $scope.formData.image = element.files[0];
            $scope.$apply();
        };

        // Fetch data from the API
        $scope.fetchData = function () {

            ApiService.getItems(queryKey, queryValue, storeCode).then(function (data) {
                $scope.itemList = data.list;
                $scope.title = $scope.decodeHtml(data.title);
            });
        };
        // Initial data fetch
        $scope.fetchData();


        $scope.getCategoryOptions = function () {
            ApiService.getCategories(storeCode).then(function (data) {
                $scope.categoryOptions = data.list;
            });
        };

        $scope.getCategoryOptions();

        $scope.newItem = function () {
            $scope.bottomSheetState = 'massUpload';
            $scope.openBottomSheet();
            $scope.clearForm();
        }

        $scope.updateItem = function (item) {
            $scope.bottomSheetState = 'form';
            console.log("item detail", item.variation[0].unit);
            $scope.openBottomSheet();
            $scope.clearForm();
            $scope.formData.Id = item.product.Id;
            $scope.formData.isForSale = item.product.isForSale;
            $scope.formData.catId = item.product.menuCategoryId != null ? item.product.menuCategoryId.toString() : '';
            $scope.formData.isAvailable = item.product.isAvailable;
            $scope.formData.quantity = item.product.quantity;
            $scope.formData.isBestSeller = item.product.isBestSeller;
            $scope.formData.Id = item.product.Id;
            $scope.formData.name = $scope.decodeHtml(item.product.name);
            $scope.formData.description = $scope.decodeHtml(item.product.description);

            $scope.varations = [];
            for (const vari in item.variation) {
                $scope.varations.push({ unit: item.variation[vari].unit, price: item.variation[vari].price });
            }

        }


        // Function to add a new price variation
        $scope.addVaration = function () {
            $scope.varations.push({ unit: null, price: null });
        };

        // Function to remove a specific price variation
        $scope.removeVaration = function (index) {
            $scope.varations.splice(index, 1);
        };

        $scope.submitForm = function () {
            $scope.closeBottomSheet();
            ApiService.saveItem($scope.formData, $scope.varations)
                .then(function (response) {
                    // Handle success response
                    console.log('Data submitted successfully:', response.data);
                    console.log('Form data:', $scope.formData);
                    // Reset form
                    // $scope.clearForm();
                    $scope.fetchData();
                    $scope.getCategoryOptions();
                })
                .catch(function (error) {
                    // Handle error response
                    console.error('Error occurred:', error);
                    $scope.message = "An error occurred while submitting data.";
                });
        };

        $scope.deleteItem = function (item) {
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
                    ApiService.deleteItem(item.product.Id).then(function (data) {
                        $scope.fetchData(storeCode);
                        Swal.fire({
                            title: "Deleted!",
                            text: "Item has been deleted.",
                            icon: "success"
                        });
                    });
                }
            });
        }


        $scope.uploadCsv = function () {
            if (!$scope.csvFile) {
                alert('Please select a CSV file to upload.');
                return;
            }

            console.log("csv file", $scope.csvFile);

            ApiService.uploadCsv($scope.csvFile, storeCode)
                .then(function (response) {
                    $scope.fetchData();
                })
                .catch(function (error) {
                    // Handle error response
                    console.error('Error occurred:', error);
                    $scope.message = "An error occurred while submitting data.";
                });

        };

    }]);
