<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

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
	$json["list"] = $itemList;

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}
