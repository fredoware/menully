<div ng-controller="ItemController">
    <div class="category-name text-center">{{title}}</div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-6 mt-2" ng-repeat="item in itemList"">
            <div  data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-out-cubic">
            <div class="card" ng-click="openItem(item)">
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
                            <img src="../media/{{storeLogo}}" width="100%">
                        </div>

                        <div ng-if="!item.product.isAvailable">
                            <div class="not-available-badge">Sold Out</div>
                            <img src="../media/{{storeLogo}}" class="not-available" width="100%">
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


<div class="backdrop" id="bottomBackdrop" ng-click="closeBackdrop()"></div>

<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <div id="bottomSheet" class="bottom-sheet">
            <div class="sheet-content">
                <div class="sheet-header">
                    <span class="close-btn" ng-click="closeBottomSheet()">&times;</span>
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
                            <button type="button"
                                class="btn btn-danger add-to-cart">Sold Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>