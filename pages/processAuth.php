<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

	case 'user-login' :
		user_login();
		break;
	
	case 'user-logout' :
		user_logout();
		break;

	case 'change-password' :
		change_password();
		break;

	case 'user-register' :
		user_register();
		break;

	case 'register-step-2' :
		register_step_2();
		break;

	default :
}

function user_login(){

		$username = $_POST["username"];
		$password = $_POST["password"];
		$storeCode = $_POST["storeCode"];

		$countUser = account()->count("username='$username' and password='$password'");
		if ($countUser==0):
			header('Location: login.php?error=User does not exist');
		else:
			$user = account()->get("username='$username'");
			$_SESSION["user_session"] = array();
			$_SESSION["user_session"]["Id"] = $user->Id;
			$_SESSION["user_session"]["username"] = $user->username;
			$_SESSION["user_session"]["firstName"] = $user->firstName;
			$_SESSION["user_session"]["lastName"] = $user->lastName;
			$_SESSION["user_session"]["role"] = $user->role;

			if ($user->status=="Inactive") {
				header('Location: ../' . $storeCode . '/change-password');
			}
			else{
				header('Location: ../' . $storeCode . '/');
			}
		endif;
}

function manage_account(){
	$customer = $_GET["customer"];
	$admin = $_GET["admin"];

	$user = account()->get("username='$customer'");
	$_SESSION["user_session"] = array();
	$_SESSION["user_session"]["Id"] = $user->Id;
	$_SESSION["user_session"]["username"] = $user->username;
	$_SESSION["user_session"]["firstName"] = $user->firstName;
	$_SESSION["user_session"]["lastName"] = $user->lastName;
	$_SESSION["user_session"]["role"] = $user->role;
	$_SESSION["admin-access"] = $admin;

	$_SESSION["cart"] = array();
	$_SESSION["csaCart"] = array();

	header('Location: index.php');

}

function user_register()
{
	//Date in mm/dd/yyyy format; or it can be in other formats as well
	$model = account();
	$model->obj["username"] = $_POST["email"];
	$model->obj["password"] = $_POST["password"];
	$model->obj["firstName"] = $_POST["firstName"];
	$model->obj["lastName"] = $_POST["lastName"];
	$model->obj["phone"] = $_POST["phone"];
	$model->obj["email"] = $_POST["email"];
	$model->obj["role"] = "Customer";
	$model->obj["status"] = "Active";
	$model->obj["address"] = $_POST["address"];
	$model->obj["city"] = $_POST["city"];
	$model->obj["zipCode"] = $_POST["zipCode"];
	$model->obj["dateAdded"] = "NOW()";
	$model->create();
		

	//Send Email
	$er = nullable_get("emailregistration");

	$email = $_POST["email"];
	$subject = $er->title;
	$html = "Hi ".$_POST["firstName"].",<br><br> {$er->content} <br><br>Best Regards, <br>Dirty Dog Organic Farm";


	smtp_mailer($email, $subject, $html);

	
	header('Location: login.php?success=You have successfully registered');
}

function change_password(){
	$password1 = $_POST["password1"];
	$password2 = $_POST["password2"];
	$storeCode = $_POST["storeCode"];

	if ($password1!=$password2) {
		header('Location: change-password.php?error=Password Not Matched');
	}
	else{
		$username = $_SESSION["user_session"]["username"];

		$model = account();
		$model->obj["password"] = $_POST["password1"];
		$model->obj["status"] = "Active";
		$model->update("username='$username'");

		header('Location: ../' . $storeCode . '/');
	}
}

function user_logout(){
	// session_destroy();
	unset($_SESSION['user_session']);
	header('Location: ./');
}
