<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

if (isset($_SESSION["cart"][$_GET['varId']])) {
	$_SESSION["cart"][$_GET['varId']] += $_GET['value'];
}
else{
	$_SESSION["cart"][$_GET['varId']] = $_GET['value'];
}

echo json_encode($_SESSION["cart"]);
?>
