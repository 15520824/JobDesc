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
        echo "Invalid idTask";
        exit();
    }
    $id=$_POST['id'];
    $data["id"]=$id;
    $connection->query("DELETE FROM ".$prefix."tasks WHERE ID=".$id);

    $arrayTaskcontent = $connection->load($prefix."tasks_content","taskid=".$id);

    $count = count($arrayTaskcontent);

    for($i=0;$i<$count;$i++)
    {
        $arraylink = $connection->query("DELETE FROM ".$prefix."link_position_taskcontent WHERE taskcontentid=".$arrayTaskcontent[$i]["id"]);
    }

    $connection->query("DELETE FROM ".$prefix."tasks_content WHERE taskid=".$id);

    echo "ok";
    echo EncodingClass::fromVariable($data);
?>