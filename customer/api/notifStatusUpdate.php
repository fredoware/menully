<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$Id = $_GET["Id"];

$model = notification();
$model->obj["status"] = "Read";
$model->update("Id=$Id");