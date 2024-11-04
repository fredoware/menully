<div ng-controller="OrderController">
    <div class="row">
        <div class="category-name text-center">{{message}}</div>
        <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in orderList" data-aos="fade-up">
            <div ng-class="cardColor(item.main.isPaid)" ng-click="orderModalContent(item)">
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
                            <span ng-bind="paymentStatus(item.main.isPaid)"></span>
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


    <div class="backdrop" id="bottomBackdrop" ng-click="closeBackdrop()"></div>
    <div id="bottomSheet" class="bottom-sheet">
        <div class="sheet-content">
            <div class="sheet-header">
                <span class="close-btn" ng-click="closeBottomSheet()">&times;</span>
                <h4>#<span ng-bind="orderInfo.orderNumber"></span></h4>
            </div>
            <div class="sheet-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between" ng-repeat="item in orderItemList">
                        <div class="">{{item.item.name}} ({{item.variation.unit}}) x {{item.orderItem.quantity}} </div>
                        <div class=""> ₱{{item.variation.price*item.orderItem.quantity}} </div>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <b>Notes</b>
                        <div class=""> {{orderInfo.notes}} </div>
                    </li>
                    <div ng-if="orderInfo.voucherId">


                        <li class="list-group-item d-flex justify-content-between">
                            <b>Sub-Total:</b>
                            <div class=""> ₱{{orderMainTotal}} </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <b>Voucher:</b>
                            <div class="cart-selected-voucher">
                                {{orderVoucher.name}}
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <b>Total:</b>
                            <div class=""> ₱{{orderMainTotal - orderVoucher.discount}}</div>
                        </li>

                    </div>

                    <div ng-if="!orderInfo.voucherId">
                        <li class="list-group-item d-flex justify-content-between">
                            <b>Total:</b>
                            <div class=""> ₱{{orderMainTotal}} </div>
                        </li>
                    </div>

                    <div>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>Payment Status:</b>
                            <div class=""> <span ng-bind="paymentStatus(orderInfo.isPaid)"></span></div>
                        </li>
                    </div>
                </ul>

            </div>
            <div class="sheet-footer">
                <button ng-if="!orderInfo.isPaid" class="btn btn-success" ng-click="markAsPaid(orderInfo.Id)">Mark as
                    Paid</button>
                <button class="btn btn-primary" ng-click="changeOrderStatus(orderInfo.Id, nextStatus)"
                    ng-hide="orderInfo.status === 'Delivered' || orderInfo.status === 'Canceled'">{{nextStatus}}</button>
                <button class="btn btn-danger" ng-click="changeOrderStatus(orderInfo.Id, 'Canceled')"
                    ng-hide="orderInfo.status === 'Delivered' || orderInfo.status === 'Canceled'">Cancel Order</button>

            </div>
        </div>
    </div>

</div>