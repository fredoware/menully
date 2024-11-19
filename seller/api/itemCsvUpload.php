<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $storeCode = $_POST["storeCode"];
    $store = store()->get("storeCode='$storeCode'");

    $csvPath = uploadCsv($_FILES["csvFile"], $store->storeCode);

    $lines = file('../../media/' . $csvPath, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $key => $value) {
        // ignore first line
        if ($key > 0) {
            $csv[$key] = str_getcsv($value);
        }
    }

    foreach ($csv as $row) {

        // echo $key[0];
        $name = $row[0];
        $category = $row[1];
        $description = $row[2];
        $quantity = $row[3];
        $isAvailable = $row[4];
        $isBestSeller = $row[5];
        $option1Name = $row[6];
        $option1Value = $row[7];
        $option2Name = $row[8];
        $option2Value = $row[9];
        $option3Name = $row[10];
        $option3Value = $row[11];

        $checkCategory = menuCategory()->count("name='$category' and storeId=$store->Id");
        if ($checkCategory) {
            $cat = menuCategory()->get("name='$category' and storeId=$store->Id");
            $catId = $cat->Id;
        }
        else{
            $model = menuCategory();
            $model->obj["storeId"] = $store->Id;
            $model->obj["name"] = $category;
            $model->create();

            $getLast = menuCategory()->get("Id>0 and storeId=$store->Id order by Id desc limit 1");
            $catId = $getLast->Id;
        }

        $model = menuItem();
        $model->obj["storeId"] = $store->Id;
        $model->obj["menuCategoryId"] = $catId;
        $model->obj["name"] = $name;
        $model->obj["description"] = $description;
        $model->obj["quantity"] = $quantity;
        $model->obj["isAvailable"] = $isAvailable;
        $model->obj["isBestSeller"] = $isBestSeller;
        $model->obj["status"] = "Draft";
        $model->create();

        
        $getLast = menuItem()->get("Id>0 and storeId=$store->Id order by Id desc limit 1");
        $Id = $getLast->Id;

        if ($option1Name) {
            $model = variation();
            $model->obj["itemId"] = $Id;
            $model->obj["unit"] = $option1Name;
            $model->obj["price"] = $option1Value;
            $model->create();
        }
        if ($option2Name) {
            $model = variation();
            $model->obj["itemId"] = $Id;
            $model->obj["unit"] = $option2Name;
            $model->obj["price"] = $option2Value;
            $model->create();
        }
        if ($option3Name) {
            $model = variation();
            $model->obj["itemId"] = $Id;
            $model->obj["unit"] = $option3Name;
            $model->obj["price"] = $option3Value;
            $model->create();
        }

    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method",
    ]);
}
