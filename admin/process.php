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

	case 'store-save' :
		store_save();
		break;

	case 'store-delete' :
		category_delete();
		break;

	case 'item-save' :
		item_save();
		break;



	default :
}


function account_delete(){

	$Id = $_GET["Id"];
	$model = account();
	$model->obj["isDeleted"] = 1;
	$model->update("Id=$Id");

	header('Location: ' . $_GET["url"] . '&success=Account Successfully Deleted');
}

function category_delete(){
	$Id = $_GET["Id"];
	category()->delete("Id=$Id");
	item()->delete("categoryId=$Id");

	header('Location: categories.php?published='. $_GET['isPublished'] .'&success=You have deleted this category');
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



function store_save(){
	#Process to save to the database

	$storeCode = $_POST["storeCode"];
	$owner = $_POST["owner"];
	$account = account()->get("username='$owner'");

	$model = store();
	$model->obj["storeCode"] = $_POST["storeCode"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["phone"] = $_POST["phone"];
	$model->obj["email"] = $_POST["email"];
	$model->obj["status"] = $_POST["status"];
	$model->obj["dateAdded"] = "NOW()";


	if ($_POST["form-type"] == "add") {
		$newDri = "../media/" . $_POST["storeCode"];
		mkdir($newDri);
		if ($_FILES['logo']['name'] != "") {
			$image_file_name = uploadFile($_FILES["logo"], $_POST["storeCode"]);
			$model->obj["logo"] = $image_file_name;
		}
		$model->create();

		$store = store()->get("storeCode='$storeCode'");
		$Id = $store->Id;

		$model = storePeople();
		$model->obj["userId"] = $account->Id;
		$model->obj["storeId"] = $store->Id;
		$model->obj["role"] = "Admin";
		$model->create();
	}

	if ($_POST["form-type"] == "edit") {
		$Id = $_POST["Id"];
		if ($_FILES['logo']['name'] != "") {
			$item = category()->get("Id=$Id");
			unlink('../media/' . $item->image);
			$image_file_name = uploadFile($_FILES["logo"]);
			$model->obj["logo"] = $image_file_name;
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


header('Location: store-menu-item.php?Id=' . $_POST["menuCategoryId"] . '&storeId=' . $storeId);
}
