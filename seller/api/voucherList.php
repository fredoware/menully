<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$list = voucher()->list("storeId=$store->Id and isDeleted=0");

$jsonList = json_encode($list, JSON_FORCE_OBJECT);

echo $jsonList;
?>
