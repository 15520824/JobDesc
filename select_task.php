<?php
    include_once "connection.php";
    include_once "common.php";
    include_once "jsdb.php";
    include_once "prefix.php";

    //session_start();

    if (!isset($_POST['id'])){
        echo "Invalid param 1";
        exit();
    }

    $connection = DatabaseClass::init($host, $username, $password, $dbname);
    if ($connection == null){
        echo "Can not connect to database!";
        exit();
    }
    $id = $_POST["id"];
    $data = $connection->load("tasks","id=".$id,"name");
    echo 'ok';
    echo EncodingClass::fromVariable($data);
?>
