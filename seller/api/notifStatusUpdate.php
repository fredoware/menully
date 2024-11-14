<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$status = $_GET["status"];
$type = $_GET["type"];

$model = notification();
$model->obj["status"] = $status;
$model->update("type='$type'");