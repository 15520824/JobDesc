<?php
	include_once "connection.php";
	include_once "connection2.php";
	include_once "common.php";
    include_once "prefix.php";
	include_once "prefix2.php";
    include_once "jsencoding.php";
    include_once "jsdb.php";

	session_start();
    if (!isset($_POST["id"])) {
		echo "Invalid params: id!";
		exit();
	}
	else $id = $_POST["id"];

	$connector = DatabaseClass::init($host, $username , $password, $dbname);
	
    if ($connector == null){
        echo "Can not connect to database!";
        exit();
    }
    $result = $connector->load($prefix."position", "id = ".$id, "id");
    if (count($result) > 0){
        echo "failed_datafilter";
        exit(0);
	}

	$connector->query("DELETE FROM ".$prefix."position WHERE ID=".$id);
    echo "ok";
    exit();
?>
