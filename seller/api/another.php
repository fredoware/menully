<?php
header("Content-Type: application/json");

$requestBody = json_decode(file_get_contents("php://input"), true);

$response = [
    "status" => "success",
    "message" => "Received data successfully",
    "data" => $requestBody
];

echo json_encode($response);
?>
