angular.module('myApp')
    .controller('MenuController', ['$scope', '$location', 'ApiService', function ($scope, $location, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');

        $scope.clearForm = function () {
            $scope.formData = {
                storeCode: storeCode,
                Id: 0,
                name: '',
                description: '',
                image: null
            };
        }
        $scope.clearForm();

        $scope.handleFileChange = function (element) {
            $scope.formData.image = element.files[0];
            $scope.$apply();
        };

        $scope.fetchData = function (storeCode) {
            $scope.spinner(true);
            ApiService.getCategories(storeCode).then(function (data) {
                $scope.categoryList = data.list;
                $scope.spinner(false);
            });
        };

        $scope.updateCategory = function (item) {
            $scope.formData.Id = item.Id;
            $scope.formData.name = $scope.decodeHtml(item.name);
            $scope.formData.description = $scope.decodeHtml(item.description);
            $scope.openBottomSheet();
        }

        $scope.newCategory = function () {
            $scope.openBottomSheet();
            $scope.clearForm();
        }

        // Initial data fetch
        $scope.fetchData(storeCode);


        $scope.submitForm = function () {
            $scope.closeBottomSheet();
            ApiService.saveCategory($scope.formData)
                .then(function (response) {
                    // Handle success response
                    console.log('Data submitted successfully:', response.data);
                    console.log('Form data:', $scope.formData);
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


        $scope.goToItem = function (itemId) {
            location.href = "./menu-item?Id=" + itemId;
        }

    }]);