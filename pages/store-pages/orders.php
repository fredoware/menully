<div class="row">
    <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in orderList" data-aos="fade-up">
        <div ng-class="cardColor(item.main.isPaid)" ng-click="orderModalContent(item)" data-bs-toggle="modal"
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


                <div class="row">
                    <div class="col order-label" style="">
                        Payment:
                    </div>
                    <div class="col order-value">
                        <span ng-bind-html="paymentStatus(item.main.isPaid)"></span>
                    </div>
                </div>

                <div class="row" ng-if="item.main.tableId">
                    <div class="col order-label" style="">
                        Table:
                    </div>
                    <div class="col order-value">
                        {{item.table.name}}
                    </div>
                </div>

                <div class="row">
                    <div class="col order-label" style="">
                        Customer:
                    </div>
                    <div class="col order-value">
                        {{item.main.customer}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>