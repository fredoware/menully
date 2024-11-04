<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$itemId = $_GET["itemId"];

$model = orderMain();
$model->obj["status"] = $_GET["status"];
$model->obj["isNotificationRead"] = 0;
$model->update("Id=$itemId");
?>
