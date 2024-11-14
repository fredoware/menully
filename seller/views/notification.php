<div ng-controller="NotificationController">
<div class="category-name text-center">Notifications</div>
    <div class="row">
           <div class="col-12" ng-repeat="item in notifList" ng-if="item.status=='Received'" ng-click="readNotif(item)">
               <div class="alert alert-danger" role="alert">
                   {{item.message}}
               </div>
           </div>
    </div>

</div>