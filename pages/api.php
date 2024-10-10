<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$action = $_GET['action'];

switch ($action) {
	
	case 'category-list' :
		category_list();
		break;
	
	case 'best-sellers' :
		best_sellers();
		break;
	
	case 'item-list' :
		item_list();
		break;

	case 'cart-list' :
		cart_list();
		break;

	case 'add-to-cart' :
		add_to_cart();
		break;

	case 'test-cart' :
		test_cart();
		break;
		

	case 'update-cart' :
		update_cart();
		break;
		

	default :
}

function test_cart(){

	print_r($_SESSION["cart"]);
}

function category_list(){
	$storeId = $_GET["storeId"];


	$categoryList = menuCategory()->list("storeId=$storeId and isDeleted=0");
	$json = array();
	$json["total"] = count($categoryList);
	$json["list"] = $categoryList;

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}


function item_list(){
	$categoryId = $_GET["categoryId"];


	$itemList = menuItem()->list("menuCategoryId=$categoryId and isDeleted=0");
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

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}


function cart_list(){

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
}


function update_cart()
{

	if ($_GET['value']==0) {
		unset($_SESSION["cart"][$_GET['varId']]);
	}
	else{
		$_SESSION["cart"][$_GET['varId']] = $_GET['value'];
	}
}


function best_sellers(){
	$storeId = $_GET["storeId"];

	$itemList = menuItem()->list("storeId=$storeId and isBestSeller=1 and isDeleted=0");
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

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}


function add_to_cart()
{

	if (isset($_SESSION["cart"][$_GET['varId']])) {
		$_SESSION["cart"][$_GET['varId']] += $_GET['value'];
	}
	else{
		$_SESSION["cart"][$_GET['varId']] = $_GET['value'];
	}
}