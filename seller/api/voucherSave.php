<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $storeCode = $_POST["storeCode"];
    $store = store()->get("storeCode='$storeCode'");

    $model = voucher();
    $model->obj["storeId"] = $store->Id;
    $model->obj["type"] = $_POST["type"];
    $model->obj["discount"] = $_POST["type"];
    $model->obj["name"] = $_POST["name"];
    $model->obj["minimumSpend"] = $_POST["minimumSpend"];
    $model->obj["maxQuantity"] = $_POST["quantity"];
    $model->obj["currentQuantity"] = $_POST["quantity"];
    $model->obj["validUntil"] = $_POST["validUntil"];
    $model->obj["status"] = $_POST["status"];

    if ($_POST["Id"]) {
        $Id = $_POST["Id"];
        $model->update("Id=$Id");
    }else{
        $model->create();
    }
    
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method",
    ]);
}

// Return JSON response
// echo json_encode($response);
