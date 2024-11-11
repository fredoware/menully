angular.module('myApp')
    .config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/home.php',
                controller: 'HomeController'
            })
            .when('/orders', {
                templateUrl: 'views/orders.php',
                controller: 'OrderController'
            })
            .when('/about', {
                templateUrl: 'views/about.php',
                controller: 'AboutController'
            })
            .when('/menu-setup', {
                templateUrl: 'views/menuSetup.php',
                controller: 'MenuController'
            })
            .when('/menu-item', {
                templateUrl: 'views/menuItem.php',
                controller: 'ItemController'
            })
            .when('/voucher-setup', {
                templateUrl: 'views/voucherSetup.php',
                controller: 'VoucherController'
            })
            .when('/feedback', {
                templateUrl: 'views/feedback.php',
                controller: 'FeedbackController'
            })
            .when('/reports', {
                templateUrl: 'views/reports.php',
                controller: 'ReportController'
            })
            .when('/notification', {
                templateUrl: 'views/notification.php',
                controller: 'NotificationController'
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