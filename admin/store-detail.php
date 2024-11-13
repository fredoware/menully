<?php
include "templates/header.php";

$Id = $_GET['Id'];
$store = store()->get("Id=$Id");
$peopleList = storePeople()->list("storeId=$Id order by role");

?>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>




<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">

            <div class="col-2 mih-left">

                <button class="btn btn-warning" onclick="history.back()"><i class="bi bi-arrow-left"></i></button>
            </div>
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Store Detail</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            


            <div class="col-6 d-flex">
                <div class="row">
                    <div class="col-6"><img src="<?=general_link("media/".$store->logo)?>" class="crop-box"></div>
                    <div class="col-6">
                        <div id="qrcode-2" class="text-center"></div>
                    </div>
                    <div class="col-12">
                        
        <a href="store-form.php?Id=<?=$Id?>" class="btn btn-warning mt-2">Modify</a>

<a href="<?=general_link('/seller/?storeCode='.$store->storeCode)?>" target="_blank" class="btn btn-primary mt-2">Manage Products</a>

<button class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Add People</button>

<a href="store-tables.php?Id=<?=$store->Id?>" class="btn btn-success mt-2">QR Tables</a>
                    </div>
                </div>
            
                
            </div>
            <div class="col-6">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Name:</b>
                        <span><?=$store->name;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Phone:</b>
                        <span><?=$store->phone;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Email:</b>
                        <span><?=$store->email;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Address:</b>
                        <span><?=$store->address;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Theme:</b>
                        <div>
                            <span class="btn" style="background:<?=$store->themePrimary;?>;color:white">Primary: <?=$store->themePrimary;?></span>
                            <span class="btn" style="background:<?=$store->themeSecondary;?>;color:white">Secondary: <?=$store->themeSecondary;?></span>
                        </div>
                    </li>


                    <li class="list-group-item">
                        <b>People:</b>
                        <div style="margin-left:30px">
                            <?php foreach ($peopleList as $row):
                                $account = account()->get("Id=$row->userId");
                                ?>
                            <i><?=$account->name;?> (<?=$row->role;?>)</i> <a href="process.php?action=remove-people&storeId=<?=$Id?>&Id=<?=$row->Id?>"><i class="bi bi-trash text-danger"></i></a> <br>
                            <?php endforeach; ?>
                            </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add People</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="process.php?action=add-people" method="post">
      <input type="hidden" name="storeId" value="<?=$Id?>">
      <input type="hidden" name="userId" ng-value="userId" required>
      <div class="modal-body">
        <b>People Username / Email</b>
        <i ng-bind="ownerValidation" ng-style="{'color':ownerValidationColor}"></i>
        <input type="text" name="owner" autocomplete="off" class="form-control" ng-model="owner" id="owner" ng-change="checkOwnerExist()" required>                
      
        <br>
        <b>Role</b>
        <select name="role" class="form-control">
            <option>Admin</option>
            <option>Staff</option>
        </select>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>

<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode-2"), {
    text: "https://menully.com/<?=$store->storeCode;?>/",
    width: 200,
    height: 200,
    colorDark: "#000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});



var app = angular.module("myApp", []);
app.controller('myCtrl', function($scope, $http) {
   

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
                $scope.userId = response.data.result.Id;
                $scope.ownerValidationColor = "green";
                document.getElementById("owner").setCustomValidity("");

            } else {
                $scope.ownerValidation = "Account not exists";
                $scope.ownerValidationColor = "red";
                document.getElementById("owner").setCustomValidity("Account not exists");
            }
        }, function myError(response) {
            $scope.storeCodeValidation = response.statusText;
        });
    };



});
</script>