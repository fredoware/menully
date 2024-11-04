<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

// $requestBody = json_decode(file_get_contents("php://input"), true);

// $response = [
//     "status" => "success",
//     "message" => "Received data successfully",
//     "data" => $requestBody
// ];

// $storeCode = $requestBody["storeCode"];
// $store = store()->get("storeCode='$storeCode'");

// $model = menuCategory();
// $model->obj["storeId"] = $store->Id;
// $model->obj["name"] = $requestBody["name"];
// $model->obj["description"] = $requestBody["description"];
// $model->create();

// echo json_encode($response);

header("Content-Type: application/json");

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $storeCode = $_POST["storeCode"];
    $store = store()->get("storeCode='$storeCode'");

    $model = menuCategory();
    $model->obj["storeId"] = $store->Id;
    $model->obj["name"] = $_POST["name"];
    $model->obj["description"] = $_POST["description"];

    if (isset($_FILES['image']["name"])) {
        $image_file_name = uploadImage($_FILES["image"], $store->storeCode);
        $model->obj["image"] = $image_file_name;
    }

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
