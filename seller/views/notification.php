<div ng-controller="NotificationController">

<div class="alert alert-danger" ng-show="hasOrder" role="alert" onclick="location.href='./orders?status=Pending'">
          {{totalOrders}} new pending orders!
       </div>

</div>