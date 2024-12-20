<?php
session_start();
include_once("../config/database.php");
include_once("../config/Models.php");

$_SESSION['returnLink'] = $actual_link;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Menully - Digital QR Menu</title>
  <meta property="og:title" content="Menully QR Menu" />
  <meta property="og:url" content="https://menully.com" />
  <meta property="og:image" content="https://menully.com/website/source/img/open-graph.jpg" />
  

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
      --color-primary: #f64c10 !important;
      --color-secondary: #f64c10 !important;
    }
  </style>

  <link href="../pages/templates/source/main.css" rel="stylesheet">
  <link href="../pages/templates/custom.css" rel="stylesheet">
  <link href="../pages/templates/custom2.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Angular ============================================== -->
   
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.4/angular-sanitize.js" type="text/javascript"></script>


<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>



<body ng-app="myApp" ng-controller="myCtrl">
