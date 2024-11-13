<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");


$json = array();
$json["productLabels"] = ["aac", "asa", "aaa", "ada"];
$json["productData"] = [22,55,33,1,3];

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
?>
