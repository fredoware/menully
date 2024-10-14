<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$action = $_GET['action'];

switch ($action) {
	
	case 'category-list' :
		category_list();
		break;

	case 'voucher-list' :
		voucher_list();
		break;
	
	case 'best-sellers' :
		best_sellers();
		break;
	
	case 'history-list' :
		history_list();
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
	

	case 'claim-voucher' :
		claim_voucher();
		break;


	case 'use-voucher' :
		use_voucher();
		break;


	case 'place-order' :
		place_order();
		break;


	case 'customer-notification' :
		customer_notification();
		break;

	case 'update-order-notification' :
		update_order_notification();
		break;
		

	default :
}

function update_order_notification(){
	$_SESSION["orderNotification"] = $_GET["status"];
}

function customer_notification(){
	$storeCode = $_GET['storeCode'];
	$customerId = $_SESSION['customer']["Id"];

	$json = array();
	$json["status"] = "";
	$orderExist = orderMain()->count("customerId=$customerId and storeCode='$storeCode'");
	if ($orderExist) {
		$order = orderMain()->get("customerId=$customerId and storeCode='$storeCode' order by Id desc limit 1");
		$json["status"] = $order->status;
	}

	echo json_encode($json);


}

function test_cart(){

	print_r($_SESSION["cart"]);
}

function history_list(){
	$storeCode = $_GET["storeCode"];
	$customerId = $_SESSION['customer']["Id"];

	$historyList = array();
    $orderMainList = orderMain()->list("customerId=$customerId and storeCode='$storeCode' order by Id desc");
	foreach ($orderMainList as $row) {
		$item = array();
		$item["main"] = $row;
		$item["total"] = total_order_amount($row->orderNumber);
		
		if ($row->voucherId) {
			$item["voucher"] = voucher()->get("Id=$row->voucherId");
		}
		$orderItemList = array();
		$orderItem = orderItem()->list("orderNumber=$row->orderNumber");
		foreach ($orderItem as $row) {
			$item2 = array();
			$item2["orderItem"] = $row;
			$item2["item"] = menuItem()->get("Id=$row->itemId");
			$item2["variation"] = variation()->get("Id=$row->varId");
			array_push($orderItemList, $item2);
		}
		$item["items"] = $orderItemList;
      	array_push($historyList, $item);
    }

	
	$jsonList = json_encode($historyList, JSON_FORCE_OBJECT);

	echo $jsonList;
}

function voucher_list(){
	$storeId = $_GET["storeId"];
	$customerId = $_SESSION['customer']["Id"];

	$myVoucherList = array();
    $custVoucherList = custVoucher()->list("custId=$customerId and status='Pending'");
    foreach ($custVoucherList as $row) {
		$item = array();
		$voucher = voucher()->get("Id=$row->voucherId");
      	$item["voucher"] = $voucher;
		$item["expiring"] = days_hours_left($voucher->validUntil);
      	array_push($myVoucherList, $item);
    }

    $voucherList = array();
    $allVoucherList = voucher()->list("status='Active' and storeId=$storeId");
    foreach ($allVoucherList as $row) {
      $voucherExist = custVoucher()->count("custId=$customerId and voucherId=$row->Id");
      if (!$voucherExist) {
		  $item = array();
      	$item["voucher"] = $row;
		$item["expiring"] = days_hours_left($row->validUntil);
      	array_push($voucherList, $item);
      }
    }

	$json = array();
	$json["total"] = count($voucherList);
	$json["vouchers"] = $voucherList;
	$json["myVouchers"] = $myVoucherList;

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}

function category_list(){
	$storeId = $_GET["storeId"];

	$categoryList = menuCategory()->list("storeId=$storeId and isPublished=1 and isDeleted=0");
	$json = array();
	$json["total"] = count($categoryList);
	$json["list"] = $categoryList;

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}


function item_list(){
	$categoryId = $_GET["categoryId"];


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


function claim_voucher(){

	$model = custVoucher();
	$model->obj["voucherId"] = $_GET["voucherId"];
	$model->obj["custId"] = $_SESSION['customer']["Id"];
	$model->obj["dateClaimed"] = "NOW()";
	$model->create();
}


function use_voucher(){

	$result = array();
	$voucherId = $_GET["voucherId"];
	$voucher = voucher()->get("Id=$voucherId");

	$cart = $_SESSION["cart"];

  $totalAmount = 0;

  foreach ($cart as $key => $qty){
    $item = variation()->get("Id=$key");
    $totalAmount += $item->price*$qty;
  }

	if ($totalAmount>=$voucher->minimumSpend) {
		$_SESSION["voucherId"] = $_GET["voucherId"];
		$_SESSION["voucherDiscount"] = $voucher->discount;
		$_SESSION["voucherName"] = $voucher->name;
		$result["success"] = true;
		$result["minSpend"] = $voucher->minimumSpend;
	}
	else{
		$result["success"] = false;
		$result["minSpend"] = $voucher->minimumSpend;
	}


	$jsonList = json_encode($result, JSON_FORCE_OBJECT);

	echo $jsonList;
}

function place_order(){
	$cart = $_SESSION["cart"];
	$orderNumber = rand(100000,999999);
	$store = $_GET["storeCode"];
	$voucherId = $_SESSION["voucherId"];
	$customerId = $_SESSION['customer']["Id"];

	$model = orderMain();
	$model->obj["customer"] = $_SESSION['customer']["name"];
	if (isset($_SESSION["table"]["Id"])) {
		$model->obj["tableId"] = $_SESSION["table"]["Id"];
	  }
	$model->obj["customerId"] = $customerId;
	$model->obj["notes"] = $_GET["notes"];
	$model->obj["orderNumber"] = $orderNumber;
	$model->obj["date"] = "NOW()";
	$model->obj["storeCode"] = $store;
	$model->obj["voucherId"] = $voucherId;
	$model->create();


	foreach ($cart as $key => $value) {
		
		$var = variation()->get("Id=$key");
		$item = menuItem()->get("Id=$var->itemId");

		$model = orderItem();
		$model->obj["orderNumber"] = $orderNumber;
		$model->obj["itemId"] = $item->Id;
		$model->obj["varId"] = $key;
		$model->obj["quantity"] = $value;
		$model->obj["dateAdded"] = "NOW()";
		$model->create();

		$model = menuItem();
		$model->obj["totalOrder"] = $item->totalOrder + 1;
		$model->update("Id=$item->Id");

	}

	$model = custVoucher();
	$model->obj["status"] = "Used";
	$model->obj["dateUsed"] = "NOW()";
	$model->update("voucherId=$voucherId and custId=$customerId");


	$_SESSION["cart"] = array();
	$_SESSION["voucherId"] = 0;
}