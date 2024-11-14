<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$model = custVoucher();
$model->obj["voucherId"] = $_GET["voucherId"];
$model->obj["deviceId"] = $_GET["deviceId"];
$model->obj["dateClaimed"] = "NOW()";
$model->create();
