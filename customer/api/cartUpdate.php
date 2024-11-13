<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

if ($_GET['value']==0) {
	unset($_SESSION["cart"][$_GET['varId']]);
}
else{
	$_SESSION["cart"][$_GET['varId']] = $_GET['value'];
}


echo json_encode($_SESSION["cart"]);
?>
