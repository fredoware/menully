<div ng-controller="CartController" class="row text-center">

    <div class="category-name">My Cart</div>

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


                            <br><br> {{orderFormDisplay}}
                            <h3 class="price-tag" ng-click="closeCartSheet()">₱{{item.total | formatMoney}} </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height:200px"> </div>

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
                            <div class="btn-place-order" ng-click="placeOrder()">
                                Place Order
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="backdrop" id="bottomBackdrop" ng-click="closeCartSheet()"></div>

<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <div id="bottomSheet" class="bottom-sheet">
            <div class="sheet-content">
                <div class="sheet-header">
                    <span class="close-btn" ng-click="closeCartSheet()">&times;</span>
                </div>
                <div class="sheet-body">
                    <div class="row">
                        <div class="col">
                            <img src="../media/{{thisItem.image}}" ng-if="thisItem.image" width="100%">
                            <img src="../media/{{storeLogo}}" ng-if="!thisItem.image" width="100%">
                        </div>
                        <div class="col text-center">
                            <h4>{{thisItem.name}}</h4>
                            <i>{{thisItem.description}}</i>
                            <div class="selected-item-price">{{selectedPrice}}</div>
                        </div>
                    </div>

                    <div class="d-flex mb-3 mt-3 justify-content-between" ng-if="varations.length>1"
                        ng-repeat="var in varations">
                        <div class="option-item-price">
                            <input type="radio" id="option-{{$index}}" name="options" ng-model="selectedPrice"
                                ng-value="var.price" ng-click="updateSelectedPrice(var)" />
                            <label for="option-{{$index}}">{{var.unit}}</label>
                        </div>
                        <label class="selected-item-price" for="option-{{$index}}">{{var.price}}</label>
                    </div>

                </div>
                <div class="sheet-footer p-3">
                    <div class="row" ng-if="thisItem.isAvailable">
                        <div class="col text-center">

                            <div class="input-group mb-3">
                                <button class="input-group-text bg-secondary"
                                    ng-click="updateQuantity(selectedQuantity-1)">-</button>
                                <div type="button" class="btn btn-cart">{{selectedQuantity}}</div>
                                <button class="input-group-text bg-secondary"
                                    ng-click="updateQuantity(selectedQuantity+1)">+</button>
                            </div>

                        </div>

                        <div class="col">
                            <button type="button" ng-click="addToCart()" class="btn btn-primary add-to-cart">Add to
                                Cart</button>
                        </div>
                    </div>

                    <div class="row justify-content-center" ng-if="!thisItem.isAvailable">
                        <div class="col">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-danger add-to-cart">Sold Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>