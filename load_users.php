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

$datausers = $connection->load($prefixCompany."users", "", "id");

echo "ok";
echo EncodingClass::fromVariable($datausers);
?>