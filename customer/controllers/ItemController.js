angular.module('myApp')
    .controller('ItemController', ['$scope', 'ApiService', function ($scope, ApiService) {
        ApiService.backButton = "./menu";
        ApiService.showCartBanner = true;
        $scope.title = "ooo";
        $scope.storeLogo = sessionStorage.getItem('storeLogo');
        var storeCode = sessionStorage.getItem('storeCode');

        var queryKey = "";
        var queryValue = "";
        var catId = $scope.getQueryParam('Id');
        if (catId) {
            queryKey = "menuCategoryId";
            queryValue = catId;
        }
        var isAvailable = $scope.getQueryParam('isAvailable');
        if (isAvailable) {
            queryKey = "isAvailable";
            queryValue = isAvailable;
        }
        var isBestSeller = $scope.getQueryParam('isBestSeller');
        if (isBestSeller) {
            queryKey = "isBestSeller";
            queryValue = isBestSeller;
        }


        $scope.openItem = function (item) {
            console.log("item detail", item.variation[0].unit);
            $scope.openBottomSheet();
            $scope.thisItem = item.product;
            $scope.selectedPrice = item.lowestPrice;
            $scope.selectedVarId = item.varId;
            $scope.selectedQuantity = 1;

            $scope.varations = [];
            for (const vari in item.variation) {
                $scope.varations.push({ Id: item.variation[vari].Id, unit: item.variation[vari].unit, price: item.variation[vari].price });
            }

        }

        $scope.updateQuantity = function (newQuantity) {
            if (newQuantity != 0) {
                $scope.selectedQuantity = newQuantity;
            }
        };

        $scope.updateSelectedPrice = function (selected) {
            $scope.selectedPrice = selected.price;
            $scope.selectedVarId = selected.Id;
        }

        $scope.addToCart = function () {
            $scope.closeBottomSheet();

            $scope.apiService.totalCartAmount = parseFloat($scope.apiService.totalCartAmount) + (parseFloat($scope.selectedPrice) * parseInt($scope.selectedQuantity));
            $scope.apiService.totalCartQuantity = parseInt($scope.apiService.totalCartQuantity) + parseInt($scope.selectedQuantity);

            ApiService.addToCart($scope.selectedVarId, $scope.selectedQuantity).then(function (data) {
            });
        }


        // Fetch data from the API
        $scope.fetchData = function () {
            ApiService.getItems(queryKey, queryValue, storeCode).then(function (data) {
                $scope.itemList = data.list;
                $scope.title = $scope.decodeHtml(data.title);
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

    }]);
