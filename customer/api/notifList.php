<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");
$deviceId = $_GET["deviceId"];

$notifications = notification()->list("status!='Read' and deviceId='$deviceId' and storeCode='$storeCode' and receiver='Customer' order by Id desc");
$pending = notification()->count("status='Pending' and deviceId='$deviceId' and storeCode='$storeCode' and receiver='Customer'");

$json = array();
$json["all"] = $notifications;
$json["pending"] = $pending;

$jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;

$model = notification();
$model->obj["status"] = "Received";
$model->obj["dateReceived"] = "NOW()";
$model->update("status='Pending' and deviceId='$deviceId' and storeCode='$storeCode' and receiver='Customer'");
