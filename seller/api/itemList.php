<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$key = $_GET["key"];
$value = $_GET["value"];
$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");
$title = "";

$sqlQuery = "";
if ($key=="menuCategoryId") {
    $category = menuCategory()->get("Id=$value");
    $title = $category->name;
    $sqlQuery = "and $key=$value";
}
if ($key=="isAvailable" && $value==0) {
    $title = "Unavailable Items";
    $sqlQuery = "and $key=$value";
}
if ($key=="isBestSeller") {
    $title = "Best Sellers";
    $sqlQuery = "and $key=$value";
}

if ($key=="status") {
    $title = "Draft Items";
    $sqlQuery = "and $key='$value'";
}



$itemList = menuItem()->list("Id>0 $sqlQuery and storeId=$store->Id and isDeleted=0 order by isAvailable desc");
$json = array();
$json["total"] = count($itemList);


$itemListArray = array();
foreach ($itemList as $row) {
    $items = array();
    $items["product"] = $row;
    $items["variation"] = variation()->list("itemId=$row->Id order by price");
    if(count($items["variation"])>0){
        $items["lowestPrice"] = $items["variation"][0]->price;
        $items["varId"] = $items["variation"][0]->Id;
    }
    else{
        $items["lowestPrice"] = 0;
        $items["varId"] = 0;
    }
    array_push($itemListArray, $items);

}

$json["list"] = $itemListArray;
$json["title"] = $title;

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
?>
