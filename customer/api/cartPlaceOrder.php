<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$cart = $_SESSION["cart"];
$orderNumber = rand(100000, 999999);
$store = $_GET["storeCode"];
// $voucherId = $_SESSION["voucherId"];
$customerId = $_SESSION['customer']["Id"];

$model = orderMain();
$model->obj["customer"] = $_SESSION['customer']["name"];
if (isset($_SESSION["table"]["Id"])) {
    $model->obj["tableId"] = $_SESSION["table"]["Id"];
}
$model->obj["customerId"] = $customerId;
$model->obj["notes"] = $_GET["notes"];
$model->obj["orderNumber"] = $orderNumber;
$model->obj["date"] = "NOW()";
$model->obj["time"] = "NOW()";
$model->obj["storeCode"] = $store;
// $model->obj["voucherId"] = $voucherId;
$model->create();

foreach ($cart as $key => $value) {

    $var = variation()->get("Id=$key");
    $item = menuItem()->get("Id=$var->itemId");

    $model = orderItem();
    $model->obj["orderNumber"] = $orderNumber;
    $model->obj["itemId"] = $item->Id;
    $model->obj["varId"] = $key;
    $model->obj["quantity"] = $value;
    $model->obj["dateAdded"] = "NOW()";
    $model->create();

    $model = menuItem();
    $model->obj["totalOrder"] = $item->totalOrder + 1;
    $model->update("Id=$item->Id");

}

// $model = custVoucher();
// $model->obj["status"] = "Used";
// $model->obj["dateUsed"] = "NOW()";
// $model->update("voucherId=$voucherId and custId=$customerId");

$_SESSION["cart"] = array();
$_SESSION["voucherId"] = 0;
