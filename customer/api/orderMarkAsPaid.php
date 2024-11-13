<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$itemId = $_GET["itemId"];

	$model = orderMain();
	$model->obj["isPaid"] = $_GET["isPaid"];
	$model->update("Id=$itemId");
?>
