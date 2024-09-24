<?php
  include "templates/header.php";


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
                            
                            Store Name:
                            <input type="text" name="name" ng-model="storeName" autocomplete="off"
                                ng-change="generateStoreCode()" class="form-control" required>
                            Store Code: <br>
                            <i ng-bind="storeCodeValidation" ng-style="{'color':storeCodeValidationColor}"></i>
                            <input type="text" name="storeCode" id="store-code" ng-model="storeCode"
                                ng-change="checkAvailability()" class="form-control" required>
                            Owner's Registered Email: <br>
                            <i ng-bind="ownerValidation" ng-style="{'color':ownerValidationColor}"></i>
                            <input type="text" name="owner" autocomplete="off" class="form-control" ng-model="owner" id="owner" ng-change="checkOwnerExist()" required>
                            Phone Number:
                            <input type="text" name="phone" class="form-control" required>
                            Contact Email:
                            <input type="text" name="email" class="form-control" required>
                            Status:
                            <select name="status" class="form-select" required>
                            <option>Draft</option>
                            <option>Published</option>
                            </select>
                            Address:
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        
                    <div class="col-4">
                        <label for="fileInput">
                            <img id="logo" src="templates/assets/images/default-store-logo.jpg" style="width:100%;">
                        </label>
                        <input id="fileInput" type="file" name="logo" accept="image/*" onchange="loadFile(event)" required
                            style="display:none">
                    </div>
                    </div>
                    <button type="submit" name="form-type" value="add" class="btn btn-primary mt-5">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
var loadFile = function(event) {
    var output = document.getElementById('logo');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};

var app = angular.module("myApp", []);
app.controller('myCtrl', function($scope, $http) {
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

    $scope.checkOwnerExist = function() {
        $http({
            method: "GET",
            url: "api/check-owner-exist.php",
            params: {
                'email': $scope.owner
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function mySuccess(response) {
            if (response.data.result != "") {
                $scope.ownerValidation = response.data.result.name;
                $scope.ownerValidationColor = "green";
                document.getElementById("owner").setCustomValidity("");

            } else {
                $scope.ownerValidation = "Account not exists";
                $scope.ownerValidationColor = "red";
                document.getElementById("owner").setCustomValidity("Account exists");
            }
        }, function myError(response) {
            $scope.storeCodeValidation = response.statusText;
        });
    };


});
</script>



<?php include "templates/footer.php"; ?>