<?php 
include_once "jsdb.php";
include_once "jsencoding.php";
include_once "prefix.php";
include_once "connection.php";

$connection = DatabaseClass::init($host, $username, $password, $dbname);
if ($connection == null){
    echo "Can not connect to database!";
    exit();
}
$data = $connection->load("departments","","parentid");

echo "ok";
echo EncodingClass::fromVariable($data);
?>