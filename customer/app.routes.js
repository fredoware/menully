angular.module('myApp')
    .config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/home.php',
                controller: 'HomeController'
            })
            .when('/menu', {
                templateUrl: 'views/menu.php',
                controller: 'MenuController'
            })
            .when('/menu-item', {
                templateUrl: 'views/menuItem.php',
                controller: 'ItemController'
            })
            .when('/cart', {
                templateUrl: 'views/cart.php',
                controller: 'CartController'
            })
            .otherwise({
                redirectTo: '/' // Default route
            });

        // Enable HTML5 Mode
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false // Set to true if you are using a base tag in your HTML
        });
    }]);