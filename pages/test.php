<?php
  include "../pages/templates/header-test.php";

  
  $cart = $_SESSION["cart"];
  $totalAmount = 0;
  $totalQuantity = 0;

  foreach ($cart as $key => $qty){
    $item = variation()->get("Id=$key");
    $totalAmount += $item->price*$qty;
    $totalQuantity += $qty;
  }

$page = "main";

  $catId = 0;
  if (isset($_GET["catId"])) {
    $catId = $_GET["catId"];
    $cat = menuCategory()->get("Id=$catId");
    $title = $cat->name;
    $page = "category";
  }

  if (isset($_GET["isBestSeller"])) {
    $title = "Best Sellers";
    $page = "bestSeller";
  }

  if (isset($_GET["cart"])) {
    $page = "cart";
  }
  if (isset($_GET["voucher"])) {
    $page = "voucher";
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
    padding: 20px;
}

.cart .card {
    background: var(--color-primary);
    color: white;
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
    margin-bottom: 5px;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #626363;
}

.home-item {
    font-weight: bold;
    margin-top: 20px;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #626363;
    /* text-shadow: 2px 2px #000; */
}

.product-modal {
    position: absolute;
    bottom: 0;
    margin: 0;
    width: 100%;
}

.product-modal .modal-footer {
    height: 100px;
}

.add-to-cart {
    width: 100%;
    padding: 10px;
}

.btn-cart {
    padding: 10px 20px 10px 20px;
}
</style>

<div class="container-fluid bg-white cover-size">
    <div class="spinner-wrapper" ng-show="pageSpinner">
        <div class="spinner-border"></div>
    </div>

    <?php if ($page!="main"): ?>
    <a class="btn-fab clickable" href="test" ng-click="spinner()"><i class="bi bi-arrow-left"></i></a>
    <?php endif; ?>


    <a class="row justify-content-center cart-main" href="?cart=1" ng-show="cartSection">
        <div class="col-lg-6 col-md-10 col-sm-12 cart">
            <div class="card text-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            {{totalCartQuantity}}
                        </div>
                        <div class="col">
                            View your cart
                        </div>
                        <div class="col-3">
                            {{totalCartAmount}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <div class="row justify-content-center cart-main" ng-show="checkoutSection">
        <div class="col-lg-6 col-md-10 col-sm-12">
            <div class="card text-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mt-3 mb-3">
                            Voucher:
                        </div>
                        <a class="col-6 mt-3" href="?voucher=1">
                            Select Voucher <i class="bi bi-chevron-right"></i>
                        </a>
                        <div class="col-6 mt-3 mb-3">
                            Total:
                        </div>
                        <div class="col-6">
                            <div class="btn-place-order" data-bs-toggle="modal" data-bs-target="#orderModal">
                                Place Order
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <img src="../media/<?=$store->logo?>" class="logo">
    <img src="../media/<?=$store->cover?>" class="cover-photo">

    <div class="card menu-content">
        <div class="card-body text-center">


            <!-- MAIN PAGE ========================================================================== -->
            <?php if ($page=="main"): ?>
            <div class="row">
                <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="?isBestSeller=1" ng-click="spinner()">
                    <div class="card clickable" style="height:100px;">
                        <div class="card-body">
                            <div class="home-item" style="color:red;">Best Sellers</div>
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


            <?php endif; ?>


            <!-- ITEMS PAGE ========================================================================== -->
            <?php if ($page=="category" || $page=="bestSeller"): ?>
            <div class="category-name"><?=$title;?></div>
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

        <!-- ITEMS PAGE ========================================================================== -->
        <?php if ($page=="cart"): ?>
        <div class="category-name">My Cart</div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mt-2" mt-2" ng-repeat="item in cartList" ng-show="cartItemDisplay(item)">
                <div data-aos="fade-up">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="square-container">
                                        <img src="../media/{{item.product.image}}" width="100%">
                                    </div>
                                </div>
                                <div class="col text-left">
                                    <span ng-bind-html="item.product.name"></span>
                                    <div class="d-flex justify-content-center">
                                        <div class="price-tag">₱{{item.variation.price}}</div> &nbsp; x
                                        {{item.quantity}}
                                    </div>
                                    <br>
                                    <div type="button" ng-click="updateItemQuantity(item,-1)"
                                        class="btn btn-primary btn-cart">-</div>
                                    <div type="button" class="btn btn-primary btn-cart">{{item.quantity}}</div>
                                    <div type="button" ng-click="updateItemQuantity(item,1)"
                                        class="btn btn-primary btn-cart">+</div>
                                    <br><br>
                                    <h3 class="price-tag">₱{{item.total}} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endif; ?>


        <!-- VOUCHER PAGE ========================================================================== -->
        <?php if ($page=="voucher"): ?>
            <div class="category-name">Vouchers</div>
        <div class="row">
      
            <a class="col-lg-4 col-md-6 mt-2" ng-repeat="item in categoryList" ng-show="categoryDisplay"
                data-aos="fade-up" href="?catId={{item.Id}}" ng-click="spinner()">
                <div class="card clickable" style="height:100px;">
                    <div class="card-body">
                        <div class="home-item" ng-bind-html="item.name"></div>
                    </div>
                </div>
            </a>
        </div>


        <?php endif; ?>


        <div style="height:100px"> </div>

    </div>
</div>
</div>



<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog product-modal">
        <div class="modal-content" style="min-height:500px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="itemModalLabel"><span ng-bind-html="productName"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="square-container">
                            <img src="../media/{{productImage}}" width="100%">
                        </div>
                    </div>
                    <div class="col text-center">
                        <span ng-bind-html="productDescription"></span>
                        <h3 class="price-tag">₱{{productPrice}} </h3>
                        <br>
                        {{productUnit}}
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item clickable product-variation" ng-click="selectVariation(vari)"
                        ng-repeat="vari in priceVariation">
                        {{vari.unit}} - {{vari.price}}
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <div class="row" style="width:100%">
                    <div class="col text-center">

                        <div type="button" ng-click="updateQuantity(productQuantity-1)"
                            class="btn btn-primary btn-cart">-</div>
                        <div type="button" class="btn btn-primary btn-cart">{{productQuantity}}</div>
                        <div type="button" ng-click="updateQuantity(productQuantity+1)"
                            class="btn btn-primary btn-cart">+</div>
                    </div>

                    <div class="col">

                        <button type="button" ng-click="addToCart()" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-primary add-to-cart">Add to Cart</button>
                    </div>
                </div>
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
    $scope.totalCartAmount = <?=$totalAmount?>;
    $scope.totalCartQuantity = <?=$totalQuantity?>;
    $scope.cartSection = false;
    $scope.checkoutSection = false;

    if ($scope.totalCartQuantity) {
        $scope.cartSection = true;
    }

    <?php if ($page=="main"): ?>
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

    <?php endif; ?>


    <?php if ($page=="category"): ?>
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


    <?php if ($page=="bestSeller"): ?>
    $scope.showItem = function() {
        $scope.spinner = true;
        $http({
            method: "GET",
            url: "../pages/api.php?action=best-sellers",
            params: {
                'storeId': <?=$store->Id?>,
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


    <?php if ($page=="cart"): ?>
    $scope.cartSection = false;
    $scope.showItem = function() {
        $scope.spinner = true;
        $http({
            method: "GET",
            url: "../pages/api.php?action=cart-list",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.spinner = false;
            $scope.totalRecords = response.data.total;
            $scope.cartList = response.data.list;

        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.showItem();

    if ($scope.totalCartQuantity) {
        $scope.checkoutSection = true;
    }
    <?php endif; ?>


    $scope.spinner = function() {
        $scope.pageSpinner = true;
    };

    $scope.itemModalContent = function(item) {
        $scope.productName = item.product.name;
        $scope.productImage = item.product.image;
        $scope.productDescription = item.product.description;
        $scope.productPrice = item.lowestPrice;
        $scope.productQuantity = 1;
        $scope.productUnit = "";
        $scope.productVarId = item.varId;
        $scope.priceVariation = item.variation;
    };

    $scope.updateQuantity = function(newQuantity) {
        if (newQuantity != 0) {
            $scope.productQuantity = newQuantity;
        }
    };

    $scope.updateItemQuantity = function(item, number) {
        item.quantity = parseInt(item.quantity) + parseInt(number);
        item.total = item.variation.price * item.quantity;

        $scope.updateCart(item);
    };

    $scope.selectVariation = function(vari) {
        $scope.productPrice = vari.price;
        $scope.productUnit = vari.unit;
        $scope.productVarId = vari.Id;
    };

    $scope.cartItemDisplay = function(item) {
        var result = true;
        if (item.quantity == 0) {
            result = false;
        }
        return result;
    };



    $scope.addToCart = function() {
        $scope.cartSection = true;
        var subTotal = $scope.productPrice * $scope.productQuantity;
        $scope.totalCartQuantity += $scope.productQuantity;
        $scope.totalCartAmount += subTotal;
        $http({
            method: "GET",
            url: "../pages/api.php?action=add-to-cart",
            params: {
                'varId': $scope.productVarId,
                'value': $scope.productQuantity,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            // Do nothing 
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };


    $scope.updateCart = function(item) {
        $http({
            method: "GET",
            url: "../pages/api.php?action=update-cart",
            params: {
                'varId': item.variation.Id,
                'value': item.quantity,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            // Do nothing 
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };


});
</script>