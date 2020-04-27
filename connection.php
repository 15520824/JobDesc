<?php

include_once "prefix.php";
// include_once "jsdb.php";

$dbname = "job_desc";
$username = "root";
$password = "your_root_password";
$host = "localhost";

$client_id = '581565119917-8pot7uvm83sfos22dcvfm090jcf5mm4f.apps.googleusercontent.com'; 
$client_secret = 'gV79TL3rdZL5eMKkwjgYoNT7';
$redirect_uri = 'http://lab.daithangminh.vn/home_co/jd/close.php';

if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
    include_once  "connection_7.php";
} else {
    include_once  "connection_4.php";
}
?>
