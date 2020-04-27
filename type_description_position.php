<?php 
include_once "jsdb.php";
include_once "jsencoding.php";
include_once "prefix.php";
include_once "connection.php";

function arrayToDictionary($arr, $key) {
    $count = count($arr);
    $dict = array();
    for ($i = 0; $i < $count; $i++){
        $o = $arr[$i];
        $dict[$o[$key]] = $o;
    }
    return $dict;
}

$connection = DatabaseClass::init($host, $username, $password, $dbname);
if ($connection == null){
    echo "Can not connect to database!";
    exit();
}
$data = $connection->load("tasks_content","","content");
$dataPos = $connection->load("positions","","id");
$dataTask = $connection->load("tasks","","id");
$dataPosCheck = arrayToDictionary($dataPos, "id");
$dataTaskCheck = arrayToDictionary($dataTask, "id");
    if(!isset($data)||count($data)==0)
    {
        $result=array();
        echo "ok";
        echo EncodingClass::fromVariable($result);
        exit(0);
    }
    $count = count($data);
    for ($i = 0; $i < $count; $i++){
        $result[$i]['id'] = $data[$i]['id'];
        $result[$i]['taskid'] = $data[$i]['taskid'];
        $result[$i]['task'] = $dataTaskCheck[$result[$i]['taskid']]['name'];
        $result[$i]['positionid'] = $data[$i]['positionid'];
        $result[$i]['position'] = $dataPosCheck[$result[$i]['positionid']]['name'];
        $result[$i]['content'] = $data[$i]['content'];
        $result[$i]['ver'] = $data[$i]['ver'];
    }
    echo "ok";
    echo EncodingClass::fromVariable($result);
    exit(0);
?>
