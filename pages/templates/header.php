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

if (!isset($_SESSION["cart"])) {
	$_SESSION["cart"] = array();
	$_SESSION["myOrders"] = array();
	$_SESSION["customer"] = "";
}


if (isset($_GET["store"])) {
  $storeCode = $_GET["store"];
  $store = store()->get("storeCode='$storeCode'");

  $category_list = menuCategory()->list("storeId=$store->Id");
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
  <link href="../pages/templates/source/main.css" rel="stylesheet">
  <link href="../pages/templates/custom.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy
  * Updated: Jan 30 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="best-sellers" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="../media/<?=$store->logo?>">
        <h1><?=$store->name?></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
            <li><a href="best-sellers" style="color:red;">Best Sellers!</a></li>
						<?php foreach ($category_list as $row): ?>
	            <li><a href="menu?Id=<?=$row->Id?>"><?=$row->name?></a></li>
						<?php endforeach; ?>
						<hr>
            <li><a href="cart">My Cart</a></li>
            <li><a href="order">My Order</a></li>
            <li><a href="store-qr">Store QR Code</a></li>
            <li><a href="../pages/sign-in.php">Sign in</a></li>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->
