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
if (isset($_POST["id"])) {
    $data["id"]=$_POST["id"];
    }
if (isset($_POST["name"])) {
$data["name"]=$_POST["name"];
}
$data["ver"]=1;

$data["id"] = $connection->insert($prefix.'positions_libary', $data);

echo "ok";

echo EncodingClass::fromVariable($data);

?>