<?php
    include_once "connection.php";
	include_once "common.php";
    include_once "prefix.php";
    include_once "jsencoding.php";
    include_once "jsdb.php";

    session_start();

    if (!isset($_SESSION[$prefixhome."userid"])) {
        echo "Bạn đã đăng xuất, bạn cần đăng nhập lại để tiếp tục sử dụng phần mềm
Để đăng nhập lại bạn nhấn F5 hoặc tải lại trang web";
        exit();
    }
    if (!isset($_POST["userid"])) {
        echo "error: invalid data!";
        exit();
    }

    if (!isset($_POST["pfid"])) {
        echo "error: invalid data!";
        exit();
    }
    $connector = DatabaseClass::init($host, $username , $password, $dbname);
    $userid = $_POST["userid"];
    $pfid = $_POST["pfid"];
    $id = $connector->update($prefix.'users', array('id' => $userid, 'lastprofileid' => $pfid));
    if ($id <= 0) {
        echo "failed";
        exit();
    }
    echo "ok";
    exit();
 ?>
