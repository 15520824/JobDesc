<?php 
include_once "jsdb.php";
include_once "jsencoding.php";
include_once "prefix.php";
include_once "connection.php";

$connection = DatabaseClass::init($host, $username, $password, $hrdb);
if ($connection == null){
    echo "Can not connect to database!";
    exit();
}
// $service = $connection->load($prefix2."services", "(name = 'tit_home_quickjd') AND (prefix = '')", "id");
$service = $connection->load($prefix2."services");
echo "ok";
echo EncodingClass::fromVariable($service);
?>