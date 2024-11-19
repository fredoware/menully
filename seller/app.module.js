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