<?php
require_once '../../config/database.php';
require_once '../../config/Models.php';

$json = array();

$storeCode = $_GET["storeCode"];

$json["result"] = store()->count("storeCode='$storeCode'");

echo json_encode($json);
?>
