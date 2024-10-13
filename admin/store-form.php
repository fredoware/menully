<?php
  include "templates/header.php";

  $Id = get_query_string("Id","");
    if ($Id) {
    $store = store()->get("Id=$Id");
    }

?>
<style media="screen">
.form-control {
    margin-bottom: 10px;
}
</style>

<div class="card bg-light-info shadow-none position-relative overflow-hidden">
<div class="card-body px-4 py-3">
    <div class="row align-items-center">
    <div class="col-9">
        <h4 class="fw-semibold mb-8">New Store Form</h4>
    </div>
    <div class="col-3">
        <div class="text-center mb-n5">
        <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
        </div>
    </div>
    </div>
</div>
</div>


<div class="row" style="justify-content: center; margin:10px;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="" action="process.php?action=store-save" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-8">
                            <input type="hidden" name="Id" ng-value="Id">
                            Store Name:
                            <input type="text" name="name" ng-model="storeName" autocomplete="off"
                                ng-change="generateStoreCode()" class="form-control" required>
                            Store Code: <br>
                            <i ng-bind="storeCodeValidation" ng-style="{'color':storeCodeValidationColor}"></i>
                            <input type="text" name="storeCode" ng-model="storeCode"
                                ng-change="checkAvailability()" class="form-control" required>
                           Phone Number:
                            <input type="text" name="phone" class="form-control" ng-model="phone" required>
                            Contact Email:
                            <input type="text" name="email" class="form-control" ng-model="email" required>
                            Status:
                            <select name="status" class="form-select" ng-model="status" required>
                            <option>Draft</option>
                            <option>Published</option>
                            </select>
                            Address:
                            <input type="text" name="address" ng-model="address" class="form-control" required>

                            <hr>

                            <h3>Notification Message</h3>
                           Pending Message:
                            <input type="text" name="pendingMessage" class="form-control" ng-model="pendingMessage" required>
                           Confirmed Message:
                            <input type="text" name="confirmedMessage" class="form-control" ng-model="confirmedMessage" required>
                           Ready Message:
                            <input type="text" name="readyMessage" class="form-control" ng-model="readyMessage" required>
                           Canceled Message:
                            <input type="text" name="canceledMessage" class="form-control" ng-model="canceledMessage" required>
                            
                        </div>
                        
                    <div class="col-4">
                    <label class="mt-3">Cover Photo:</label> <br>
                        <label for="coverInput">
                            <img ng-src="{{cover}}" id="cover" style="width:100%;">
                        </label>
                        <input id="coverInput" type="file" name="cover" accept="image/*" onchange="coverLoadFile(event)"
                            style="display:none">

                            <br>

                            <label class="mt-3">Logo:</label> <br>
                        <label for="logoInput">
                            <img ng-src="{{logo}}" id="logo" style="width:100%;">
                        </label>
                        <input id="logoInput" type="file" name="logo" accept="image/*" onchange="logoLoadFile(event)"
                            style="display:none">
                            
                            <br>
                            <label class="mt-3">Primary theme color:</label> <br>
                            <input type="color" ng-model="themePrimary" name="themePrimary" value="#017017" required> <br>
                            
                            <label class="mt-3">Secondary theme color:</label> <br>
                            <input type="color" ng-model="themeSecondary" name="themeSecondary" value="#f08c13" required>
                    </div>
                    </div>
                    <button type="submit" name="form-type" value="add" ng-show="add" class="btn btn-primary mt-5">Create</button>
                    <button type="submit" name="form-type" value="edit" ng-show="edit"  class="btn btn-primary mt-5">Modify</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

var logoLoadFile = function(event) {
    var output = document.getElementById('logo');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};

var coverLoadFile = function(event) {
    var output = document.getElementById('cover');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};


var app = angular.module("myApp", []);
app.controller('myCtrl', function($scope, $http) {
    $scope.logo = "templates/assets/images/default-store-logo.jpg";
    $scope.cover = "templates/assets/images/default-store-logo.jpg";
    $scope.generateStoreCode = function() {
        var strLower = $scope.storeName.toLowerCase();
        $scope.storeCode = strLower.replace(/\s/g, '');
        $scope.checkAvailability();
    };

    $scope.checkAvailability = function() {
        $http({
            method: "GET",
            url: "api/check-store-code-exist.php",
            params: {
                'storeCode': $scope.storeCode
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            if (response.data.result > 0) {
                $scope.storeCodeValidation = "Store Code Not Available";
                $scope.storeCodeValidationColor = "red";
                document.getElementById("store-code").setCustomValidity(
                "Store Code Already Exists");

            } else {
                $scope.storeCodeValidation = "Store Code Available";
                $scope.storeCodeValidationColor = "green";
                document.getElementById("store-code").setCustomValidity("");
            }
        }, function myError(response) {
            $scope.storeCodeValidation = response.statusText;
        });
    };

    
    // ====================================================================== Modify form 
    <?php if ($Id): ?>
    $scope.Id = "<?=$Id?>";
    $scope.logo = "<?=general_link("media/".$store->logo);?>";
    $scope.cover = "<?=general_link("media/".$store->cover);?>";
    $scope.storeName = "<?=$store->name?>";
    $scope.storeCode = "<?=$store->storeCode?>";
    $scope.owner = "<?=$store->owner?>";
    $scope.phone = "<?=$store->phone?>";
    $scope.email = "<?=$store->email?>";
    $scope.status = "<?=$store->status?>";
    $scope.address = "<?=$store->address?>";
    $scope.themePrimary = "<?=$store->themePrimary?>";
    $scope.themeSecondary = "<?=$store->themeSecondary?>";
    $scope.pendingMessage = "<?=$store->pendingMessage?>";
    $scope.confirmedMessage = "<?=$store->confirmedMessage?>";
    $scope.canceledMessage = "<?=$store->canceledMessage?>";
    $scope.readyMessage = "<?=$store->readyMessage?>";
    $scope.add = false;
    $scope.edit = true;
    <?php else: ?>
    $scope.add = true;
    $scope.edit = false;
    $scope.status = "Draft";
    <?php endif; ?>

    
    // ====================================================================== Modify form 


});


</script>



<?php include "templates/footer.php"; ?>