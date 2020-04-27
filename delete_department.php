<?php
    include_once "jsdb.php";
    include_once "jsencoding.php";
    include_once "prefix.php";
    include_once "connection.php";

    //$connection = DatabaseClass::init($host, $username, $password, $dbname);
    $connection = DatabaseClass::init($host, $username, $password, $dbname);

    if ($connection == null){
        echo "Can not connect to database!";
        exit();
    }
    //$connection->insert($prefix.'categories', array('parentid' => 0, 'name' => "Tin tức", 'type' => ""));
    
    if (!isset($_POST['id'])){
        echo "Invalid idDepartment";
        exit();
    }
    $id=(int)$_POST['id'];
    $data["id"]=$id;

    $connection->query("DELETE FROM ".$prefixCompany."positions WHERE departmentid=".$id);
    
    $connection->query("DELETE FROM ".$prefixCompany."departments WHERE ID=".$id);

    echo "ok";
    echo EncodingClass::fromVariable($data);
?>