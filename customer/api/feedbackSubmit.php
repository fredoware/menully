<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");


$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$model = ratings();
$model->obj["storeId"] = $store->Id;
$model->obj["stars"] = $_GET["stars"];
$model->obj["feedback"] = $_GET["feedback"];
$model->obj["name"] = $_GET["name"];
$model->obj["dateAdded"] = "NOW()";
$model->create();
?>
