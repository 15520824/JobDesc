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
    if (!isset($_POST["userid"])) {
        echo "No userid!";
        exit();
    }
    $data = array(
        
    );
    if (isset($_POST["userid"])) {
        $data["userid"]=(int)$_POST["userid"];
        }
    if (isset($_POST["data"])) {
    $data["data"]=$_POST["data"];
    }
    if (isset($_POST["positionid"])) {
        $data["positionid"]=$_POST["positionid"];
    }

    $data["id"] = $connection->insert($prefixCompany.'datauser', $data);
    echo "ok";
    echo EncodingClass::fromVariable($data);
?>