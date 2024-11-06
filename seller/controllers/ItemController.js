angular.module('myApp')
    .controller('ItemController', ['$scope', 'ApiService', function ($scope, ApiService) {
        $scope.category = "Category";
        $scope.storeLogo = sessionStorage.getItem('storeLogo');
        var storeCode = sessionStorage.getItem('storeCode');

        var catId = $scope.getQueryParam('Id');

        $scope.clearForm = function () {
            $scope.formData = {
                Id: 0,
                storeCode: storeCode,
                catId: catId,
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
            ApiService.getItems(catId).then(function (data) {
                $scope.itemList = data.list;
                $scope.category = $scope.decodeHtml(data.category);
            });
        };
        // Initial data fetch
        $scope.fetchData();

        $scope.newItem = function () {
            $scope.openBottomSheet();
            $scope.clearForm();
        }

        $scope.updateItem = function (item) {
            console.log("item detail", item.variation[0].unit);
            $scope.openBottomSheet();
            $scope.clearForm();
            $scope.formData.Id = item.product.Id;
            $scope.formData.isAvailable = item.product.isAvailable;
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
                })
                .catch(function (error) {
                    // Handle error response
                    console.error('Error occurred:', error);
                    $scope.message = "An error occurred while submitting data.";
                });
        };

    }]);