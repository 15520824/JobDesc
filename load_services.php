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
$service = $connector2->load($prefix2."services", "(name = 'tit_home_quickjd') AND (prefix = '')", "id");
echo "ok";
echo EncodingClass::fromVariable($data);
?>