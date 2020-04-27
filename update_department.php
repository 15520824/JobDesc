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

if (!isset($_POST["id"])) {
    echo "error: invalid id.";
    exit();
}

$data = array(
);
if (isset($_POST["id"])) {
    $data["id"]=(int)$_POST["id"];
    }
if (isset($_POST["name"])) {
$data["name"]=$_POST["name"];
}
if (isset($_POST["parentid"])) {
    $data["parentid"]=(int)$_POST["parentid"];
}
if (isset($_POST["code"])) {
    $data["code"]=$_POST["code"];
}
$data["ver"]=1;
$result = $connection->load($prefixCompany."departments", "(id=".$data["id"].")", "");
if(sizeof($result) > 0)
{
    $connection->update($prefixCompany.'departments', $data);
}else{
    $connection->insert($prefixCompany.'departments', $data);
}
echo "ok";
echo EncodingClass::fromVariable($data);
?>