<?php
include "CRUD.php";
include "functions.php";

/*
Create new function whenever there is a new table
*/

function inquiry() {
	$crud = new CRUD;
	$crud->table = "inquiry";
	return $crud;
}

function store() {
	$crud = new CRUD;
	$crud->table = "store";
	return $crud;
}

function menuCategory() {
	$crud = new CRUD;
	$crud->table = "menu_category";
	return $crud;
}

function menuItem() {
	$crud = new CRUD;
	$crud->table = "menu_item";
	return $crud;
}

function orderMain() {
	$crud = new CRUD;
	$crud->table = "order_main";
	return $crud;
}

function orderItem() {
	$crud = new CRUD;
	$crud->table = "order_item";
	return $crud;
}

function user() {
	$crud = new CRUD;
	$crud->table = "user";
	return $crud;
}

function account() {
	$crud = new CRUD;
	$crud->table = "user";
	return $crud;
}


function storePeople() {
	$crud = new CRUD;
	$crud->table = "store_people";
	return $crud;
}


function voucher() {
	$crud = new CRUD;
	$crud->table = "voucher";
	return $crud;
}


function userVoucher() {
	$crud = new CRUD;
	$crud->table = "cust_voucher";
	return $crud;
}


function customer() {
	$crud = new CRUD;
	$crud->table = "customer";
	return $crud;
}

?>
