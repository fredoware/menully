<?php
  session_start();
  require_once 'config/database.php';
  require_once 'config/Models.php';

  $_SESSION["store"] = $_GET["store"];
	$_SESSION["cart"] = array();
	$_SESSION["myOrders"] = array();
	$_SESSION["customer"] = "";

  $storeCode = $_GET["store"];
  $store = store()->get("storeCode='$storeCode'");

  $model = store();
  $model->obj["totalVisitor"] = $store->totalVisitor + 1;
  $model->update("Id=$store->Id");

  header('Location: pages/best-sellers.php');

?>
