<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$action = $_GET['action'];

switch ($action) {
	
	case 'order-list' :
		order_list();
		break;

		case 'mark-order-as-paid' :
			mark_order_as_paid();
			break;
			case 'change-order-status' :
				change_order_status();
				break;

	default :
}

  
function get_total_amount($orderNumber){
	$result = 0;

	foreach (orderItem()->list("orderNumber='$orderNumber'") as $row) {
	  $var = variation()->get("Id=$row->varId");
	  $result += $var->price*$row->quantity;
	}

	return $result;
  }

  function change_order_status(){
	$itemId = $_GET["itemId"];

	$model = orderMain();
	$model->obj["status"] = $_GET["status"];
	$model->obj["isNotificationRead"] = 0;
	$model->update("Id=$itemId");

}

function mark_order_as_paid(){
	$itemId = $_GET["itemId"];

	$model = orderMain();
	$model->obj["isPaid"] = $_GET["isPaid"];
	$model->update("Id=$itemId");

}


function order_list(){
	$status = $_GET['status'];
	$storeCode = $_GET['storeCode'];
	$date = $_GET['date'];

	$historyList = array();
    $orderMainList = orderMain()->list("status='$status' and storeCode='$storeCode' and date='$date'");
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
}