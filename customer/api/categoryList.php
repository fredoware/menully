<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$categoryList = menuCategory()->list("storeId=$store->Id and isPublished=1 and isDeleted=0");
$json = array();
$json["total"] = count($categoryList);
$json["list"] = $categoryList;

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
?>
