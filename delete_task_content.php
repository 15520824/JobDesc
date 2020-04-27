<?php
    include_once "jsdb.php";
    include_once "jsencoding.php";
    include_once "prefix.php";
    include_once "connection.php";

    //$connection = DatabaseClass::init($host, $username, $password, $dbname);
    $connection = mysqli_connect($host, $username, $password, $dbname);
    if ($connection == null){
        echo "Can not connect to database!";
        exit();
    }
    //$connection->insert($prefix.'categories', array('parentid' => 0, 'name' => "Tin tức", 'type' => ""));
    
    if (!isset($_POST['id'])){
        echo "Invalid idTaskContent";
        exit();
    }
    $id=$_POST['id'];

    $connection->query("DELETE FROM ".$prefix."tasks_content WHERE ID=".$id);

    $connection->query("DELETE FROM ".$prefix."link_position_taskcontent WHERE taskcontentid=".$id);

    echo "ok";
?>