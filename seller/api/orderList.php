<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$status = $_GET['status'];
$storeCode = $_GET['storeCode'];
$store = store()->get("storeCode='$storeCode'");

	$historyList = array();
    $orderMainList = orderMain()->list("status='$status' and storeCode='$storeCode'");
	foreach ($orderMainList as $row) {
		$item = array();
		$item["main"] = $row;
		$item["total"] = total_order_amount($row->orderNumber, $store->Id);
		
		if ($row->voucherId) {
			$item["voucher"] = voucher()->get("Id=$row->voucherId");
		}
		if ($row->tableId) {
			$item["table"] = storeTable()->get("Id=$row->tableId");
		}
		$orderItemList = array();
		$orderItem = orderItem()->list("orderNumber=$row->orderNumber");
		foreach ($orderItem as $row) {
			$item2 = array();
			$item2["orderItem"] = $row;
			$item2["item"] = menuItem()->get("Id=$row->itemId");
			$item2["variation"] = variation()->get("Id=$row->varId");
			array_push($orderItemList, $item2);
		}
		$item["items"] = $orderItemList;
      	array_push($historyList, $item);
    }


	$jsonList = json_encode($historyList, JSON_FORCE_OBJECT);

	echo $jsonList;
?>
