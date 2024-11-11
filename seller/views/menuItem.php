<div ng-controller="ItemController">
    <div class="category-name text-center">{{title}}</div>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <button class="add-category" ng-click="newItem()"><i class="fa fa-plus"></i> </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-6 mt-2" ng-repeat="item in itemList"">
            <div data-aos=" fade-up">
            <div class="card">
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

            <div class="card-buttons mb-3">
                <button class="fab-2" ng-click="updateItem(item)">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="fab-2 bg-danger" ng-click="deleteItem(item)">
                    <i class="fa fa-trash text-white"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="backdrop" id="bottomBackdrop" ng-click="closeBackdrop()"></div>

<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <div id="bottomSheet" class="bottom-sheet">
            <form ng-submit="submitForm()">
                <div class="sheet-content">
                    <div class="sheet-header">
                        <span class="close-btn" ng-click="closeBottomSheet()">&times;</span>
                        <h4>New Item</h4>
                    </div>
                    <div class="sheet-body">
                        <b>Name:</b>
                        <input type="text" class="form-control mb-3" ng-model="formData.name" required>
                        <b>Description:</b>
                        <textarea name="description" class="form-control mb-3" ng-model="formData.description"
                            required></textarea>

                        <b>Pricing:</b>

                        <div class="d-flex mb-3" ng-if="varations.length==1" ng-repeat="var in varations">
                            <input type="text" placeholder="Price" ng-model="var.price" class="form-control m-1"
                                required>
                        </div>

                        <div class="d-flex mb-3" ng-if="varations.length>1" ng-repeat="var in varations">
                            <input type="text" placeholder="Unit" ng-model="var.unit" class="form-control m-1" required>
                            <input type="text" placeholder="Price" ng-model="var.price" class="form-control m-1"
                                required>
                            <span class="fab-2 bg-danger text-white m-1" ng-click="removeVaration($index)"><i
                                    class="fa fa-trash"></i></span>
                        </div>

                        <div class="add-varation mb-3" ng-click="addVaration()"><i class="fa fa-plus"></i> Add Variant
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  ng-model="formData.isAvailable"  ng-true-value="1" ng-false-value="0" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Available
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" ng-model="formData.isBestSeller"  ng-true-value="1" ng-false-value="0" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Best Seller
                                </label>
                            </div>
                        </div>

                        <b>Image:</b>
                        <input type="file" class="form-control"
                            onchange="angular.element(this).scope().handleFileChange(this)">
                    </div>
                    <div class="sheet-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>