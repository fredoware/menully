<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$Id = $_GET["Id"];


$model = menuItem();
$model->obj["isDeleted"] = 1;
$model->update("Id=$Id");
?>
