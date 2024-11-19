<?php 
session_start();
$storeCode = $_SESSION["storeCode"];
?>


<a href="javascript:void(0)" class="closebtn" ng-click="closeNav()">&times;</a>

<style>
 .list-group-item-action{
    font-size:18px !important;
 }
</style>
<div class="list-group">
    <a href="./" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">
        Home
    </a>
    <!-- First Menu Item -->
    <a href="#submenu1" class="list-group-item list-group-item-action ps-3" data-bs-toggle="collapse" aria-expanded="false">
        Orders
        <i class="fa fa-angle-right float-end toggle-icon me-2 mt-1"></i>
    </a>
    <div class="collapse" id="submenu1">
        <a href="./orders?status=Pending" class="list-group-item list-group-item-action" ng-click="closeNav()">Pending</a>
        <a href="./orders?status=Confirmed" class="list-group-item list-group-item-action" ng-click="closeNav()">Confirmed</a>
        <a href="./orders?status=Ready" class="list-group-item list-group-item-action" ng-click="closeNav()">Ready</a>
        <a href="./orders?status=Delivered" class="list-group-item list-group-item-action" ng-click="closeNav()">Delivered</a>
        <a href="./orders?status=Canceled" class="list-group-item list-group-item-action" ng-click="closeNav()">Canceled</a>
    </div>
    <a href="#submenu2" class="list-group-item list-group-item-action ps-3" data-bs-toggle="collapse" aria-expanded="false">
        Store Settings
        <i class="fa fa-angle-right float-end toggle-icon me-2 mt-1"></i>
    </a>
    <div class="collapse" id="submenu2">
    <a href="./menu-setup" class="list-group-item list-group-item-action" ng-click="closeNav()">Menu Set Up</a>
    <a href="./mass-upload" class="list-group-item list-group-item-action" ng-click="closeNav()">Mass Upload</a>
        <a href="./voucher-setup" class="list-group-item list-group-item-action" ng-click="closeNav()">Voucher Set Up</a>
        <a href="./menu-item?isBestSeller=1" class="list-group-item list-group-item-action" ng-click="closeNav()">Best
            Sellers!</a>
        <a href="./menu-item?isAvailable=0" class="list-group-item list-group-item-action" ng-click="closeNav()">Unavailable
            Items</a>
    </div>

    
    <a href="#submenu3" class="list-group-item list-group-item-action ps-3" data-bs-toggle="collapse" aria-expanded="false">
        Reports
        <i class="fa fa-angle-right float-end toggle-icon me-2 mt-1"></i>
    </a>
    <div class="collapse" id="submenu3">
        <a href="./reports" class="list-group-item list-group-item-action" ng-click="closeNav()">Sales Report</a>
        <a href="./reports" class="list-group-item list-group-item-action" ng-click="closeNav()">Customers Report</a>
    </div>


    <a href="./feedback" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">Customer's
        Feedback</a>
    <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">People</a>
    <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">Store QR Code</a>
    <a href="../<?=$storeCode;?>/" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">Customer's
        View</a>
    <a href="#" class="list-group-item list-group-item-action ps-3" ng-click="closeNav()">Log out</a>

</div>