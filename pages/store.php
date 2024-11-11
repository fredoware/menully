<?php
  include "../pages/templates/header-seller.php";


?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" ng-click="closeNav()">&times;</a>

    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('notification')">
            Notifications
        </a>
        <!-- First Menu Item -->
        <a href="#submenu1" class="list-group-item list-group-item-action ps-3" data-bs-toggle="collapse"
            aria-expanded="false">
            Orders
            <i class="fa fa-angle-right float-end toggle-icon me-2 mt-1"></i>
        </a>
        <div class="collapse" id="submenu1">
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('Pending')">Pending</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('Confirmed')">Confirmed</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('Ready')">Ready</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('Delivered')">Delivered</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('Canceled')">Canceled</a>
        </div>
        <a href="#submenu2" class="list-group-item list-group-item-action ps-3" data-bs-toggle="collapse"
            aria-expanded="false">
            Store Settings
            <i class="fa fa-angle-right float-end toggle-icon me-2 mt-1"></i>
        </a>
        <div class="collapse" id="submenu2">
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('menu')">Menu Set Up</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('voucher')">Voucher Set Up</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('bestSeller')">Best
                Sellers!</a>
            <a href="#" class="list-group-item list-group-item-action" ng-click="showPage('unavailable')">Unavailable
                Items</a>
        </div>


        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('feedback')">Customer's
            Feedback</a>
        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('people')">People</a>
        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('qrCode')">Store QR Code</a>
        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('customer')">Customer's
            View</a>
        <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="showPage('logout')">Log out</a>

    </div>
</div>

<div class="container-fluid bg-white cover-size">
    <div class="spinner-wrapper" ng-show="pageSpinner">
        <div class="spinner-border"></div>
    </div>

 
    <button class="btn-fab-back clickable" ng-show="menuButton" ng-click="openNav()"><i class="bi bi-list"></i></button>

    <img src="../media/<?=$store->logo?>" class="logo">
    <img src="../media/<?=$store->cover?>" class="cover-photo">

    <div class="card menu-content">
        <div class="card-body">

            <div ng-include="'../pages/store-pages/' + pageView"></div>

        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all collapse toggles
    const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

    collapseToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const icon = toggle.querySelector('.toggle-icon');
            const targetId = toggle.getAttribute('href');
            const target = document.querySelector(targetId);

            target.addEventListener('shown.bs.collapse', function() {
                icon.classList.replace('fa-angle-right', 'fa-angle-down');
            });

            target.addEventListener('hidden.bs.collapse', function() {
                icon.classList.replace('fa-angle-down', 'fa-angle-right');
            });
        });
    });
});
</script>


<script>
var loadFile = function(event, imgId) {
    var output = document.getElementById(imgId);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};


var app = angular.module("myApp", ['ngAnimate']);

app.directive('fileModel', ['$parse', function($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function() {
                scope.$apply(function() {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);


app.controller('myCtrl', function($scope, $http) {
    $scope.pageSpinner = false;
    $scope.menuButton = true;
    $scope.currentPage = 'notification';
    $scope.pageView = 'notification.php';

    const order = new Order($scope, $http, '<?=$store->storeCode?>');

    $scope.openNav = function() {
        $scope.menuButton = false;
        document.getElementById("mySidenav").style.width = "250px";
    }

    $scope.closeNav = function() {
        $scope.menuButton = true;
        document.getElementById("mySidenav").style.width = "0";
    }

    $scope.cardColor = function(isPaid){
      $result = "card unpaid-order-card";
        if (isPaid) {
          $result = "card paid-order-card";
        }
        return $result;
    }

    $scope.showPage = function(page) {
        $scope.closeNav();
        $scope.currentPage = page;
        switch (page) {
            case "notification":
                $scope.pageView = "notification.php";
                break;

            case "Pending":
                $scope.pageView = "orders.php";
                order.orderList(page);
                break;

            case "Confirmed":
                $scope.pageView = "orders.php";
                order.orderList(page);
                break;

            case "Ready":
                $scope.pageView = "orders.php";
                order.orderList(page);
                break;

            case "Delivered":
                $scope.pageView = "orders.php";
                order.orderList(page);
                break;

            case "Canceled":
                $scope.pageView = "orders.php";
                order.orderList(page);
                break;

            case "menu":
                pageName($scope, page);
                break;

            case "voucher":
                pageName($scope, page);
                break;

            case "bestSeller":
                pageName($scope, page);
                break;

            case "unavailable":
                pageName($scope, page);
                break;



            case "feedback":
                pageName($scope, page);
                break;

            case "people":
                pageName($scope, page);
                break;

            case "qrCode":
                pageName($scope, page);
                break;

            case "customer":
                pageName($scope, page);
                break;

            case "logout":
                pageName($scope, page);
                break;

            default:
                // Code to execute if none of the cases match
        }
    }
});
</script>

<script src="../pages/store-js/test.js"></script>
<script src="../pages/store-js/orderList.js"></script>