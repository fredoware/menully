<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$ratingsObj = ratings()->list("storeId=$store->Id order by Id desc");
$feedbackList = array();
foreach ($ratingsObj as $row) {
    $item = array();
    $item["item"] = $row;

    try {
        $item["order"] = orderMain()->get("Id=$row->orderId");
    } catch (Exception $e) {
        $item["order"] = "";
    }
    array_push($feedbackList, $item);
}

$json = array();
$json["total"] = count($feedbackList);
$json["list"] = $feedbackList;

$jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
