<?php
session_start();
include_once($ROOT_DIR . "config/database.php");
include_once($ROOT_DIR . "config/Models.php");
if (empty($_SESSION['user_session']) && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) != '/log-in.php') {
    header('Location: log-in.php');
    exit;
}
$role = $_SESSION["user_session"]["role"];
?>

<html lang="en">
  <head>
  	<title>Fredoware's Menubook</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="templates/style.css">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
<div class="row" style="height:100%;"  >


  <div class="col-3 nav-right" >

    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark nav-right">
    <h5 class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">MENUBOOK</span>
    </h5>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li>
        <a href="index.php" class="nav-link text-white">
          <svg class="bi" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          Dashboard
        </a>
      </li>

      <li class="nav-item">
        <a href="user.php?role=Admin" class="nav-link text-white" aria-current="page">
          <svg class="" width="16" height="16"><use xlink:href="#home"></use></svg>
          Users
        </a>
      </li>


      <li>
        <a href="store.php" class="nav-link text-white">
          <svg class="bi" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          Store
        </a>
      </li>




    </ul>
    <hr>
            <div class="log-out">
            <a href="process.php?action=log-out" class="d-flex align-items-center text-white text-center text-decoration-none">

              <strong>LOG OUT</strong>
            </a>


  </div>
</div>
</div>

<div class="col-9">
