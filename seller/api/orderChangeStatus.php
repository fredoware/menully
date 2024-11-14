<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

function notif($status, $storeCode)
{
    $store = store()->get("storeCode='$storeCode'");
    $msg = "";
    if ($status == "Pending") {
        $msg = $store->pendingMessage;
    }
    if ($status == "Confirmed") {
        $msg = $store->confirmedMessage;
    }
    if ($status == "Ready") {
        $msg = $store->readyMessage;
    }
    if ($status == "Delivered") {
        $msg = $store->deliveredMessage;
    }
    if ($status == "Canceled") {
        $msg = $store->canceledMessage;
    }

    return $msg;
}


$itemId = $_GET["itemId"];

$model = orderMain();
$model->obj["status"] = $_GET["status"];
$model->obj["notifStatus"] = "Read";
$model->update("Id=$itemId");

$order = orderMain()->get("Id=$itemId");
$model = notification();
$model->obj["storeCode"] = $order->storeCode;
$model->obj["deviceId"] = $order->deviceId;
$model->obj["receiver"] = "Customer";
$model->obj["type"] = "Order";
$model->obj["message"] = notif($order->status, $order->storeCode);
$model->create();
?>
