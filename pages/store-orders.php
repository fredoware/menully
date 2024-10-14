<?php
  include "templates/header-store.php";

  $date = get_query_string("date", date("Y-m-d"));

  $status = $_GET["status"];

  $order_list = orderMain()->list("status='$status' and storeCode='$storeName' and date='$date'");

  $totalItems = count($order_list);

  function get_total_amount($orderNumber){
    $result = 0;

    foreach (orderItem()->list("orderNumber='$orderNumber'") as $row) {
      $var = variation()->get("Id=$row->varId");
      $result += $var->price*$row->quantity;
    }
    return $result;
  }


  switch ($status) {
	
    case "Pending" :
      $nextStatus = "Confirmed";
      $nextButton = "Confirm";
      break;
	
      case "Confirmed" :
        $nextStatus = "Ready";
        $nextButton = "Ready";
        break;
	
        case "Ready" :
          $nextStatus = "Delivered";
          $nextButton = "Deliver";
          break;
  
    default :
  }
  
?>

<main id="main">

    <section id="menu" class="menu">
        <div class="container">


            <div class="section-header">
                <h2><?=$status?> Orders
                    <span class="badge text-bg-warning"><?=$totalItems?></span>
                </h2>



                <div class="row">
                    <div class="col-lg-4">
                        <form action="store-orders.php" method="get" class="input-group mt-3 mb-3">
                            <input type="hidden" name="status" value="<?=$status?>">
                            <input type="date" class="form-control" value="<?=$date?>" name="date"
                                onchange="this.form.submit()" required />
                        </form>
                    </div>
                </div>

            </div>

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

    </section>

</main>



<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog product-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="historyModalLabel">#<span ng-bind-html="orderInfo.orderNumber"></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                            <div class=""> <span ng-bind-html="paymentStatus(orderInfo.isPaid)"></span></div>
                        </li>
                    </div>
                </ul>

            </div>
            <div class="modal-footer">
              <?php if ($status!="Delivered" && $status!="Canceled"): ?>
            <button ng-if="!orderInfo.isPaid" class="btn btn-success" ng-click="markAsPaid(orderInfo.Id)">Mark as Paid</button>
            <button class="btn btn-primary" ng-click="changeOrderStatus(orderInfo.Id, '<?=$nextStatus?>')"  data-bs-dismiss="modal" aria-label="Close"><?=$nextButton?></button>
            <button class="btn btn-danger" ng-click="changeOrderStatus(orderInfo.Id, 'Canceled')"  data-bs-dismiss="modal" aria-label="Close">Cancel</button>
           
            <?php endif; ?>
          </div>
        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>


<script>
var app = angular.module("myApp", ['ngSanitize']);

app.controller('myCtrl', function($scope, $http) {

    $scope.getHistories = function() {
        $http({
            method: "GET",
            url: "../pages/api-store.php?action=order-list",
            params: {
                'storeCode': '<?=$store->storeCode?>',
                'status': '<?=$status?>',
                'date': '<?=$date?>',
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            $scope.orderList = response.data;
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    };

    $scope.getHistories();


    $scope.orderModalContent = function(item) {
        $scope.orderItemList = item.items;
        $scope.orderInfo = item.main;
        $scope.orderMainTotal = item.total;
        if (item.main.voucherId) {
            $scope.orderVoucher = item.voucher;
        }
    };

    $scope.paymentStatus = function(isPaid) {
        $result = "Unpaid";
        if (isPaid) {
          $result = "Paid";
        }
        return $result;
    };

    $scope.cardColor = function(isPaid){
      $result = "card unpaid-order-card";
        if (isPaid) {
          $result = "card paid-order-card";
        }
        return $result;
    }

    $scope.markAsPaid = function(itemId){
      $http({
            method: "GET",
            url: "../pages/api-store.php?action=mark-order-as-paid",
            params: {
                'itemId': itemId,
                'isPaid': 1,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
          console.log("Validation", response.statusText)
          $scope.orderInfo.isPaid = 1;
          $scope.getHistories();
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    }

    $scope.changeOrderStatus = function(itemId, status){
      $http({
            method: "GET",
            url: "../pages/api-store.php?action=change-order-status",
            params: {
                'itemId': itemId,
                'status': status,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
          console.log("Validation", response.statusText)
          $scope.orderInfo.isPaid = 1;
          $scope.getHistories();
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    }

});
</script>