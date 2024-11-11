<?php
  include "../pages/templates/header-test.php";

  $cart = $_SESSION["cart"];

  $totalAmount = 0;
  $totalQuantity = 0;

  foreach ($cart as $key => $qty){
    $item = menuItem()->get("Id=$key");
    $totalAmount += $item->price*$qty;
    $totalQuantity += $qty;
  }

?>

<style>
.logo {
    width: 100px;
    z-index: 10;
    position: absolute;
    top: 50px;
    left: 0;
    right: 0;
    margin-inline: auto;
    border-radius: 50px;
}

.cover-photo {
    width: 100%;
    filter: blur(4px);
}

.cover-size {
    padding: 0px;
    position: relative;
}

.menu-content {
    position: absolute;
    top: 180px;
    z-index: 10;
    min-height: 500px;
    width: 100%;
    border-radius: 25px;
}
</style>


<button class="btn btn-primary" ng-click="backButton()"><i class="bi bi-arrow-left"></i></button>

<div class="row justify-content-center" style="background:#f0eeeb">
    <div class="col-lg-6 col-md-10 col-sm-12 bg-white cover-size">
        <img src="../media/<?=$store->logo?>" class="logo">
        <img src="../media/<?=$store->logo?>" class="cover-photo">
        <div class="card menu-content">
            <div class="card-body">

                <div class="row" ng-repeat="item in categoryList" ng-show="categoryDisplay">
                    <div class="col-12 mt-2">
                        <div class="card" ng-click="showItem(item)">
                            <div class="card-body">
                                <b>{{item.name}}</b>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" ng-repeat="cat in categoryForItemList">
                    <div class="col-12 mt-2" ng-repeat="item in itemList[cat.Id]" ng-show="itemDisplay(cat.Id)">
                        <div class="card">
                            <div class="card-body">
                                {{item.name}}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>


<script>
var app = angular.module("myApp", []);
app.controller('myCtrl', function($scope, $http) {
    $scope.categoryList = [];
    $scope.itemList = [];
    $scope.categoryDisplay = true;
    $scope.categoryDisplay = true;
    $scope.itemId = 0;

    $scope.getCategories = function() {
        $http({
            method: "GET",
            url: "../pages/api.php?action=category-list",
            params: {
                'storeId': <?=$store->Id?>,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.totalRecords = response.data.total;
            $scope.categoryList = response.data.list;
            $scope.categoryForItemList = response.data.list;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.getCategories();

    $scope.showItem = function(item) {
        $http({
            method: "GET",
            url: "../pages/api.php?action=item-list",
            params: {
                'categoryId': item.Id,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.totalRecords = response.data.total;
            $scope.itemList[item.Id] = response.data.list;
            console.log("Validation", response.data)
            $scope.categoryDisplay = false;
            $scope.itemId = item.Id;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.itemDisplay = function(itemId) {
        return $scope.itemId = itemId;
    };

    $scope.backButton = function() {
        $scope.categoryDisplay = true;
    };



});
</script>