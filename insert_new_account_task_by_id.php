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

    $data = array(
        
    );
    if (isset($_POST["id"])) {
        $data["id"]=(int)$_POST["id"];
        }
    if (isset($_POST["data"])) {
    $data["data"]=$_POST["data"];
    }

    $connection->update($prefix.'users', $data);
    echo "ok";
    echo EncodingClass::fromVariable($data);
?>