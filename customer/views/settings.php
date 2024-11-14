<div ng-controller="SettingsController" class="text-center">
    <?php 
session_start();

include_once("../../config/database.php");
include_once("../../config/Models.php");

$myStoreList = array();
if (isset($_SESSION['user_session'])) {
	  $username = $_SESSION['user_session']['username'];
	  $user = user()->get("username='$username'");
		$storePeopleList = storePeople()->list("userId=$user->Id");
		foreach ($storePeopleList as $row) {
			$myStore = store()->get("Id=$row->storeId");
			array_push($myStoreList, $myStore);
		}
}
?>


    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <div class="category-name text-center">settings</div>

    <?php if(isset($_SESSION['user_session'])): ?>
    <div class="row">
        <?php foreach ($myStoreList as $row): ?>
        <div class="col-4 col-lg-3">
            <a href="../seller/?storeCode=<?=$row->storeCode?>">
                <div class="square-container">
                    <img src="../media/<?=$row->logo?>" />
                </div>
            </a>
            <?=$row->name?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="row">
        <a class="col-lg-4 col-md-6 mt-2">
            <div class="card clickable" ng-click="openBottomSheet()">
                <div class="card-body">
                    View QR Code
                </div>
            </div>
        </a>


        <a class="col-lg-4 col-md-6 mt-2" href="./history">
            <div class="card clickable">
                <div class="card-body">
                    Order History
                </div>
            </div>
        </a>


        <?php if(isset($_SESSION['user_session'])): ?>
        <a class="col-lg-4 col-md-6 mt-2" href="../{{storeCode}}/log-out">
            <div class="card clickable">
                <div class="card-body">
                    Seller Log Out
                </div>
            </div>
        </a>
        <?php else: ?>
        <a class="col-lg-4 col-md-6 mt-2" href="../{{storeCode}}/sign-in">
            <div class="card clickable">
                <div class="card-body">
                    Seller Log In
                </div>
            </div>
        </a>
        <?php endif; ?>
        <!-- <div class="col-lg-4 col-md-6 mt-2" ng-click="customerLogout()">
            <div class="card clickable">
                <div class="card-body">
                    Customer Logout
                </div>
            </div>
        </div> -->

    </div>

    <div class="backdrop" id="bottomBackdrop" ng-click="closeBottomSheet(false)"></div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div id="bottomSheet" class="bottom-sheet">
                <div class="sheet-content">
                    <div class="sheet-header">
                        <span class="close-btn" ng-click="closeBottomSheet(false)">&times;</span>
                    </div>
                    <div class="sheet-body">
                        <center>
                            <div ng-app="myApp">
                                <qr-code text="https://menully.com/{{storeCode}}/" width="300" height="300" color-dark="#000"
                                    color-light="#fff">
                                </qr-code>
                            </div>
                        </center>

                        <div style="height:50px;"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>