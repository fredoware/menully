<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {
	
	case 'test-json' :
		test_json();
		break;

	case 'account-list' :
		account_list();
		break;

	case 'all-list' :
		all_list();
		break;

	case 'filtered-list' :
		filtered_list();
		break;

		default :
}

function test_json(){
	$account = account()->get("Id>0 limit 1");
	$array = (array) $account;
	$json = json_encode($account);
	
	$accountList = account()->list("Id>0");

// $jsonList - json_encode($accountList);
 $jsonList = json_encode($accountList, JSON_FORCE_OBJECT);


	// print_r($account);
	// print_r($array["username"]);
	// print_r($json);
	print_r($jsonList);
}

function account_list(){

	$keyword = $_GET["keyword"];

	$accountList = account()->list("username like '%$keyword%'");

 	$jsonList = json_encode($accountList, JSON_FORCE_OBJECT);

	echo $jsonList;
}

function all_list(){

	$accountList = account()->list();

 	$jsonList = json_encode($accountList, JSON_FORCE_OBJECT);

	echo $jsonList;
}

function filtered_list(){
	$begin = $_GET["begin"];
	$limit = $_GET["limit"];
	$keyword = $_GET["keyword"];

	$sqlKey = "";
	if ($keyword) {
		$sqlKey = "and firstName like '%$keyword%'";
	}
	$json = array();
	$json["total"] = account()->count("Id>0 $sqlKey");
	$json["list"] = account()->list("Id>0 $sqlKey Limit $begin,$limit");

 	$jsonList = json_encode($json, JSON_FORCE_OBJECT);

	echo $jsonList;
}
