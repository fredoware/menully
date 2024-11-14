<div ng-controller="VoucherController">

    <div class="category-name text-center">Voucher Set Up</div>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <button class="add-category" ng-click="newCategory()"><i class="fa fa-plus"></i> </button>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in voucherList"  data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-out-cubic"
                ng-click="useVoucher(item)">
                <div class="card clickable">
                    <div class="card-body">
                        <div class="home-item" ng-bind-html="item.name"></div>
                        <small class="text-left">Min. Spend: ₱{{item.minimumSpend}} </small>
                        <div class="card-buttons">
                        <button class="fab-2" ng-click="updateVoucher(item)">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="fab-2 bg-danger"  ng-click="deleteVoucher(item)">
                            <i class="fa fa-trash text-white"></i>
                        </button>
                    </div>
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
                            <h4>New Voucher</h4>
                        </div>
                        <div class="sheet-body">
                            <b>Voucher Type</b>
                            <select class="form-select mb-3" ng-model="formData.type" required>
                                <option>Discount</option>
                                <option>Gift</option>
                            </select>
                            <div class="row mb-3">
                                <div class="col">
                                    <b>Name:</b>
                                    <input type="text" class="form-control" ng-model="formData.name" required>
                                </div>
                                <div class="col" ng-if="formData.type=='Discount'">
                                    <b>Discount:</b>
                                    <input type="number" class="form-control" ng-model="formData.discount" required>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="m-1">
                                    <b>Min. Spend:</b>
                                    <input type="number" step="0.1" class="form-control" ng-model="formData.minimumSpend" required>
                                </div>
                                <div class="m-1">
                                    <b>Quantity:</b>
                                    <input type="number" class="form-control" ng-model="formData.quantity" required>
                                </div>
                            </div>
                            <b>Valid Until:</b>
                            <input type="datetime-local" value="{{formData.validUntil}}"  ng-blur="updateDateTime($event)" class="form-control mb-3" required>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  ng-model="formData.status"  ng-true-value="'Active'" ng-false-value="'Inactive'" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Visible to customers.
                                </label>
                            </div>
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