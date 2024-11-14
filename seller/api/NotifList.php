<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$notifications = notification()->list("storeCode='$storeCode' and receiver='Store' order by Id desc");
$pending = notification()->count("status='Pending' and storeCode='$storeCode' and receiver='Store'");

$json = array();
$json["all"] = $notifications;
$json["pending"] = $pending;

$jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;

$model = notification();
$model->obj["status"] = "Received";
$model->obj["dateReceived"] = "NOW()";
$model->update("status='Pending' and storeCode='$storeCode' and receiver='Store'");

?>
