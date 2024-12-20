<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

	case 'account-save' :
		account_save();
		break;

		case 'category-save' :
			category_save();
			break;
	
		case 'category-delete' :
			category_delete();
			break;

			case 'table-save' :
				table_save();
				break;
		
			case 'table-delete' :
				table_delete();
				break;

	case 'store-save' :
		store_save();
		break;

	// case 'store-delete' :
	// 	category_delete();
	// 	break;

	case 'item-save' :
		item_save();
		break;

	case 'add-people' :
		add_people();
		break;
		
	case 'remove-people' :
		remove_people();
		break;


	case 'change-item-status' :
		change_item_status();
		break;

	case 'best-seller-option' :
		best_seller_option();
		break;
	

		case 'item-delete' :
			item_delete();
			break;


	default :
}

function add_people(){
	$model = storePeople();
	$model->obj["storeId"] = $_POST["storeId"];
	$model->obj["userId"] = $_POST["userId"];
	$model->obj["role"] = $_POST["role"];
	$model->create();
	header('Location: store-detail.php?Id='.$_POST['storeId'].'&success=Account Successfully Added');
}

function remove_people(){
	$Id = $_GET['Id'];
	$model = storePeople();
	$model->delete("Id=$Id");
	header('Location: store-detail.php?Id='.$_GET['storeId'].'&success=Account Successfully Deleted');
}



function account_delete(){

	$Id = $_GET["Id"];
	$model = account();
	$model->obj["isDeleted"] = 1;
	$model->update("Id=$Id");

	header('Location: ' . $_GET["url"] . '&success=Account Successfully Deleted');
}

function item_delete(){

	$Id = $_GET["Id"];
	$model = menuItem();
	$model->obj["isDeleted"] = 1;
	$model->update("Id=$Id");

	header('Location: store-menu-item.php?Id='.$_GET['categoryId'].'&storeId='.$_GET['storeId']);
}

function category_delete(){

	$categoryId = $_GET["categoryId"];
	$model = menuCategory();
	$model->obj["isDeleted"] = 1;
	$model->update("Id=$categoryId");

	header('Location: store-categories.php?Id='.$_GET['storeId']);
}

function table_delete(){

	$tableId = $_GET["tableId"];
	$model = storeTable();
	$model->obj["isDeleted"] = 1;
	$model->update("Id=$tableId");

	header('Location: store-tables.php?Id='.$_GET['storeId']);
}



function account_save(){
	#Process to save to the database

	$model = account();
	$model->obj["google_id"] = $_POST["username"];
	$model->obj["username"] = $_POST["username"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["role"] = $_POST["role"];
	$model->obj["dateAdded"] = "NOW()";

	if ($_POST["form-type"] == "add") {
		$model->obj["password"] = $_POST["password"];
		$model->create();
	}

	if ($_POST["form-type"] == "edit") {
		$Id = $_POST["Id"];
		$model->update("Id=$Id");
	}

	header('Location: accounts.php?role=' . $_POST["role"]);
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
	$model->obj["isAvailable"] = $_GET["isAvailable"];
	$model->update("Id=$Id");

}



function store_save(){
	#Process to save to the database

	$storeCode = $_POST["storeCode"];

	$model = store();
	$model->obj["storeCode"] = $_POST["storeCode"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["phone"] = $_POST["phone"];
	$model->obj["email"] = $_POST["email"];
	$model->obj["status"] = $_POST["status"];
	$model->obj["themePrimary"] = $_POST["themePrimary"];
	$model->obj["themeSecondary"] = $_POST["themeSecondary"];
	$model->obj["address"] = $_POST["address"];
	$model->obj["pendingMessage"] = $_POST["pendingMessage"];
	$model->obj["confirmedMessage"] = $_POST["confirmedMessage"];
	$model->obj["deliveredMessage"] = $_POST["deliveredMessage"];
	$model->obj["readyMessage"] = $_POST["readyMessage"];
	$model->obj["canceledMessage"] = $_POST["canceledMessage"];
	$model->obj["dateAdded"] = "NOW()";


	if ($_POST["form-type"] == "add") {
		$newDri = "../media/" . $_POST["storeCode"];
		mkdir($newDri);
		if ($_FILES['logo']['name'] != "") {
			$logo_file_name = uploadFile($_FILES["logo"], $_POST["storeCode"]);
			$model->obj["logo"] = $logo_file_name;
		}
		if ($_FILES['cover']['name'] != "") {
			$cover_file_name = uploadFile($_FILES["cover"], $_POST["storeCode"]);
			$model->obj["cover"] = $cover_file_name;
		}
		$model->create();

		$store = store()->get("storeCode='$storeCode'");
		$Id = $store->Id;

	}

	if ($_POST["form-type"] == "edit") {
		$Id = $_POST["Id"];
		if ($_FILES['logo']['name'] != "") {
			$item = store()->get("Id=$Id");
			unlink('../media/' . $item->logo);
			$logo_file_name = uploadFile($_FILES["logo"], $_POST["storeCode"]);
			$model->obj["logo"] = $logo_file_name;
		}
		if ($_FILES['cover']['name'] != "") {
			$item = store()->get("Id=$Id");
			unlink('../media/' . $item->cover);
			$cover_file_name = uploadFile($_FILES["cover"], $_POST["storeCode"]);
			$model->obj["cover"] = $cover_file_name;
		}
		$model->update("Id=$Id");
	}

	header('Location: store-detail.php?Id=' . $Id);

}



function category_save()
{
		$storeId = $_POST["storeId"];
		$store = store()->get("Id=$storeId");

		$model = menuCategory();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["isPublished"] = $_POST["isPublished"];
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

header('Location: store-categories.php?Id='.$storeId );
}


function table_save()
{
		$storeId = $_POST["storeId"];
		$store = store()->get("Id=$storeId");

		$model = storeTable();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["name"] = $_POST["name"];

		if ($_POST["form-type"] == "add") {
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			$model->update("Id=$Id");
		}

header('Location: store-tables.php?Id='.$storeId );
}

function item_save()
{

	$unitList = $_POST["unit"];
	$priceList = $_POST["price"];
	$variationIdList = $_POST["variationId"];

	$storeId = $_POST["storeId"];
	$store = store()->get("Id=$storeId");

	$model = menuItem();
  	$model->obj["storeId"] = $_POST["storeId"];
  	$model->obj["menuCategoryId"] = $_POST["menuCategoryId"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["isAvailable"] = $_POST["isAvailable"];
  	$model->obj["isBestSeller"] = $_POST["isBestSeller"];
  	$model->obj["description"] = $_POST["description"];

	if ($_POST["form-type"] == "add") {
		if ($_FILES['image']['name'] != "") {
			$image_file_name = uploadFile($_FILES["image"], $store->storeCode);
			$model->obj["image"] = $image_file_name;
		}
		$model->create();

		$item = menuItem()->get("Id>0 order by Id desc limit 1");
		$Id = $item->Id;
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

	// create varation 

	variation()->delete("itemId=$Id");

	foreach( $unitList as $key => $unit ) {
		$price = $priceList[$key];
		$variationId = $variationIdList[$key];
		$model = variation();
		if ($variationId) {
			$model->obj["Id"] = $variationId;
		}
		$model->obj["itemId"] = $Id;
		$model->obj["unit"] = $unit;
		$model->obj["price"] = $price;
		$model->create();
	  }


header('Location: store-menu-item.php?Id=' . $_POST["menuCategoryId"] . '&storeId=' . $storeId);
}