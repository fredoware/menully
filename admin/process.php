<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

		case 'store-save' :
			store_save();
			break;

		case 'user-save' :
			user_save();
			break;


		case 'category-save' :
			category_save();
			break;

		case 'category-delete' :
			category_delete();
			break;

		case 'item-save' :
			item_save();
			break;

		case 'item-delete' :
			item_delete();
			break;

		// ======================================
		// Please Refactor (for keneth)
		// ======================================

		case 'log-in' :
			log_in();
			break;

		case 'add-user' :
			add_user();
			break;

		case 'delete-user' :
			delete_user();
			break;

		case 'edit-user' :
			edit_user();
			break;

		case 'delete-store' :
			delete_store();
			break;

		case 'view-store' :
			view_store();
			break;

		case 'view-store-qr' :
			view_store_qr();
			break;

		case 'add-menu' :
			add_menu();
			break;

		case 'edit-menu' :
			edit_menu();
			break;


		case 'delete-menu' :
			delete_menu();
			break;

		case 'edit-store' :
			edit_store();
			break;

		case 'log-out' :
			log_out();
			break;


	default :
}
function log_in()
{
  $username = $_POST["username"];
  $password = $_POST["password"];
  $countContacts = user()->count("username='$username' and password='$password'");
  if ($countContacts == 0) {
header('Location: log-in.php?error=You entered a non-existing account');
  }
else {
	$user = user()->get("username='$username'");
			$_SESSION["user_session"] = array();
			$_SESSION["user_session"]["role"] = $user->role;
			$_SESSION["user_session"]["firstName"] = $user->firstName;

		header('Location: index.php?success=Welcome, '. $user->firstName);
}
}

function delete_user()
{
	$Id = $_GET["Id"];
  $model = user();
	$model->delete("Id=$Id");

	header('Location: user.php?success=You just deleted a user');

}

function store_save()
{

		$model = store();
  	$model->obj["storeCode"] = $_POST["storeCode"];
  	$model->obj["owner"] = $_POST["owner"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["phone"] = $_POST["phone"];
  	$model->obj["email"] = $_POST["email"];
  	$model->obj["address"] = $_POST["address"];
  	$model->obj["theme"] = $_POST["theme"];
  	$model->obj["email"] = $_POST["email"];

		if ($_POST["form-type"] == "add") {
			// Create directory
			$newDri = "../media/" . $_POST["storeCode"];
			mkdir($newDri);
	  	$model->obj["password"] = $_POST["password"];
			if ($_FILES['logo']['name'] != "") {
				$image_file_name = uploadFile($_FILES["logo"], $_POST["storeCode"]);
				$model->obj["logo"] = $image_file_name;
			}
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			if ($_FILES['logo']['name'] != "") {
				$store = store()->get("Id=$Id");
				unlink('../media/' . $store->logo);
				$image_file_name = uploadFile($_FILES["logo"], $store->storeCode);
				$model->obj["logo"] = $image_file_name;
			}
			$model->update("Id=$Id");
		}

header('Location: store.php');
}

function category_save()
{
		$storeId = $_SESSION["storeId"];
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

header('Location: category.php' );
}

function item_save()
{

		$storeId = $_SESSION["storeId"];
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


header('Location: menu-item.php?Id=' . $_POST["menuCategoryId"]);
}

function item_delete()
{
	$Id = $_GET["Id"];
	$item = menuItem()->get("Id=$Id");
	$catId = $item->menuCategoryId;
	unlink('../media/' . $item->image);
  $model = menuItem();
	$model->delete("Id=$Id");

	header('Location: menu-item.php?Id=' . $catId);
}


function view_store()
{
			$_SESSION["storeId"] = $_GET['Id'];
			header('Location: category.php');
}

function view_store_qr()
{
		$storeId = $_GET['Id'];
		$_SESSION["user_session"] = array();
		$_SESSION["user_session"]["role"] = $user->role;
		$_SESSION["user_session"]["Id"] = $storeId;
		header('Location: store-qr.php');
}


function delete_store()
{
	$Id = $_GET["Id"];
  $model = store();
	$model->delete("Id=$Id");

	header('Location: store.php');
}

function delete_menu()
{
	$categoryId = $_GET["categoryId"];
	$Id = $_GET["Id"];
  $model = menuItem();
	$model->delete("Id=$Id");

	header('Location: menu-item.php?Id=' . $categoryId);
}



function add_menu()
{

		$Id = $_GET["Id"];
		$model = menuItem();
		$image = uploadFile($_FILES["image"]);
  	$model->obj["menuCategoryId"] = $_POST["menuCategoryId"];
  	$model->obj["name"] = $_POST["name"];
  	$model->obj["description"] = $_POST["description"];
		$model->obj["image"] = $image;
		$model->obj["price"] = $_POST["price"];
		$model->create();


header('Location: menu-item.php?Id=' . $Id );
}

function category_delete()
{
	$Id = $_GET["Id"];
	$item = menuCategory()->get("Id=$Id");
	unlink('../media/' . $item->image);
  $model = menuCategory();
	$model->delete("Id=$Id");

	header('Location: category.php');
}

function edit_menu()
{
	$Id = $_GET["Id"];
	$model = menuItem();
	$categoryId = $_GET["categoryId"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["price"] = $_POST["price"];

	if ($_FILES["image"]["name"]!="") {
		$image = uploadFile($_FILES["image"]);
		$model->obj["image"] = $image;
	}

		$model->update("Id=$Id");

header('Location: menu-item.php?Id=' . $categoryId);
}

function user_save()
{

		$model = user();
  	$model->obj["firstName"] = $_POST["firstName"];
  	$model->obj["lastName"] = $_POST["lastName"];
  	$model->obj["username"] = $_POST["username"];
  	$model->obj["password"] = $_POST["password"];

		if ($_POST["form-type"] == "add") {
	  	$model->obj["role"] = $_POST["role"];
			$model->create();
		}

		if ($_POST["form-type"] == "edit") {
			$Id = $_POST["Id"];
			$model->update("Id=$Id");
		}
header('Location: user.php');
}

function log_out()
{
	session_destroy();
	header('Location: log-in.php');
}
