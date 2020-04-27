<?php
    include_once "jsdb.php";
    include_once "jsencoding.php";
    include_once "prefix.php";
    include_once "connection.php";

    //$connection = DatabaseClass::init($host, $username, $password, $dbname);
    $connection = mysqli_connect($host, $username, $password, $dbname);
    if ($connection == null){
        echo "Can not connect to database!";
        exit();
    }
    //$connection->insert($prefix.'categories', array('parentid' => 0, 'name' => "Tin tức", 'type' => ""));
    
    if (!isset($_POST['userData'])){
        echo "Invalid userData";
        exit();
    }

    $userData = json_decode($_POST['userData']);
    //$userData = json_decode(`{"email":"nhocsookpro1997@gmail.com","familyName":"Thi","gender":null,"givenName":"Bùi Phamj Minh","hd":null,"id":"108158281743750819354","link":"https://plus.google.com/108158281743750819354","locale":"vi","name":"Bùi Phamj Minh Thi","picture":"https://lh6.googleusercontent.com/-hkVr8EnnJe4/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3re2H9ouwL0r2Lg1DBJdEihnv9CFTg/mo/photo.jpg","verifiedEmail":true}`);
    // echo var_dump($userData);
    if(!empty($userData)){
        // The user's profile info
        $oauth_provider = $_POST['oauth_provider'];
        $oauth_uid  = !empty($userData->id)?$userData->id:'';
        $first_name = !empty($userData->givenName)?$userData->givenName:'';
        $last_name  = !empty($userData->familyName)?$userData->familyName:'';
        $email      = !empty($userData->email)?$userData->email:'';
        $gender     = !empty($userData->gender)?$userData->gender:'';
        $locale     = !empty($userData->locale)?$userData->locale:'';
        $picture    = !empty($userData->picture)?$userData->picture:'';
        $link       = !empty($userData->link)?$userData->link:'';

        $query = "SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
        $result = mysqli_query($connection, $query);
        
        if($result->num_rows > 0){ 
            // Update user data if already exists
            $query = "UPDATE users SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', link = '".$link."', modified = NOW() WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
            //$update = mysql_query($query);
            $update = mysqli_query($connection, $query);
        }else{
            // Insert user data
            $query = "INSERT INTO users VALUES (NULL, '".$oauth_provider."', '".$oauth_uid."', '".$first_name."', '".$last_name."', '".$email."', '".$gender."', '".$locale."', '".$picture."', '".$link."', NOW(), NOW(), '')";
            //$insert = mysql_query($query);
            $update = mysqli_query($connection, $query);
        }  
    }
    echo "ok";
    exit(0);
?>