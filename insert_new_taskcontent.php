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

// if (!isset($_POST["id"])) {
//     echo "error: invalid id.";
//     exit();
// }

// if (!isset($_POST["taskid"])) {
//     echo "error: invalid taskid.";
//     exit();
// }

// if (!isset($_POST["positionid"])) {
//     echo "error: invalid positionid.";
//     exit();
// }

// if (!isset($_POST["content"])) {
//     echo "error: invalid content.";
//     exit();
// }

// if (!isset($_POST["ver"])) {
//     echo "error: invalid ver.";
//     exit();
// } 

$data = array(
    // "id" => $_POST["id"],
    // "taskid" => $_POST["taskid"],
    // "positionid" => $_POST["positionid"],
    // "content" => $_POST["content"],
    // "ver" => $_POST["ver"]
);

if (isset($_POST["taskid"])) {
    $data["taskid"]=$_POST["taskid"];
}else
{
    echo "error: invalid taskid";
    exit();
}
if (isset($_POST["content"])) {
    $data["content"]=$_POST["content"];
}

$data["ver"]=1;

$data["id"] = $connection->insert($prefix.'tasks_content', $data);

// $datalink = $connection->load($prefix.'link_position_taskcontent', $data);
$data["position"]=array();

if (isset($_POST["position"])) {
    $position=json_decode($_POST["position"]);   
    $count = count($position);
    for($i=0;$i<$count;$i++){
        $datalink[$i]["positionid"]=$position[$i];
        $datalink[$i]["taskcontentid"]=$data["id"];
        $idCheck=$connection->insert($prefix.'link_position_taskcontent', $datalink[$i]);
        $datalink[$i]["id"]= $idCheck;
    }
    if($count>0)
    $data["position"]=$datalink;
}

$count = count($position);
echo "ok";

echo EncodingClass::fromVariable($data);

?>