<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';


header("Content-Type: application/json");

$deviceId = $_GET['deviceId'];
$storeCode = $_GET['storeCode'];

	$historyList = array();
    $orderMainList = orderMain()->list("deviceId='$deviceId' and storeCode='$storeCode' order by FIELD(status, 'Pending', 'Confirmed', 'Ready', 'Delivered', 'Canceled')");
	foreach ($orderMainList as $row) {
		$item = array();
		$item["main"] = $row;
		$item["total"] = total_order_amount($row->orderNumber);
		
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
