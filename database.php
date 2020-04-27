<?php
    include_once "jsdb.php";
    include_once "jsencoding.php";
    include_once "prefix.php";
    include_once "connection.php";

    session_start();
    $connection = DatabaseClass::init($host, $username, $password, $dbname);
    if ($connection == null){
        echo "Can not connect to database!";
        exit();
    }

    function loadCategories(){
        global $connection, $prefix;
        $content = $connection->load($prefix.'categories', "", "id");
        return $content;
    }


    if (!isset($_POST['task'])){
        echo "Invalid task";
        exit();
    }
    $task = $_POST['task'];

    switch ($task) {
        case 'categories_initializing':
            $content = loadCategories();
            break;
        default:
            // code...
            break;
    }
    echo "ok".EncodingClass::fromVariable($content);
?>
