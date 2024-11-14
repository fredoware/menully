<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");


    $cartList = json_decode($_POST["cart"], true);
    $itemListArray = array();
    foreach ($cartList as $row) {

        $Id = $row["id"];

        $var = variation()->get("Id=$Id");
        $item = menuItem()->get("Id=$var->itemId");
        $items = array();
        $items["product"] = $item;
        $items["variation"] = $var;
        $items["quantity"] = $row["quantity"];
        $items["total"] = $row["quantity"]*$var->price;;

        array_push($itemListArray, $items);
    }



	$json = array();
    $json["list"] = $itemListArray;

    $jsonList = json_encode($json, JSON_FORCE_OBJECT);

    echo $jsonList;

?>