angular.module('myApp')
    .controller('FeedbackController', ['$scope', 'ApiService', '$location', function ($scope, ApiService, $location) {
        var storeCode = sessionStorage.getItem('storeCode');
        var name = sessionStorage.getItem('userSession');


        $scope.rating = 0; // Default selected rating
        $scope.hoverRatingValue = 0; // Tracks hover state
        $scope.stars = new Array(5); // Create an array for 5 stars

        // Set the rating when a star is clicked
        $scope.setRating = function (newRating) {
            $scope.rating = newRating;
        };

        // Trigger star glow on hover
        $scope.hoverRating = function (hoverValue) {
            $scope.hoverRatingValue = hoverValue;
        };

        // Reset star glow when hover ends
        $scope.resetHover = function () {
            $scope.hoverRatingValue = 0;
        };

        $scope.submitFeedback = function () {
            if ($scope.rating == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Warning",
                    text: "Don't forget to add some starts!",
                });
                return;
            }
            ApiService.submitFeedback(storeCode, name, $scope.rating, $scope.feedback).then(function (data) {
            });

            Swal.fire({
                icon: 'success', // Display a success icon
                title: 'Thank You!',
                text: 'We appreciate your feedback. It helps us improve!',
                confirmButtonText: 'Close'
            });

            $location.path("/");

            console.log("feedback", $scope.rating + " -" + $scope.feedback);
        }

    }]);
