<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

		case 'sign-up' :
			sign_up();
			break;

		case 'sign-in' :
			sign_in();
			break;


	default :
}


function sign_up(){

	$model = user();
	$model->obj["google_id"] = $_POST["username"];
	$model->obj["name"] = $_POST["name"];
	$model->obj["username"] = $_POST["username"];
	$model->obj["password"] = $_POST["password"];
	$model->create();

	header('Location: ' . $_SESSION['returnLink']);
}

function sign_in(){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$checkExist = user()->count("username='$username' and password='$password'");
	if ($checkExist) {
		$user = user()->count("username='$username' and password='$password'");
		$_SESSION['login_id'] = $username;
		if ($user->status=="Active") {
			header('Location: ' . $_SESSION['returnLink']);
		}
		else{
			header('Location: change-password.php');
		}
	}
	else{
		header('Location: login.php?error=User Not Exists');
	}

}

?>
