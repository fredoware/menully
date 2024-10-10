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
	
	case 'item-list' :
		item_list();
		break;
	

	default :
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
		}
		else{
			$items["lowestPrice"] = 0;
		}
		array_push($itemListArray, $items);

	}

	$json["list"] = $itemListArray;

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}