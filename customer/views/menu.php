<div ng-controller="MenuController" style="margin-bottom:100px;">

    <div class="category-name text-center">menu</div>

    <div class="row text-center">
        <div class="col-lg-4 col-md-6 mt-2" data-aos="fade-up" href="#"
            ng-click="spinner()">
            <a class="card clickable" href="./menu-item?isBestSeller=1">
                <div class="card-body">
                    <div class="home-item text-danger">Best Sellers</div>

                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in categoryList" data-aos="fade-up" href="#"
            ng-click="spinner()">
            <a class="card clickable" href="./menu-item?Id={{item.Id}}">
                <div class="card-body">
                    <div class="home-item" ng-bind-html="item.name"></div>

                </div>
            </a>
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
                            <h4>New Category</h4>
                        </div>
                        <div class="sheet-body">
                            <b>Name:</b>
                            <input type="text" class="form-control mb-3" ng-model="formData.name" required>
                            <b>Description:</b>
                            <textarea name="description" class="form-control mb-3" ng-model="formData.description"
                                required></textarea>
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