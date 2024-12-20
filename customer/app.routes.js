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
            .when('/settings', {
                templateUrl: 'views/settings.php',
                controller: 'SettingsController'
            })
            .when('/vouchers', {
                templateUrl: 'views/vouchers.php',
                controller: 'VoucherController'
            })
            .when('/history', {
                templateUrl: 'views/history.php',
                controller: 'OrderController'
            })
            .when('/notification', {
                templateUrl: 'views/notification.php',
                controller: 'NotificationController'
            })
            .when('/feedback', {
                templateUrl: 'views/feedback.php',
                controller: 'FeedbackController'
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