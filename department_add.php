<?php
	include_once "connection.php";
	include_once "common.php";
    include_once "prefix.php";
    include_once "jsencoding.php";
    include_once "jsdb.php";

	session_start();

	// if (!isset($_SESSION[$prefixhome."userid"])) {
	// 	echo "Not logged in!";
	// 	exit();
	// }
    if (!isset($_POST["position"])) {
		echo "Invalid params: no data!";
		exit();
    }
    if (!isset($_POST["department"])) {
		echo "Invalid params: no data!";
		exit();
	}
    $connector = DatabaseClass::init($host, $username , $password, $dbname);
    if ($connector == null) {
        echo "Can not connect to database!";
        exit(0);
    }
    $position = $_POST["position"];
    $department = $_POST["department"];

	$st = "SELECT `ID`, `name` FROM `".$prefix."departments`";
    $result = $connector->query($st);
    echo $result;
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        if (strcasecmp($row[1], $department["name"]) == 0) {
            // echo "Invalid params: departments has used!";
            $departmentID=$row[0];
            break;
        }
    }
    if (!isset($departmentID)) {
        $datal = array(
            "name" =>  $department,
            "parentid" => "0",
            "ver" => "1",
        );
		$departmentID = $connector-> insert($prefix."departments", $datal);
    }
    $st = "SELECT `ID`, `name` FROM `".$prefix."position`";
    $result = $connector->query($st);
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        if (strcasecmp($row[1], $department["name"]) == 0) {
            // echo "Invalid params: departments has used!";
            $positionID=$row[0];
            break;
        }
    }
    echo $result;

    if (isset($positionID)) {
        exit();
    }

    if ($departmentID > 0) {
        $datal = array(
            "name" => $position,
            "departmentid" => $departmentID,
            "ver" => "1",
        );
        $lid = $connector-> insert($prefix."positions", $datal);
        echo "ok".$lid;
    }
    else {
        echo "error";
    }
?>
