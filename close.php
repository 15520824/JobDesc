<html xmlns="http://www.w3.org/1999/xhtml">

<body>
    <?php
 
 require_once './login_google/vendor/autoload.php';
 include_once "connection.php";
    // Lấy những giá trị này từ https://console.google.com
    
    ##################################################################
    
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("email");
    $client->addScope("profile");
    
    $service = new Google_Service_Oauth2($client);
    
    // Nếu kết nối thành công, sau đó xử lý thông tin và lưu vào database
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        //header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        $user = $service->userinfo->get(); //get user info 
    
        // connect to database
        // $mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
        // if ($mysqli->connect_error) {
        //     die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
        // }
        // // echo var_dump($user);
        // //Kiểm tra xem nếu user này đã tồn tại, sau đó nên login tự động
        // $result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
        // $user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
    
        // //show user picture
        // echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
    
        // if($user_count) // Nếu user tồn tại thì show thông tin hiện có
        // {
        //     // echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
        // }
        // else //Ngược lại tạo mới 1 user vào database
        // { 
        //     // echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
        //     $statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
        //     $statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
        //     $statement->execute();
        //     // echo $mysqli->error;
        // }
    }
    
    //Nếu sẵn sàng kết nối, sau đó lưu session với tên access_token
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
         $client->setAccessToken($_SESSION['access_token']);

        }
    // } else { // Ngược lại tạo 1 link để login
    //     $authUrl = $client->createAuthUrl();
    // }
    //$authUrl = $client->createAuthUrl();
    ?>
    <script>
    <?php
            include_once "./absol/absol_full.php";
        ?>

        (function() {

            var user = <?php echo json_encode($user) ?>;
            var acessToken = <?php echo $_SESSION['access_token'] ?>;

            if (absol.cookie.get('userJD') == undefined) {
                absol.cookie.set('accesstokenJD', JSON.stringify(acessToken));
                absol.cookie.set('userJD', JSON.stringify(user));
                console.log(JSON.parse(absol.cookie.get('userJD')));
                console.log(acessToken);
            }
        })();
    window.close();
    </script>
</body>

</html>