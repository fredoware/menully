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

.btn-fab{
  position: fixed;
  top: 20px;
  left: 30px;
  z-index: 1000;
  background: white;
  border-radius: 30px;
  padding: 15px;
  font-size: 20px;
  font-weight: 900;
  border: 0px;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 3px 10px 0 rgba(0,0,0,0.19);
}

.cart{
  background: green;
  padding: 20px;
}

.cart-main{
  width: 100%;
  position: fixed;
  z-index: 1000;
  bottom: 0px;
  left: 0px;
  margin: 0px;
}

</style>



<div class="row" style="background:#f0eeeb">
    <div class="col bg-white cover-size">
      
<button class="btn-fab" ng-click="backButton()" ng-show="btnBack"><i class="bi bi-arrow-left"></i></button>


<div class="row justify-content-center cart-main">
<div class="col-lg-6 col-md-10 col-sm-12 cart">thi si your card</div>
</div>
        <img src="../media/<?=$store->logo?>" class="logo">
        <img src="../media/<?=$store->logo?>" class="cover-photo">
        <div class="card menu-content">
            <div class="card-body">

                <div class="row" ng-repeat="item in categoryList" ng-show="categoryDisplay">
                    <div class="col-12 mt-2">
                        <div class="card" ng-click="showItem(item)" style="height:100px;">
                            <div class="card-body">
                                {{item.name}}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" ng-repeat="item in itemList" ng-show="itemDisplay">
                    <div class="col-12 mt-2">
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
</div>


<?php include "templates/footer.php"; ?>


<script>
var app = angular.module("myApp", []);
app.controller('myCtrl', function($scope, $http) {
    $scope.categoryList = [];
    $scope.itemList = []; 
    $scope.btnBack = false;

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
            $scope.categoryDisplay = true;
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
            $scope.itemList= response.data.list;
            $scope.itemDisplay = true;
            console.log("Validation", response.data)
            $scope.categoryDisplay = false;
            $scope.btnBack = true;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };


    $scope.backButton = function() {
        $scope.categoryDisplay = true;
        $scope.btnBack = false;
        $scope.itemDisplay = false;
    };



});
</script>