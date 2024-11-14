<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/Models.php';

header("Content-Type: application/json");

$storeCode = $_GET["storeCode"];
$store = store()->get("storeCode='$storeCode'");

$deviceId = $_GET['deviceId'];

$myVoucherList = array();
$custVoucherList = custVoucher()->list("deviceId='$deviceId' and status='Pending'");
foreach ($custVoucherList as $row) {
    $item = array();
    $voucher = voucher()->get("Id=$row->voucherId");
    $item["voucher"] = $voucher;
    $item["expiring"] = days_hours_left($voucher->validUntil);
    array_push($myVoucherList, $item);
}

$voucherList = array();
$allVoucherList = voucher()->list("status='Active' and storeId=$store->Id");
foreach ($allVoucherList as $row) {
    $voucherExist = custVoucher()->count("deviceId='$deviceId' and voucherId=$row->Id");
    if (!$voucherExist) {
        $item = array();
        $item["voucher"] = $row;
        $item["expiring"] = days_hours_left($row->validUntil);
        array_push($voucherList, $item);
    }
}

$json = array();
$json["total"] = count($voucherList);
$json["vouchers"] = $voucherList;
$json["myVouchers"] = $myVoucherList;

$jsonList = json_encode($json, JSON_FORCE_OBJECT);

echo $jsonList;
