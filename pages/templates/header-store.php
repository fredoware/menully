<script type="text/javascript">
	function format_money(n){
		n = parseFloat(n).toFixed(2)
		return "₱" + Number(n).toLocaleString('en');
	}
</script>
<?php
session_start();
include_once("../config/database.php");
include_once("../config/Models.php");

if (isset($_SESSION["store"])) {
  $storeName = $_SESSION["store"];
  $store = store()->get("storeCode='$storeName'");
}
else{
  header("Location: qr-expired.php");
}

if (isset($_SESSION['user_session'])) {
	  $username = $_SESSION['user_session']['username'];
	  $user = user()->get("username='$username'");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?=$store->name?>'s QR Menu</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="templates/source/img/favicon.png" rel="icon">
  <link href="templates/source/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="templates/source/bootstrap.min.css" rel="stylesheet">
  <link href="templates/source/bootstrap-icons.css" rel="stylesheet">
  <link href="templates/source/aos.css" rel="stylesheet">
  <link href="templates/source/glightbox.min.css" rel="stylesheet">
  <link href="templates/source/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <style>
    /* Dynamic colors based on the theme */
    :root {
      --color-default: #212529;
      --color-primary: <?=$store->themePrimary;?> !important;
      --color-secondary: <?=$store->themeSecondary;?> !important;
    }
  </style>
  <link href="templates/source/main.css" rel="stylesheet">
  <link href="templates/custom.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.4/angular-sanitize.js" type="text/javascript"></script>

</head>

<body ng-app="myApp" ng-controller="myCtrl">
  
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="store-main.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="../media/<?=$store->logo?>">
        <h1><?=$store->name?></h1>
      </a>

      <nav id="navbar" class="navbar">
      <ul style="list-style-type: none;">
            <li><a href="store-main.php">Notification</a></li>
            <li class="dropdown"><a href="#"><span>Orders</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
              <ul>
              <li><a href="store-orders.php?status=Pending">Pending</a></li>
              <li><a href="store-orders.php?status=Confirmed">Confirmed</a></li>
              <li><a href="store-orders.php?status=Ready">Ready</a></li>
              <li><a href="store-orders.php?status=Delivered">Delivered</a></li>
              <li><a href="store-orders.php?status=Canceled">Canceled</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Store Settings</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
              <ul>
            <li><a href="store-menu-category.php">Menu Set up</a></li>
            <li><a href="store-vouchers.php">Voucher Set up</a></li>
            <li><a href="store-best-sellers.php" style="color:green;">Best Sellers!</a></li>
            <li><a href="store-not-available.php" style="color:red;">Unavailable items</a></li>
            </ul>
          </li>
            <!-- <li><a href="store-customer-menu.php">Customer Order</a></li> -->
						<hr>
            <li><a href="store-feedback.php">Customer's Feedback</a></li>
            <li><a href="store-people.php">People</a></li>
            <li><a href="store-qr.php">Store QR Code</a></li>
            <li><a href="../<?=$store->storeCode?>/">Customer's View</a></li>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->


  <div class="desktop-only" style="height:20px"> </div>