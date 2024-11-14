<div ng-controller="VoucherController">

    <div class="category-name text-center">vouchers</div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in myVouchers"  data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-out-cubic"
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
        <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in vouchers"  data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-out-cubic"
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

</div>