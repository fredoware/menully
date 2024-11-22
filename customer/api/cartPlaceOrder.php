<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

// $orderNumber = rand(100000, 999999);
$storeCode = $_POST["storeCode"];
$store = store()->get("storeCode='$storeCode'");
$voucherId = $_POST["voucherId"];
$deviceId = $_POST['Id'];
$tableId = $_POST['tableId'];
$dateToday = date("Y-m-d");

$countOrders = orderMain()->count("storeCode='$storeCode' and date='$dateToday'");
$nextSequence = $countOrders + 1;
$dateSequence = date("ym-d");

$orderNumber = $dateSequence. sprintf("%03d", $nextSequence);;

$model = orderMain();
$model->obj["customer"] = $_POST['name'];
if (isset($_SESSION["table"]["Id"])) {
    $model->obj["tableId"] = $_SESSION["table"]["Id"];
}
$model->obj["deviceId"] = $deviceId;
$model->obj["notes"] = $_POST["notes"];
$model->obj["orderNumber"] = $orderNumber;
$model->obj["date"] = "NOW()";
$model->obj["time"] = "NOW()";
$model->obj["storeCode"] = $storeCode;
$model->obj["voucherId"] = $voucherId;
$model->obj["tableId"] = $tableId;
$model->create();

$deviceExist = customer()->count("deviceId='$deviceId'");
if (!$deviceExist) {
    $model = customer();
    $model->obj["deviceId"] = $deviceId;
    $model->obj["name"] = $_POST['name'];
    $model->create();
}


$cartList = json_decode($_POST["cart"], true);
foreach ($cartList as $row) {

    $Id = $row["id"];

    $var = variation()->get("Id=$Id");
    $item = menuItem()->get("Id=$var->itemId");

    $model = orderItem();
    $model->obj["orderNumber"] = $orderNumber;
    $model->obj["storeId"] = $store->Id;
    $model->obj["itemId"] = $item->Id;
    $model->obj["varId"] = $Id;
    $model->obj["quantity"] = $row["quantity"];
    $model->obj["dateAdded"] = "NOW()";
    $model->create();

    $model = menuItem();
    $model->obj["totalOrder"] = $item->totalOrder + 1;
    $model->update("Id=$item->Id");
}

$model = custVoucher();
$model->obj["status"] = "Used";
$model->obj["dateUsed"] = "NOW()";
$model->update("voucherId=$voucherId and deviceId='$deviceId'");

$model = notification();
$model->obj["storeCode"] = $storeCode;
$model->obj["deviceId"] = $deviceId;
$model->obj["receiver"] = "Store";
$model->obj["type"] = "Order";
$model->obj["message"] = "A new order submitted by " . $_POST['name'];
$model->create();

