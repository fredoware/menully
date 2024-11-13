angular.module('myApp')
    .controller('AboutController', ['$scope', 'ApiService', function($scope, ApiService) {
        $scope.message = "Welcome to the About Page!";
        $scope.formData = {
            title: '',
            body: ''
        };

        $scope.submitForm = function() {
            ApiService.postData($scope.formData)
                .then(function(response) {
                    // Handle success response
                    console.log('Data submitted successfully:', response.data);
                    $scope.message = "Data submitted successfully!";
                    // Reset form
                    $scope.formData = { title: '', body: '' };
                })
                .catch(function(error) {
                    // Handle error response
                    console.error('Error occurred:', error);
                    $scope.message = "An error occurred while submitting data.";
                });
        };
    }]);
