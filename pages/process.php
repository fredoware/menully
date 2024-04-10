<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

		case 'add-to-cart' :
			add_to_cart();
			break;

		case 'claim-voucher' :
			claim_voucher();
			break;

		case 'use-voucher' :
			use_voucher();
			break;

		case 'store-log-in' :
			store_log_in();
			break;

		case 'store-sign-up' :
			store_sign_up();
			break;

		case 'update-cart' :
			update_cart();
			break;

		case 'place-order' :
			place_order();
			break;

		case 'remove-from-cart' :
			remove_from_cart();
			break;

		case 'change-order-status' :
			change_order_status();
			break;

		case 'change-item-status' :
			change_item_status();
			break;

		case 'best-seller-option' :
			best_seller_option();
			break;

		case 'category-save' :
			category_save();
			break;

		case 'item-save' :
			item_save();
			break;

		case 'voucher-save' :
			voucher_save();
			break;

		case 'change-voucher-status' :
			change_voucher_status();
			break;

	default :
}

function change_voucher_status(){
	$Id = $_GET["Id"];
	$model = voucher();
	$model->obj["status"] = $_GET["status"];
	$model->update("Id=$Id");

	header('Location: store-vouchers.php?status='.$_GET['status']);
}

function claim_voucher(){

	$model = user_voucher();
	$model->obj["voucherId"] = $_GET["voucherId"];
	$model->obj["userId"] = $_GET["userId"];
	$model->obj["dateClaimed"] = "NOW()";
	$model->create();

	header('Location: ../'.$_GET['store'].'/vouchers');
}


function use_voucher(){

	$voucherId = $_GET["voucherId"];
	$voucher = voucher()->get("Id=$voucherId");

	$cart = $_SESSION["cart"];

  $totalAmount = 0;

  foreach ($cart as $key => $qty){
    $item = menuItem()->get("Id=$key");
    $totalAmount += $item->price*$qty;
  }

	if ($totalAmount>$voucher->minimumSpend) {
		$_SESSION["voucherId"] = $_GET["voucherId"];
		$_SESSION["voucherDiscount"] = $voucher->discount;

		header('Location: ../'.$_GET['store'].'/cart');
	}
	else{
			header('Location: ../'.$_GET['store'].'/cart?error=Min spend must be ' . format_money($voucher->minimumSpend));
	}

}

function item_save()
{

		$storeId = $_POST["storeId"];
		$store = store()->get("Id=$storeId");

		$model = menuItem();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["menuCategoryId"] = $_POST["menuCategoryId"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["price"] = $_POST["price"];
  	$model->obj["description"] = $_POST["description"];

		if ($_POST["form-type"] == "add") {
			if ($_FILES['image']['name'] != "") {
				$image_file_name = uploadFile($_FILES["image"], $store->storeCode);
				$model->obj["image"] = $image_file_name;
			}
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			if ($_FILES['image']['name'] != "") {
				$item = menuItem()->get("Id=$Id");
				unlink('../media/' . $item->image);
				$image_file_name = uploadFile($_FILES["image"], $store->storeCode);
				$model->obj["image"] = $image_file_name;
			}
			$model->update("Id=$Id");
		}


header('Location: store-menu-item.php?Id=' . $_POST["menuCategoryId"]);
}



function voucher_save()
{

		$model = voucher();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["type"] = $_POST["type"];
  	$model->obj["discount"] = $_POST["discount"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["minimumSpend"] = $_POST["minimumSpend"];
  	$model->obj["maxQuantity"] = $_POST["maxQuantity"];
  	$model->obj["currentQuantity"] = $_POST["maxQuantity"];
  	$model->obj["validUntil"] = $_POST["validUntil"];

		if ($_POST["form-type"] == "add") {
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			$model->update("Id=$Id");
		}


header('Location: store-vouchers.php');
}



function category_save()
{
		$storeId = $_POST["storeId"];
		$store = store()->get("Id=$storeId");

		$model = menuCategory();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["description"] = $_POST["description"];

		if ($_POST["form-type"] == "add") {
			if ($_FILES['image']['name'] != "") {
				$image_file_name = uploadFile($_FILES["image"], $store->storeCode);
				$model->obj["image"] = $image_file_name;
			}
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			if ($_FILES['image']['name'] != "") {
				$category = menuCategory()->get("Id=$Id");
				unlink('../media/' . $category->image);
				$image_file_name = uploadFile($_FILES["image"], $store->storeCode);
				$model->obj["image"] = $image_file_name;
			}
			$model->update("Id=$Id");
		}

header('Location: store-menu-category.php' );
}

function store_sign_up(){

	$storeCode = $_POST["storeCode"];
	$ownerId = $_POST["ownerId"];

	$model = store();
	$model->obj["storeCode"] = $_POST["storeCode"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["phone"] = $_POST["phone"];
	$model->obj["address"] = $_POST["address"];

		// Create directory
	$newDri = "../media/" . $_POST["storeCode"];
	mkdir($newDri);
	$model->obj["password"] = $_POST["password"];
	if ($_FILES['logo']['name'] != "") {
		$image_file_name = uploadFile($_FILES["logo"], $_POST["storeCode"]);
		$model->obj["logo"] = $image_file_name;
	}
	$model->create();

	$store = store()->get("storeCode='$storeCode'");

	$model = store_people();
	$model->obj["userId"] = $ownerId;
	$model->obj["storeId"] = $store->Id;
	$model->obj["role"] = "Admin";
	$model->create();

	header('Location: process.php?action=store-log-in&store=' . $storeCode);
}

// function store_log_in(){
// 		$storeCode = $_POST["storeCode"];
// 		$password = $_POST["password"];
//
// 	  $_SESSION["store"] = $storeCode;
// 		$_SESSION["cart"] = array();
// 		$_SESSION["myOrders"] = array();
// 		$_SESSION["customer"] = "";
//
// 		$countStore = store()->count("storeCode='$storeCode' and password='$password'");
// 		if ($countStore==0):
// 			header('Location: sign-in.php?error=Account does not exist');
// 		else:
// 		  $_SESSION["store"] = $storeCode;
// 			header('Location: store-main.php');
// 		endif;
// }

function store_log_in(){
  $_SESSION["store"] = $_GET["store"];
	header('Location: store-main.php');
}

function change_order_status(){
	$Id = $_GET["Id"];

	$model = orderMain();
	$model->obj["status"] = $_GET["status"];
	$model->update("Id=$Id");

}

function best_seller_option(){
	$Id = $_GET["Id"];

	$model = menuItem();
	$model->obj["isBestSeller"] = $_GET["value"];
	$model->update("Id=$Id");

}

function change_item_status(){
	$Id = $_GET["Id"];

	$model = menuItem();
	$model->obj["status"] = $_GET["status"];
	$model->update("Id=$Id");

}

function place_order(){
	$cart = $_SESSION["cart"];
	$orderNumber = rand(100000,999999);
	$store = $_POST["storeCode"];
	$voucherId = $_SESSION["voucherId"];
	$customerId = $_POST["customerId"];

	$model = orderMain();
	$model->obj["customerId"] = $customerId;
	$model->obj["notes"] = $_POST["notes"];
	$model->obj["orderNumber"] = $orderNumber;
	$model->obj["date"] = "NOW()";
	$model->obj["storeCode"] = $store;
	$model->obj["voucherId"] = $voucherId;
	$model->create();


	foreach ($cart as $key => $value) {
		$model = orderItem();
		$model->obj["orderNumber"] = $orderNumber;
		$model->obj["itemId"] = $key;
		$model->obj["quantity"] = $value;
		$model->obj["dateAdded"] = "NOW()";
		$model->create();

		$item = menuItem()->get("Id=$key");
		$model = menuItem();
		$model->obj["totalOrder"] = $item->totalOrder + 1;
		$model->update("Id=$item->Id");

	}

	$model = user_voucher();
	$model->obj["status"] = "Used";
	$model->obj["dateUsed"] = "NOW()";
	$model->update("voucherId=$voucherId and userId=$customerId");


	$_SESSION["cart"] = array();
	$_SESSION["voucherId"] = 0;

	header('Location: ../'.$store.'/order');
}

function add_to_cart()
{
	if (isset($_SESSION["cart"][$_GET['itemId']])) {
		$_SESSION["cart"][$_GET['itemId']] += $_GET['value'];
	}
	else{
		$_SESSION["cart"][$_GET['itemId']] = $_GET['value'];
	}
}

function update_cart()
{
	$_SESSION["cart"][$_GET['itemId']] = $_GET['value'];
}

function remove_from_cart()
{
	unset($_SESSION["cart"][$_GET['itemId']]);

}
