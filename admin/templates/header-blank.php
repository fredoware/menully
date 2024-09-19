<!-- https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/index.html -->
<?php
session_start();
include_once("../config/database.php");
include_once("../config/Models.php");

?>

<style media="screen">
  .badge{
    background:red;color:white;padding:3px;border-radius:10px
  }
  .left-sidebar{
    background: #81c408 !important;
    color: white !important;
  }

  .left-sidebar a{
    color: white !important;
  }


</style>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dirty Dog Organic Farm</title>
  <link rel="shortcut icon" type="image/png" href="templates/favicon.png" />
  <link rel="stylesheet" href="templates/assets/css/styles.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" crossorigin="anonymous"></script>
</head>

<body>

      <div class="container-fluid">
