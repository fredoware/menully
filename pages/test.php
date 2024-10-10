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

  $catId = 0;
  if (isset($_GET["catId"])) {
    $catId = $_GET["catId"];
    $cat = menuCategory()->get("Id=$catId");
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

.btn-fab {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    background: white;
    border-radius: 30px;
    padding: 15px;
    font-size: 20px;
    font-weight: 900;
    border: 0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
}

.btn-add {
    position: absolute;
    bottom: 5px;
    right: 5px;
    z-index: 1000;
    background: var(--color-secondary);
    color: white;
    border-radius: 30px;
    padding: 10px;
    font-size: 20px;
    font-weight: 900;
    border: 0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
}

.price-tag {
    color: var(--color-primary);
    font-weight: bold;
}


.cart {
    background: green;
    padding: 20px;
}

.cart-main {
    width: 100%;
    position: fixed;
    z-index: 1000;
    bottom: 0px;
    left: 0px;
    margin: 0px;
}

.spinner-wrapper {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    z-index: 1000;
    background: rgba(248, 248, 251, 0.7);
    text-align: center;
    padding-top: 200px;
}

.category-name {
    font-weight: bold;
    padding-bottom: 5px;
}

.home-item {
    font-weight: bold;
    margin-top:20px;
    font-size:20px;
    text-transform:uppercase;
    letter-spacing: 3px;
    color: #626363;
    /* text-shadow: 2px 2px #000; */
}
</style>

<div class="container-fluid bg-white cover-size">
    <div class="spinner-wrapper" ng-show="pageSpinner">
        <div class="spinner-border"></div>
    </div>

    <?php if (isset($_GET["catId"])): ?>
    <a class="btn-fab clickable" href="test"><i class="bi bi-arrow-left"></i></a>
    <?php endif; ?>

 
    <img src="../media/<?=$store->logo?>" class="logo">
    <img src="../media/<?=$store->cover?>" class="cover-photo">
    <div class="card menu-content">
        <div class="card-body text-center">

            <?php if (!isset($_GET["catId"])): ?>
            <div class="row">
                <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="?isBestSellers=1" ng-click="spinner()">
                    <div class="card clickable" style="height:100px;">
                        <div class="card-body">
                            <div class="home-item">Best Sellers</div>
                        </div>
                    </div>
                </a>
                <a class="col-lg-4 col-md-6 mt-2" ng-repeat="item in categoryList" ng-show="categoryDisplay"
                    data-aos="fade-up" href="?catId={{item.Id}}" ng-click="spinner()">
                    <div class="card clickable" style="height:100px;">
                        <div class="card-body">
                            <div class="home-item" ng-bind-html="item.name"></div>
                        </div>
                    </div>
                </a>
            </div>

            <?php else: ?>
            <div class="category-name"><?=$cat->name;?></div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6 mt-2" ng-repeat="item in itemList" ng-show="itemDisplay"
                    ng-click="itemModalContent(item)" data-bs-toggle="modal" data-bs-target="#itemModal">
                    <div data-aos="fade-up">
                        <div class="card">
                            <button class="btn-add"><i class="bi bi-plus"></i></button>
                            <div class="square-container">
                                <img src="../media/{{item.product.image}}" width="100%">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="price-tag">₱{{item.lowestPrice}}</div>
                            <span ng-bind-html="item.product.name"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php endif; ?>

        <div style="height:100px"> </div>

    </div>
</div>
</div>



<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="position:absolute;bottom:0;margin:0;width:100%;">
        <div class="modal-content" style="height:500px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="itemModalLabel">{{itemName}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>


<script>
var app = angular.module("myApp", ['ngSanitize']);

app.controller('myCtrl', function($scope, $http) {
    $scope.categoryList = [];
    $scope.itemList = [];
    $scope.pageSpinner = false;

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


    <?php if (isset($_GET["catId"])): ?>
    $scope.showItem = function() {
        $scope.spinner = true;
        $http({
            method: "GET",
            url: "../pages/api.php?action=item-list",
            params: {
                'categoryId': <?=$catId?>,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.spinner = false;
            $scope.totalRecords = response.data.total;
            $scope.itemList = response.data.list;
            $scope.itemDisplay = true;
            console.log("Validation", response.data)
            $scope.categoryDisplay = false;

        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.showItem();

    <?php endif; ?>


    $scope.spinner = function() {
        $scope.pageSpinner = true;
    };

    $scope.itemModalContent = function(item) {
        $scope.itemName = item.product.name;
    };


});
</script>