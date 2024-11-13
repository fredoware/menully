<?php

session_start();
include_once "../config/database.php";
include_once "../config/Models.php";

if (isset($_GET["storeCode"])) {
    $_SESSION["storeCode"] = $_GET["storeCode"];
    header("Location: ../customer/");
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}
$cart = $_SESSION["cart"];
$totalAmount = 0;
$totalQuantity = 0;

foreach ($cart as $key => $qty){
  $item = variation()->get("Id=$key");
  $totalAmount += $item->price*$qty;
  $totalQuantity += $qty;
}

$storeCode = $_SESSION["storeCode"];
$store = store()->get("storeCode='$storeCode'");
$category_list = menuCategory()->list("storeId=$store->Id and isDeleted=0 order by priority");

// =========================================================
// Check device Id exists
if (!isset($_SESSION['customer'])) {
    $fingerPrint = deviceFingerPrint();
    $checkDeviceSaved = customer()->count("deviceId='$fingerPrint'");
    if ($checkDeviceSaved) {
      $customer = customer()->get("deviceId='$fingerPrint'");
      $_SESSION['customer'] = array();
      $_SESSION['customer']["Id"] = $customer->Id;
      $_SESSION['customer']["name"] = $customer->name;
      $_SESSION['customer']["deviceId"] = $customer->deviceId;
    }
    else{
      header('Location: ../pages/new-customer');
    }
  }
  

$isLocal = true;
if ($_SERVER['HTTP_HOST'] == 'www.menully.com' || $_SERVER['HTTP_HOST'] == 'menully.com' || $_SERVER['HTTP_HOST'] == 'admin.menully.com') {
    $isLocal = false;
  }

?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    
<?php if ($isLocal): ?>
    <base href="/menully/customer/">
<?php else: ?>
    <base href="/customer/">
<?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My AngularJS App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-sanitize.js"></script>
    <script src="app.module.js"></script>
    <script src="app.routes.js"></script>
    <script src="services/api.service.js"></script>
    <script src="controllers/HomeController.js"></script>
    <script src="controllers/AboutController.js"></script>
    <script src="controllers/OrderController.js"></script>
    <script src="controllers/MainController.js"></script>
    <script src="controllers/MenuController.js"></script>
    <script src="controllers/ItemController.js"></script>
    <script src="controllers/VoucherController.js"></script>
    <script src="controllers/FeedbackController.js"></script>
    <script src="controllers/ReportController.js"></script>
    <script src="controllers/NotificationController.js"></script>
    <script src="controllers/CartController.js"></script>


    <!-- Favicons -->
    <link href="templates/source/img/favicon.png" rel="icon">
    <link href="templates/source/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Vendor CSS Files -->
    <link href="templates/source/bootstrap.min.css" rel="stylesheet">
    <link href="templates/source/bootstrap-icons.css" rel="stylesheet">
    <link href="templates/source/aos.css" rel="stylesheet">
    <link href="templates/source/glightbox.min.css" rel="stylesheet">
    <link href="templates/source/swiper-bundle.min.css" rel="stylesheet">

    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    /* Dynamic colors based on the theme */
    :root {
        --color-default: #212529;
        --color-primary: <?=$store->themePrimary;
        ?> !important;
        --color-secondary: <?=$store->themeSecondary;
        ?> !important;
    }
    </style>
    <link href="templates/source/main.css" rel="stylesheet">
    <link href="templates/custom.css" rel="stylesheet">
    <link href="templates/custom2.css" rel="stylesheet">
</head>

<body ng-controller="MainController">

    <div class="container-fluid bg-white cover-size">
        <div class="spinner-wrapper" ng-show="pageSpinner">
            <div class="spinner-border"></div>
        </div>


        <a class="fab fixed-tl clickable" ng-show="apiService.backButton" href="{{apiService.backButton}}" ><i
                class="bi bi-arrow-left"></i></a>

        <button class="fab fixed-tr clickable" ng-show="settingsButton" ng-click="openNav()"><i
        class="bi bi-gear-fill"></i></button>

        
    <div ng-if="apiService.totalCartAmount>0">
        <a class="row justify-content-center cart-main" href="./cart" ng-show="apiService.showCartBanner">
            <div class="col-lg-6 col-md-10 col-sm-12 cart">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                {{apiService.totalCartQuantity}}
                            </div>
                            <div class="col">
                                View your cart
                            </div>
                            <div class="col-3">
                                ₱{{apiService.totalCartAmount | formatMoney}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

        <img src="../media/<?=$store->logo?>" class="logo">
        <img src="../media/<?=$store->cover?>" class="cover-photo">

        <div class="card menu-content">
            <div class="card-body">

                <!-- ===================================================================== -->

                <div ng-view></div>

                <!-- ===================================================================== -->

            </div>
        </div>
    </div>


    <script src="templates/source/bootstrap.bundle.min.js"></script>
    <script src="templates/source/aos.js"></script>
    <script src="templates/source/glightbox.min.js"></script>
    <script src="templates/source/purecounter_vanilla.js"></script>
    <script src="templates/source/swiper-bundle.min.js"></script>
    <script src="templates/source/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="templates/source/main.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script src="templates/custom.js"></script>

</body>

</html>

<script>
sessionStorage.setItem('storeCode', '<?=$storeCode?>');
sessionStorage.setItem('storeLogo', '<?=$store->logo?>');
sessionStorage.setItem('totalAmount', '<?=$totalAmount?>');
sessionStorage.setItem('totalQuantity', '<?=$totalQuantity?>');

<?php if ($isLocal): ?>
    sessionStorage.setItem('baseUrl', '/menully');
<?php else: ?>
    sessionStorage.setItem('baseUrl', '');
<?php endif; ?>
</script>