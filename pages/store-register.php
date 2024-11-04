<?php
  include "../pages/templates/header-signup.php";


?>

<div class="container-fluid bg-white cover-size">
    <div class="spinner-wrapper" ng-show="pageSpinner">
        <div class="spinner-border"></div>
    </div>
    <img src="../website/source/img/icon.png" class="logo">
    <img src="../website/source/img/cover.jpeg" class="cover-photo">

    <div class="card menu-content">
        <div class="card-body">

            <div class="row justify-content-center">

                <div class="col-lg-4 p-4" ng-show="signUpSection">

                    <h3 class="d-flex justify-content-between">
                        <div>Sign Up</div> <i class="bi bi-arrow-right" ng-click="secondPage()"></i>
                    </h3>


                    <form name="myForm1" novalidate>
                        <div class="mt-3">
                            <b>Your Name</b>
                            <input type="text" name="ownerName" ng-model="ownerName" class="form-control" required />
                            <span ng-show="myForm1.ownerName.$touched && myForm1.ownerName.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Your Email</b>
                            <input type="text" name="email" ng-model="email" class="form-control" required />
                            <span ng-show="myForm1.email.$touched && myForm1.email.$error.required" style="color:red">
                                This field is required
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <b>Create Username</b>
                            <input type="text" name="username" ng-model="username" class="form-control" required />
                            <span ng-show="myForm1.username.$touched && myForm1.username.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Your Password</b>
                            <input type="text" name="password" ng-model="password" class="form-control" required />
                            <span ng-show="myForm1.password.$touched && myForm1.password.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Creating an account means you're okay with our Terms of service.
                            </label>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" ng-click="secondPage()">Create
                                Account</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 p-4" ng-show="storeSection">
                    <h3 class="d-flex justify-content-between"> <i class="bi bi-arrow-left" ng-click="firstPage()"></i>
                        <div>Add Your Store</div> <i class="bi bi-arrow-right" ng-click="thirdPage()"></i>
                    </h3>
                    <form name="myForm2" novalidate>
                        <div class="mt-3">
                            <b>Store Name</b>
                            <input type="text" name="storeName" ng-model="storeName" class="form-control" required />
                            <span ng-show="myForm2.storeName.$touched && myForm2.storeName.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Short Name in URL</b>
                            <input type="text" ng-model="storeCode" class="form-control" required />
                            <span ng-show="myForm2.storeName.$touched && myForm2.storeName.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Contact Number</b>
                            <input type="text" ng-model="phone" class="form-control" name="phone" required />
                            <span ng-show="myForm2.phone.$touched && myForm2.phone.$error.required" style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Address</b>
                            <input type="text" ng-model="address" class="form-control" name="address" required />
                            <span ng-show="myForm2.address.$touched && myForm2.address.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" ng-click="thirdPage()">Create Store</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 p-4" ng-show="logoSection">
                    <h3> <i class="bi bi-arrow-left" ng-click="secondPage()"></i> Store Logo and Cover</h3>
                    <form name="myForm3" novalidate>
                        <div class="mt-3">
                            <b>Upload Logo</b> <br>
                            <label for="fileInput">
                                <img id="logo" src="templates/source/img/default-store-logo.jpg" style="width:200px;">
                            </label>
                            <input id="fileInput" type="file" accept="image/*" file-model="logo" ng-model="logo"
                                onchange="loadFile(event,'logo')" style="display:none" name="logo" required />
                                <br>
                            <span ng-show="myForm3.logo.$touched && myForm3.logo.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <b>Upload Cover Photo</b>
                            <label for="fileInput2">
                                <img id="cover" src="templates/source/img/default-store-logo.jpg" style="width:100%;">
                            </label>
                            <input id="fileInput2" type="file" accept="image/*" file-model="cover" ng-model="cover"
                                onchange="loadFile(event,'cover')" style="display:none" name="cover" required />
                            <span ng-show="myForm3.cover.$touched && myForm3.cover.$error.required"
                                style="color:red">
                                This field is required
                            </span>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" ng-click="createStoreAccount()">Save</button>
                        </div>
                                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>



<script>
var loadFile = function(event, imgId) {
    var output = document.getElementById(imgId);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};


var app = angular.module("myApp", ['ngSanitize']);

app.directive('fileModel', ['$parse', function($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function() {
                scope.$apply(function() {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

app.controller('myCtrl', function($scope, $http) {
    $scope.ownerName = "";
    $scope.username = "";
    $scope.email = "";
    $scope.password = "";
    $scope.storeName = "";
    $scope.storeCode = "";
    $scope.phone = "";
    $scope.address = "";

    $scope.firstPage = function() {
        $scope.signUpSection = true;
        $scope.storeSection = false;
        $scope.logoSection = false;
    }

    $scope.firstPage();

    $scope.secondPage = function() {
        $scope.myForm1.$setSubmitted();
        angular.forEach($scope.myForm1.$$controls, function(field) {
            field.$setTouched();
        });

        if ($scope.myForm1.$valid) {
            $scope.signUpSection = false;
            $scope.storeSection = true;
            $scope.logoSection = false;
        } else {
            console.log("Form is invalid. Please fill in all required fields.");
        }
    }

    $scope.thirdPage = function() {
        $scope.myForm2.$setSubmitted();
        angular.forEach($scope.myForm2.$$controls, function(field) {
            field.$setTouched();
        });

        if ($scope.myForm2.$valid) {
            $scope.signUpSection = false;
            $scope.storeSection = false;
            $scope.logoSection = true;
        } else {
            console.log("Form is invalid. Please fill in all required fields.");
        }
    }


    $scope.createStoreAccount = function() {
        $scope.myForm3.$setSubmitted();
        angular.forEach($scope.myForm3.$$controls, function(field) {
            field.$setTouched();
        });

        if ($scope.myForm3.$valid) {
            $scope.saveStoreAccount();
        } else {
            console.log("Form is invalid. Please fill in all required fields.");
        }
    };

    $scope.saveStoreAccount = function() {
        var formData = new FormData();
        formData.append("username", $scope.username);
        formData.append("ownerName", $scope.ownerName);
        formData.append("email", $scope.email);
        formData.append("password", $scope.password);
        formData.append("storeName", $scope.storeName);
        formData.append("storeCode", $scope.storeCode);
        formData.append("phone", $scope.phone);
        formData.append("address", $scope.address);
        formData.append("cover", $scope.cover);
        formData.append("logo", $scope.logo);
        $http({
            method: "POST",
            url: "../pages/api.php?action=store-sign-up",
            data: formData,
            headers: {
                'Content-Type': undefined, // Let the browser set it to multipart/form-data
            }
        }).then(function mySuccess(response) {
            Swal.fire({
                title: "Success",
                text: "You have successfully build your virtual store in Menully",
                icon: "success"
            }).then((result) => {
                window.location.href = "../"+$scope.storeCode+"/sign-in";
            });
        }, function myError(response) {
            console.log("Validation", response.statusText)
        });
    }

});
</script>