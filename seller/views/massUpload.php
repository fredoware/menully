<div ng-controller="ItemMassUploadController">
    <div class="category-name text-center">{{title}}</div>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <button class="add-category" ng-click="newItem()"><i class="fa fa-plus"></i> </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-6 mt-2" ng-repeat="item in itemList"">
            <div  data-aos=" fade-up" data-aos-duration="500" data-aos-easing="ease-out-cubic">
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

            <div class="sheet-content" ng-show="bottomSheetState==='massUpload'">
                <div class="sheet-header">
                    <span class="close-btn" ng-click="closeBottomSheet()">&times;</span>
                    <h4>Mass Upload</h4>
                </div>
                <div class="sheet-body">
                    <h3 id="-csv-field-instructions-"><strong>CSV Field Instructions:</strong></h3>
                    <ol>
                        <li>
                            <p><strong>Required Fields:</strong></p>
                            <ul>
                                <li><strong>Name</strong>: The name of the product (e.g., &quot;Latte&quot;).</li>
                                <li><strong>Category</strong>: The category of the product (e.g., &quot;Coffee&quot;).
                                </li>
                                <li><strong>Quantity</strong>: The stock quantity of the product.</li>
                                <li><strong>Option 1 name</strong>: The first price variation name (e.g.,
                                    &quot;12oz&quot;).</li>
                                <li><strong>Option 1 value</strong>: The price for the first price variation.</li>
                            </ul>
                        </li>
                        <li>
                            <p><strong>Optional Fields:</strong></p>
                            <ul>
                                <li><strong>Description</strong>: A short description of the product. Leave blank if not
                                    applicable.</li>
                                <li><strong>Option 2 name &amp; Option 2 value</strong>: The second price variation and
                                    its price. Leave blank if not applicable.</li>
                                <li><strong>Option 3 name &amp; Option 3 value</strong>: The third price variation and
                                    its price. Leave blank if not applicable.</li>
                            </ul>
                        </li>
                        <li>
                            <p><strong>Boolean Fields (1 = Yes, 0 = No):</strong></p>
                            <ul>
                                <li><strong>Is Available?</strong>: Indicates if the product is available for purchase.
                                    Use <code>1</code> for &quot;Yes&quot; and <code>0</code> for &quot;No&quot;.</li>
                                <li><strong>Is Best Seller?</strong>: Indicates if the product is a bestseller. Use
                                    <code>1</code> for &quot;Yes&quot; and <code>0</code> for &quot;No&quot;.
                                </li>
                            </ul>
                        </li>
                    </ol>

                    <hr>

                    <a href="./templates/sampleCsv/menully_items.csv" download rel="noopener" target="_self"
                        class="btn btn-info">Download Sample CSV</a>

                    <form ng-submit="uploadCsv()">
                        <input type="file" file-model="csvFile" accept=".csv" class="form-control mt-3 mb-3" />
                        <button type="submit" class="btn btn-success">Upload CSV</button>
                    </form>

                </div>
            </div>


            <form ng-submit="submitForm()" ng-show="bottomSheetState==='form'">
                <div class="sheet-content">
                    <div class="sheet-header">
                        <span class="close-btn" ng-click="closeBottomSheet()">&times;</span>
                        <h4>New Item</h4>
                    </div>
                    <div class="sheet-body">
                        <b>Name:</b>
                        <input type="text" class="form-control mb-3" ng-model="formData.name" required>

                        <b>Category:</b>
                        <select class="form-select mb-3" ng-model="formData.catId" required>
                            <option value="">--Select--</option>
                            <option ng-repeat="cat in categoryOptions" value="{{cat.Id}}">{{cat.name | formatText}}
                            </option>
                        </select>

                        <b>Description:</b>
                        <textarea name="description" class="form-control mb-3" ng-model="formData.description"
                            required></textarea>

                        <b>Quantity:</b>
                        <input type="text" class="form-control mb-3" ng-model="formData.quantity" required>

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
                                <input class="form-check-input" type="checkbox"  ng-model="formData.isForSale"  ng-true-value="1" ng-false-value="0" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Item for Sale
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" ng-model="formData.isAvailable"
                                    ng-true-value="1" ng-false-value="0" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Available
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" ng-model="formData.isFeatured"
                                    ng-true-value="1" ng-false-value="0" id="flexCheckDefault">
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