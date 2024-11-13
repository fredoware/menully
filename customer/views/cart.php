<?php 
session_start();
$customerName = $_SESSION['customer']["name"];
$customerId = $_SESSION['customer']["Id"];
?>
<div ng-controller="CartController">

    <div class="category-name">My Cart</div>

    <div class="row" style="margin-bottom:200px">
        <div class="col-lg-4 col-md-6 mt-2" mt-2" ng-repeat="item in cartList" ng-if="item.quantity!=0">
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
                                        <img src="../media/{{storeLogo}}" width="100%">
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
                                <h3 class="price-tag" ng-click="closeCartSheet()">₱{{item.total | formatMoney}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center cart-main" ng-show="orderFormDisplay">
        <div class="col-lg-6 col-md-10 col-sm-12">
            <div class="card text-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mt-3 mb-3">
                            Voucher:
                        </div>

                        <a class="col-6 mt-3" href="">
                            Select Voucher <i class="bi bi-chevron-right"></i>
                        </a>
                        <div class="col-6 mt-3 mb-3">
                            <h3 class="price-tag">₱{{apiService.totalCartAmount | formatMoney}}</h3>
                        </div>
                        <div class="col-6">
                            <div class="btn-place-order" ng-click="openOrderForm()">
                                Place Order
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div ng-init="customerName = '<?=$customerName?>'"></div>
    <div ng-init="customerId = '<?=$customerId?>'"></div>

    <div class="backdrop" id="bottomBackdrop" ng-click="closeCartSheet()"></div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div id="bottomSheet" class="bottom-sheet">
                <div class="sheet-content">
                    <div class="sheet-header">
                        <span class="close-btn" ng-click="closeCartSheet()">&times;</span>
                    </div>
                    <div class="sheet-body">
                        
                        <h4>Customer</h4>
                        <input type="text" class="form-control mb-3" ng-model="customerName" required>
                        <h4>Notes to kitchen</h4>
                        <textarea class="form-control" ng-model="customerNotes"></textarea>

                    </div>
                    <div class="sheet-footer p-3">
                        
                        <div class="row justify-content-center">
                            <div class="col">
                                <button type="button" ng-click="submitOrder()"
                                    class="btn btn-primary add-to-cart">Submit Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>