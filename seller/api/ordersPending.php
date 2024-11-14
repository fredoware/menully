<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$date = date("Y-m-d");

$json = orderMain()->count("status='Pending' and notifStatus='Pending' and storeCode='$storeCode' and date='$date'");

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;

$model = orderMain();
$model->obj["notifStatus"] = "Received";
$model->update("status='Pending' and notifStatus='Pending' and storeCode='$storeCode' and date='$date'");
?>
