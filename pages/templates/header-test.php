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

$_SESSION['returnLink'] = $actual_link;

if (!isset($_SESSION["cart"])) {
	$_SESSION["cart"] = array();
	$_SESSION["voucherId"] = 0;
	$_SESSION["voucherDiscount"] = 0;
}

if (isset($_GET["tblno"])) {
  $tblNo = $_GET["tblno"];
  $tbl = storeTable()->get("Id=$tblNo");
	$_SESSION["table"] = array();
  $_SESSION["table"]["Id"] = $tbl->Id;
  $_SESSION["table"]["name"] = $tbl->name;
}

// =========================================================
// Check device Id exists
if ($_SERVER['REQUEST_URI'] != "/menully/" . $_GET["store"] . "/" && $_SERVER['REQUEST_URI'] != "/" . $_GET["store"] . "/") {
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
    header('Location: new-customer');
  }
}

// =========================================================

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

if (isset($_GET["store"])) {
  $storeCode = $_GET["store"];
  $store = store()->get("storeCode='$storeCode'");
  $category_list = menuCategory()->list("storeId=$store->Id and isDeleted=0 order by priority");
}
else{
  header("Location: qr-expired.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?=$store->name?>'s QR Menu</title>
  <meta property="og:title" content="<?=$store->name?>'s QR Menu" />
  <meta property="og:url" content="https://menully.com/<?=$storeCode?>" />
  <meta property="og:image" content="https://menully.com/media/<?=$store->logo?>" />
  

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../pages/templates/source/img/favicon.png" rel="icon">
  <link href="../pages/templates/source/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../pages/templates/source/bootstrap.min.css" rel="stylesheet">
  <link href="../pages/templates/source/bootstrap-icons.css" rel="stylesheet">
  <link href="../pages/templates/source/aos.css" rel="stylesheet">
  <link href="../pages/templates/source/glightbox.min.css" rel="stylesheet">
  <link href="../pages/templates/source/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->

  <style>
    /* Dynamic colors based on the theme */
    :root {
      --color-default: #212529;
      --color-primary: <?=$store->themePrimary;?> !important;
      --color-secondary: <?=$store->themeSecondary;?> !important;
    }
  </style>
  <link href="../pages/templates/source/main.css" rel="stylesheet">
  <link href="../pages/templates/custom.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Angular ============================================== -->
   
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>


</head>



<body ng-app="myApp" ng-controller="myCtrl">
