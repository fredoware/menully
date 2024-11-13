angular.module('myApp', ['ngRoute', 'ngSanitize'])
    .filter('formatMoney', function () {
        return function (input) {
            if (!input) return input;
            return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        };
    });