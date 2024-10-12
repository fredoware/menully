<?php
  include "../pages/templates/header-customer.php";

  
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
  
  if (isset($_GET["history"])) {
    $page = "history";
  }
  
  if (isset($_GET["settings"])) {
    $page = "settings";
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

.btn-fab-back {
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

.btn-fab-history {
    position: fixed;
    top: 20px;
    right: 80px;
    z-index: 1000;
    background: white;
    border-radius: 30px;
    padding: 15px;
    font-size: 20px;
    font-weight: 900;
    border: 0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
}

.notification-badge {
    position: fixed;
    top: 15px;
    right: 75px;
    z-index: 2000;
    background: #eb1526;
    border-radius: 30px;
    padding: 10px;
    font-size: 20px;
    font-weight: 900;
    border: 0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
}

.btn-fab-settings {
    position: fixed;
    top: 20px;
    right: 20px;
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
    margin-bottom: 20px;
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
    min-height: 100px;
}

.add-to-cart {
    width: 100%;
    padding: 10px;
}

.btn-cart {
    padding: 10px 20px 10px 20px;
    color: black !important;
}

.not-available {
    opacity: 0.2;
}

.not-available-badge {
    position: absolute;
    top: 50px;
    left: 0px;
    text-align: center;
    color: yellow;
    font-weight: 900;
    font-size: 30px;
    transform: rotate(-42deg);
    background: red;
    width: 200px;
    opacity: 0.5;
    border-radius: 100px;
}
</style>


<div class="container-fluid bg-white cover-size">
    <div class="spinner-wrapper" ng-show="pageSpinner">
        <div class="spinner-border"></div>
    </div>

    <?php if ($page!="main"): ?>
    <a class="btn-fab-back clickable" href="./" ng-click="spinner()"><i class="bi bi-arrow-left"></i></a>
    <?php else: ?>

    <button class="btn-fab-back clickable" ng-show="buttonToCategory" ng-click="categoryPage()"><i class="bi bi-arrow-left"></i></button>
    
    <div class="notification-badge" id="notificationBadge" style="display:none"></div>
    <button class="btn-fab-history clickable" ng-click="notificationPage()"><i class="bi bi-bell-fill"></i></button>

    <a class="btn-fab-settings clickable" href="?settings=1" ng-click="spinner()"><i class="bi bi-gear-fill"></i></a>
    <?php endif; ?>

    <a class="row justify-content-center cart-main" href="?cart=1" ng-click="spinner()" ng-show="cartSection">
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
                            ₱{{totalCartAmount}}
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

                        <?php if ($_SESSION['voucherId']): ?>
                        <a class="col-6 p-3" href="?voucher=1">
                            <div class="cart-selected-voucher">
                                <span><?=$_SESSION['voucherName']?></span>
                            </div>
                        </a>
                        <?php else: ?>
                        <a class="col-6 mt-3" href="?voucher=1" ng-click="spinner()">
                            Select Voucher <i class="bi bi-chevron-right"></i>
                        </a>
                        <?php endif; ?>
                        <div class="col-6 mt-3 mb-3">
                            <h3 class="price-tag">₱{{totalCartAmount}}</h3>
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


            <div class="row" ng-show="categoryDisplay">
                <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="?isBestSeller=1" ng-click="spinner()">
                    <div class="card clickable">
                        <div class="card-body">
                            <div class="home-item" style="color:red;">Best Sellers</div>
                        </div>
                    </div>
                </a>
                <a class="col-lg-4 col-md-6 mt-2" ng-repeat="item in categoryList" data-aos="fade-up"
                    href="?catId={{item.Id}}" ng-click="spinner()">
                    <div class="card clickable">
                        <div class="card-body">
                            <div class="home-item" ng-bind-html="item.name"></div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="row" ng-show="notificationDisplay">

            <div class="col-lg-4 col-md-6 mt-2" data-aos="fade-up">
                

            <div class="alert alert-danger" role="alert" id="alertBar" style="display:none;">
          <span id="notificationMessage">0</span>
       </div>
       

            </div>

            <div class="col-lg-4 col-md-6 mt-2" data-aos="fade-up">
                <div class="card clickable">
                    <div class="card-body">
                        <div class="home-item">Call a waiter</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-2" data-aos="fade-up">
                <div class="card clickable">
                    <div class="card-body">
                        <div class="home-item">Request for bill</div>
                    </div>
                </div>
            </div>

            </div>





            <?php endif; ?>

            <!-- MAIN PAGE ========================================================================== -->
            <?php if ($page=="history"): ?>
            <div class="row">
                <div class="category-name">order history</div>
                <a class="col-lg-4 col-md-6 mt-2" ng-repeat="item in historyList" data-aos="fade-up">
                    <div class="card clickable" ng-click="orderModalContent(item)" data-bs-toggle="modal"
                        data-bs-target="#historyModal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col order-label">
                                    Date Ordered:
                                </div>
                                <div class="col order-value">
                                    {{item.main.date}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col order-label">
                                    Order Number:
                                </div>
                                <div class="col order-value">
                                    {{item.main.orderNumber}}
                                </div>
                            </div>


                            <div ng-if="item.main.voucherId">
                                <div class="row">
                                    <div class="col order-label">
                                        Sub-Total:
                                    </div>
                                    <div class="col order-value">
                                        ₱{{item.total}}
                                    </div>
                                </div>

                                <div class="row mt-3 mb-3">
                                    <div class="col order-label">
                                        Voucher:
                                    </div>
                                    <div class="col order-value">
                                        <div class="cart-selected-voucher">
                                            {{item.voucher.name}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col order-label">
                                        Total:
                                    </div>
                                    <div class="col order-value">
                                        ₱{{item.total - item.voucher.discount}}
                                    </div>
                                </div>
                            </div>

                            <div ng-if="!item.main.voucherId">

                                <div class="row">
                                    <div class="col order-label">
                                        Total:
                                    </div>
                                    <div class="col order-value">
                                        ₱{{item.total}}
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col order-label" style="">
                                    Status:
                                </div>
                                <div class="col order-value">
                                    {{item.main.status}}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </a>
        </div>

        <?php endif; ?>


        <!-- MAIN PAGE ========================================================================== -->
        <?php if ($page=="settings"): ?>

        <div class="category-name">settings</div>

        <?php if(isset($_SESSION['user_session'])): ?>
        <div class="row">
            <?php foreach ($myStoreList as $row): ?>
            <div class="col-4 col-lg-3">
                <a href="../pages/process.php?action=store-log-in&store=<?=$row->storeCode?>">
                    <div class="square-container">
                        <img src="../media/<?=$row->logo?>" />
                    </div>
                </a>
                <?=$row->name?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up">
                <div class="card clickable" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                    <div class="card-body">
                        View QR Code
                    </div>
                </div>
            </a>


            <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="?history=1">
                <div class="card clickable">
                    <div class="card-body">
                        Order History
                    </div>
                </div>
            </a>


            <?php if(isset($_SESSION['user_session'])): ?>
            <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="log-out">
                <div class="card clickable">
                    <div class="card-body">
                        Seller Log Out
                    </div>
                </div>
            </a>
            <?php else: ?>
            <a class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="sign-in">
                <div class="card clickable">
                    <div class="card-body">
                        Seller Log In
                    </div>
                </div>
            </a>
            <?php endif; ?>

        </div>

        <?php endif; ?>

        <!-- MAIN PAGE ========================================================================== -->
        <?php if ($page=="voucher"): ?>
        <div class="category-name">vouchers</div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in myVouchers" data-aos="fade-up"
                ng-click="useVoucher(item)">
                <div class="card clickable">
                    <div class="card-body d-flex justify-content-between">
                        <div class="home-item" ng-bind-html="item.voucher.name"></div>
                        <button class="btn btn-info">Use Now</button>
                    </div>
                    <hr>
                    <small class="text-left">Min. Spend: ₱{{item.voucher.minimumSpend}} </small>
                    <small class="text-left mb-3" style="color:red">{{item.expiring}}</small>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in vouchers" data-aos="fade-up"
                ng-click="claimVoucher(item)">
                <div class="card clickable">
                    <div class="card-body d-flex justify-content-between">
                        <div class="home-item" ng-bind-html="item.voucher.name"></div>
                        <button class="btn btn-primary">Claim</button>
                    </div>
                    <hr>
                    <small class="text-left">Min. Spend: ₱{{item.voucher.minimumSpend}} </small>
                    <small class="text-left mb-3" style="color:red">{{item.expiring}}</small>
                </div>
            </div>
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

                            <div ng-if="item.product.image">
                                <div ng-if="item.product.isAvailable">
                                    <img src="../media/{{item.product.image}}" width="100%">
                                </div>

                                <div ng-if="!item.product.isAvailable">
                                    <div class="not-available-badge">Sold Out</div>
                                    <img src="../media/{{item.product.image}}" class="not-available" width="100%">
                                </div>
                            </div>

                            <div ng-if="!item.product.image">
                                <div ng-if="item.product.isAvailable">
                                    <img src="../media/<?=$store->logo?>" width="100%">
                                </div>

                                <div ng-if="!item.product.isAvailable">
                                    <div class="not-available-badge">Sold Out</div>
                                    <img src="../media/<?=$store->logo?>" class="not-available" width="100%">
                                </div>
                            </div>

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
                                    <div ng-if="item.product.image">

                                        <img src="../media/{{item.product.image}}" width="100%">
                                    </div>

                                    <div ng-if="!item.product.image">

                                        <img src="../media/<?=$store->logo?>" width="100%">

                                    </div>
                                </div>
                            </div>
                            <div class="col text-center">
                                <span ng-bind-html="item.product.name"></span>
                                <div class="d-flex justify-content-center">
                                    <div class="price-tag">₱{{item.variation.price}}</div> &nbsp; x
                                    {{item.quantity}}
                                </div>
                                <br>
                                <div class="input-group mb-3">
                                    <button class="input-group-text bg-secondary"
                                        ng-click="updateItemQuantity(item,-1)">-</button>
                                    <div type="button" class="btn btn-cart">{{item.quantity}}</div>
                                    <button class="input-group-text bg-secondary"
                                        ng-click="updateItemQuantity(item,1)">+</button>
                                </div>


                                <br><br>
                                <h3 class="price-tag">₱{{item.total}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height:100px"> </div>

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
                            <div ng-if="productImage">

                                <img src="../media/{{productImage}}" width="100%">
                            </div>

                            <div ng-if="!productImage">

                                <img src="../media/<?=$store->logo?>" width="100%">

                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <span ng-bind-html="productDescription"></span>
                        <h3 class="price-tag">₱{{productPrice}} </h3>
                        <br>
                        {{productUnit}}
                    </div>
                </div>
                <ul class="list-group mt-2">
                    <li class="list-group-item clickable product-variation" ng-click="selectVariation(vari)"
                        ng-repeat="vari in priceVariation">
                        {{vari.unit}} - {{vari.price}}
                    </li>
                </ul>
            </div>
            <div class="modal-footer">

                <div class="row" style="width:100%" ng-if="productAvailability">
                    <div class="col text-center">

                        <div class="input-group mb-3">
                            <button class="input-group-text bg-secondary"
                                ng-click="updateQuantity(productQuantity-1)">-</button>
                            <div type="button" class="btn btn-cart">{{productQuantity}}</div>
                            <button class="input-group-text bg-secondary"
                                ng-click="updateQuantity(productQuantity+1)">+</button>
                        </div>

                    </div>

                    <div class="col">
                        <button type="button" ng-click="addToCart()" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-primary add-to-cart">Add to Cart</button>
                    </div>
                </div>

                <div class="row" style="width:100%" ng-if="!productAvailability">
                    <div class="col">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-danger add-to-cart">Sold Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog product-modal">
        <div class="modal-content" style="min-height:500px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="historyModalLabel"><span ng-bind-html="productName"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between" ng-repeat="item in orderItemList">
                        <div class="">{{item.item.name}} x {{item.orderItem.quantity}} </div>
                        <div class=""> ₱{{item.variation.price*item.orderItem.quantity}} </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <div>Total: </div>
                <b>₱{{orderMainTotal}}</b>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="hqrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog product-modal">
        <div class="modal-content" style="min-height:500px">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <center>
                    <div id="storeQrCode"></div>
                </center>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog product-modal">
        <div class="modal-content" style="min-height:500px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="orderModalLabel"><span ng-bind-html="productName"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="storeCode" class="form-control" value="<?=$storeCode?>" required>

                <?php if (isset($_SESSION["table"])): ?>
                <b>Table:</b>
                <input type="text" name="name" class="form-control" value="<?=$_SESSION['table']['name']?>" disabled>
                <input type="hidden" name="tableId" class="form-control" value="<?=$_SESSION['table']['Id']?>" required>
                <?php else: ?>
                <input type="hidden" name="tableId" class="form-control" value="" required>
                <?php endif; ?>
                <b>Customer</b>
                <input type="text" name="name" class="form-control" value="<?=$_SESSION['customer']['name']?>" required>
                <input type="hidden" name="customerId" class="form-control" value="<?=$_SESSION['customer']['Id']?>"
                    required>
                <b>Notes to kitchen</b>
                <textarea name="notes" class="form-control" ng-model="notes"></textarea>

            </div>
            <div class="modal-footer">
                <div class="row" style="width:100%">
                    <div class="col text-center">

                        <button type="button" ng-click="placeOrder()" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-primary add-to-cart">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>



<script type="text/javascript">
 var hasNotification = 0;
 document.getElementById("notificationBadge").style.display = "none";

 function activateNotif(){

     var intervalId = window.setInterval(function(){
       $.ajax({
           type: "GET",
           url: "../pages/api.php?action=customer-notification&storeCode=<?=$store->storeCode?>",
           success: function(data){
             const obj = JSON.parse(data);

            //  alert(obj.status);

            if (obj.status=="Confirmed" && hasNotification==0) {
                   document.getElementById("alertBar").style.display = "";
                    document.getElementById("notificationMessage").innerHTML = "<?=$store->confirmedMessage?>";
                    notificationSound();
                    hasNotification = 1;
            }
            if (obj.status=="Delivered" && hasNotification==0) {
                   document.getElementById("alertBar").style.display = "";
                    document.getElementById("notificationMessage").innerHTML = "<?=$store->deliveredMessage?>";
                    notificationSound();
                    hasNotification = 1;
            }
            if (obj.status=="Canceled" && hasNotification==0) {
                   document.getElementById("alertBar").style.display = "";
                    document.getElementById("notificationMessage").innerHTML = "<?=$store->canceledMessage?>";
                    notificationSound();
                    hasNotification = 1;
            }
             
            if (hasNotification) {
                document.getElementById("notificationBadge").style.display = "";
            }

           }
         });
     }, 2000);
 }



 function notificationSound(){
   const audio = new Audio("../pages/templates/audio/notification.wav");
   audio.play();
 }

 </script>


<script type="text/javascript">

var qrcode = new QRCode(document.getElementById("storeQrCode"), {
    text: "https://menully.com/<?=$store->storeCode;?>/",
    width: 300,
    height: 300,
    colorDark: "#000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});
</script>

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
    $scope.categoryDisplay = false;
    $scope.notificationDisplay = false;
    $scope.buttonToCategory = false;
    $scope.notes = "";

    if ($scope.totalCartQuantity) {
        $scope.cartSection = true;
    }

    <?php if ($page=="main"): ?>
    $scope.categoryDisplay = true;
    $scope.notificationDisplay = false;
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
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.getCategories();



    $scope.notificationPage = function() {

        $scope.categoryDisplay = false;
        $scope.notificationDisplay = true;
        $scope.buttonToCategory = true;

        activateNotif();
    }

    $scope.categoryPage = function() {

        $scope.categoryDisplay = true;
        $scope.notificationDisplay = false;
        $scope.buttonToCategory = false;
    }


    <?php endif; ?>


    <?php if ($page=="history"): ?>
    $scope.cartSection = false;
    $scope.getHistories = function() {
        $http({
            method: "GET",
            url: "../pages/api.php?action=history-list",
            params: {
                'storeCode': '<?=$store->storeCode?>',
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.historyList = response.data;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.getHistories();
    <?php endif; ?>

    <?php if ($page=="voucher"): ?>
    $scope.getVouchers = function() {
        $http({
            method: "GET",
            url: "../pages/api.php?action=voucher-list",
            params: {
                'storeId': <?=$store->Id?>,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.totalRecords = response.data.total;
            $scope.vouchers = response.data.vouchers;
            $scope.myVouchers = response.data.myVouchers;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.getVouchers();

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
        $scope.productAvailability = item.product.isAvailable;
        $scope.productPrice = item.lowestPrice;
        $scope.productQuantity = 1;
        $scope.productUnit = "";
        $scope.productVarId = item.varId;
        $scope.priceVariation = item.variation;
    };

    $scope.orderModalContent = function(item) {
        $scope.orderItemList = item.items;
        $scope.orderMainTotal = item.total;
        if (item.main.voucherId) {
            $scope.orderMainTotal = item.total - item.voucher.discount;
        }
    };

    $scope.updateQuantity = function(newQuantity) {
        if (newQuantity != 0) {
            $scope.productQuantity = newQuantity;
        }
    };

    $scope.updateItemQuantity = function(item, number) {
        item.quantity = parseInt(item.quantity) + parseInt(number);
        item.total = item.variation.price * item.quantity;

        if (parseInt(number) < 1) {
            $scope.totalCartAmount = parseInt($scope.totalCartAmount) - parseInt(item.variation.price);
        } else {
            $scope.totalCartAmount = parseInt($scope.totalCartAmount) + parseInt(item.variation.price);
        }

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

    $scope.placeOrder = function() {
        $http({
            method: "GET",
            url: "../pages/api.php?action=place-order",
            params: {
                'storeCode': '<?=$store->storeCode?>',
                'notes': $scope.notes,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            Swal.fire({
                title: "Success",
                text: "<?=$store->pendingMessage?>",
                icon: "success"
            }).then((result) => {
                window.location.href = "./";
            });
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };


    $scope.useVoucher = function(item) {
        $scope.spinner = true;

        $http({
            method: "GET",
            url: "../pages/api.php?action=use-voucher",
            params: {
                'voucherId': item.voucher.Id,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            if (response.data.success) {

                window.location.href = "?cart=1";
            } else {
                Swal.fire({
                    title: "Warning",
                    text: "Minmum spend must be " + response.data.minSpend,
                    icon: "error"
                });
                $scope.getVouchers();
            }
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    }


    $scope.claimVoucher = function(item) {
        $scope.spinner = true;
        Swal.fire({
            title: "Success",
            text: "You have claimed this voucher!",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "User now"
        }).then((result) => {
            $http({
                method: "GET",
                url: "../pages/api.php?action=claim-voucher",
                params: {
                    'voucherId': item.voucher.Id,
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function mySuccess(response) {}, function myError(response) {
                console.log("Validation", response.statusText)
            });
            if (result.isConfirmed) {
                $scope.useVoucher(item);
            } else {
                $scope.getVouchers();
            }
        });
    }


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