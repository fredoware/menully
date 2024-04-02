<?php
require_once '../config/database.php';
require_once '../config/Models.php';

$json = array();

$username = $_GET["username"];

$json["result"] = user()->count("username='$username'");

echo json_encode($json);
?>
