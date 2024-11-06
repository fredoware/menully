<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$categoryId = $_GET["Id"];
$category = menuCategory()->get("Id=$categoryId");


$itemList = menuItem()->list("menuCategoryId=$categoryId and isDeleted=0 order by isAvailable desc");
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
$json["category"] = $category->name;

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
?>
