<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$cart = $_SESSION["cart"];

$itemListArray = array();
foreach ($cart as $key => $value) {
	
	$var = variation()->get("Id=$key");
	$item = menuItem()->get("Id=$var->itemId");
	$items = array();
	$items["product"] = $item;
	$items["variation"] = $var;
	$items["quantity"] = $value;
	$items["total"] = $value*$var->price;

	array_push($itemListArray, $items);
}


$json["list"] = $itemListArray;

 $jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
?>
