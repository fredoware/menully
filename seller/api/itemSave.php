<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $storeCode = $_POST["storeCode"];
    $store = store()->get("storeCode='$storeCode'");

    $model = menuItem();
    $model->obj["menuCategoryId"] = $_POST["catId"];
    $model->obj["storeId"] = $store->Id;
    $model->obj["name"] = $_POST["name"];
    $model->obj["quantity"] = $_POST["quantity"];
    $model->obj["description"] = $_POST["description"];
    $model->obj["isAvailable"] = $_POST["isAvailable"];
    $model->obj["isBestSeller"] = $_POST["isBestSeller"];
    $model->obj["isForSale"] = $_POST["isForSale"];

    if (isset($_FILES['image']["name"])) {
        $image_file_name = uploadImage($_FILES["image"], $store->storeCode);
        $model->obj["image"] = $image_file_name;
    }

    if ($_POST["Id"]) {
        $Id = $_POST["Id"];
        $model->obj["status"] = "Available";
        $model->update("Id=$Id");
    } else {
        $model->create();
        $getLast = menuItem()->get("Id>0 and storeId=$store->Id order by Id desc limit 1");
        $Id = $getLast->Id;
    }

    $varations = json_decode($_POST["varations"], true);
    
    
	variation()->delete("itemId=$Id");
    foreach ($varations as $row) {
        $model = variation();
        $model->obj["itemId"] = $Id;
        $model->obj["unit"] = $row["unit"];
        $model->obj["price"] = $row["price"];
        $model->create();
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method",
    ]);
}


// header('Content-Type: application/json');

// // Check if both 'category' and 'variations' are present in the POST request
// if (isset($_POST['name']) && isset($_POST['varations'])) {
//     $category = $_POST['name'];
//     $variations = json_decode($_POST['varations'], true); // Decode JSON into a PHP array

//     if (json_last_error() === JSON_ERROR_NONE) {
//         // Prepare response array
//         $response = [
//             'status' => 'success',
//             'category' => $category,
//             'varations' => $varations
//         ];
//         echo json_encode($response);
//     } else {
//         // Handle JSON decoding error
//         echo json_encode(['error' => 'Invalid JSON data in variations']);
//     }
// } else {
//     // Handle missing data error
//     echo json_encode(['error' => 'Missing category or variations']);
// }

// echo json_encode($_POST); 

// header('Content-Type: application/json');

// $data = json_decode(file_get_contents("php://input"), true);

// if (isset($data['category']) && isset($data['varations'])) {
//     $category = $data['category'];
//     $variations = $data['varations'];

//     $response = [
//         'status' => 'success',
//         'received' => [
//             'category' => $category,
//             'variations' => $variations
//         ]
//     ];
//     echo json_encode($response);
// } else {
//     echo json_encode(['error' => 'Missing category or variations']);
// }

// header('Content-Type: application/json');

//     $category = $_POST['name'];
//     $variations = json_decode($_POST['varations'], true); // Decode the JSON string into PHP array

//     // Check if JSON decoding was successful
//     if (json_last_error() === JSON_ERROR_NONE) {
//         // Respond with received data for confirmation

//     foreach ($variations as $row) {
//         $model = variation();
//         // $model->obj["itemId"] = $Id;
//         $model->obj["unit"] = $row["unit"];
//         $model->obj["price"] = $row["price"];
//         $model->create();
//     }
//         $response = [
//             'status' => 'success',
//             'received' => [
//                 'category' => $category,
//                 'variations' => $variations
//             ]
//         ];
//         echo json_encode($response);
//     } else {
//         echo json_encode(['error' => 'Invalid JSON in variations']);
//     }
