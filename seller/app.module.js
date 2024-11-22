angular.module('myApp', ['ngRoute', 'ngSanitize'])

    .filter('formatMoney', function () {
        return function (input) {
            if (!input) return input;
            return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        };
    })

    .filter('formatText', function () {
        return function (input) {
            var txt = document.createElement("textarea");
            txt.innerHTML = input;
            return txt.value;
        };
    })

    .filter('format12hour', function () {
        return function (hour) {
            if (!hour) return '';
            const period = hour >= 12 ? "PM" : "AM";
            const formattedHour = hour % 12 || 12;
            return `${formattedHour}:00 ${period}`;
        };
    })

    .directive('fileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function () {
                    scope.$apply(function () {
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    }]);