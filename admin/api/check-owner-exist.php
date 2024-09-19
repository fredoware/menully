<?php
require_once '../../config/database.php';
require_once '../../config/Models.php';

$json = array();

$email = $_GET["email"];
$json["result"] = "";

$checkExist = account()->count("username='$email'");
if ($checkExist) {
    $owner = account()->get("username='$email'");
    
$json["result"] = $owner;
}

echo json_encode($json);
?>