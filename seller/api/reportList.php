<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");


// function sales per item item per sotore
function salesPerItem($itemId){
    $result = 0;
    $orderItems = orderItem()->list("itemId=$itemId");
    $item = menuItem()->get("Id=$itemId");
    foreach ($orderItems as $row) {
        $result += $item->price*$row->quantity;
    }       
    return $result;
}


// sales per category
$menuItemArray = array();
$menuItemList = menuItem()->list("isDeleted=0");
foreach ($menuItemList as $row) {
    $array = array();
    $array["label"] = $row->name;
    $array["value"] = salesPerItem($row->Id);
    array_push($menuItemArray, $array);
}

// Sales per date
usort($menuItemArray, function ($a, $b) {
    return $b['value'] <=> $a['value']; // <=> is the spaceship operator for comparison
});


$top10 = array_slice($menuItemArray, 0, 10);


$json = array();
$json["menuItems"] = $top10;

 $jsonList = json_encode($json);

echo $jsonList;
?>
