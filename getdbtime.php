<?php
	include_once "connection.php";
	include_once "common.php";
    include_once "prefix.php";

	session_start();

	if (!isset($_SESSION[$prefixhome."userid"])) {
		echo "Not logged in!";
		exit();
	}
?>
