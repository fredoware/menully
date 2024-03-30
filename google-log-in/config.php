<?php
session_start();
session_regenerate_id(true);
// change the information according to your database

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
  $db_connection = mysqli_connect("localhost","root","","fredoware.db");
} else {
  $db_connection = mysqli_connect("localhost","u437487943_fredowaresql","feZxmasqw1212!@!@","u437487943_fredowaredb");
}

// CHECK DATABASE CONNECTION
if(mysqli_connect_errno()){
    echo "Connection Failed".mysqli_connect_error();
    exit;
}
