<?php
require 'header.php';

$error = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '';

if(isset($_SESSION['login_id'])){
    header('Location: home.php');
    exit;
}
require 'google-api/vendor/autoload.php';
// Creating new google client instance
$client = new Google_Client();
// Enter your Client ID
$client->setClientId('680392531429-rmugfau9fajt8gabghnn4h4q8l0ahv6n.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
  $client->setRedirectUri('http://localhost/menully/google-log-in/login.php');
} else {
  $client->setRedirectUri('https://menully.com/google-log-in/login.php');
}
// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");
if(isset($_GET['code'])):
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token["error"])){
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);
        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `google_id` FROM `user` WHERE `google_id`='$id'");
        if(mysqli_num_rows($get_user) > 0){
            $_SESSION['login_id'] = $id;
            header('Location: home.php');
            exit;
        }
        else{
            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `user`(`google_id`,`name`,`email`,`username`,`profile_image`) VALUES('$id','$full_name','$email','$email','$profile_pic')");
            if($insert){
                $_SESSION['login_id'] = $id;
                header('Location: home.php');
                exit;
            }
            else{
                echo "Sign up failed!(Something went wrong).";
            }
        }
    }
    else{
        header('Location: login.php');
        exit;
    }

else:
    // Google Login Url = $client->createAuthUrl();
?>
<br><br>
<center>
<img src="../pages/templates/source/img/menully-logo.png" alt="" style="width:150px;">
</center>
<br>
<div class="row" style="margin:20px;">
    <center>
      <a href="<?php echo $client->createAuthUrl(); ?>" type="button" class="login-with-google-btn" >
        Sign in with Google
      </a>
      <br><br> Or
    </center>
  <form action="process.php?action=sign-in" method="post">
    <div class="col-12">
      <i style="color:red"><?=$error;?></i>
      <br>
      <b>Username</b>
      <input type="text" class="form-control" name="username" required>
    </div>
    <div class="col-12">
      <b>Password</b>
      <input type="password" class="form-control" name="password" required>

      <button type="submit" class="btn btn-primary mt-2">Sign In</button>
    </div>
  </form>
  <div class="col-12 text-center mt-2">
    Not a member yet? <a href="signup.php">Register here</a>
  </div>
</div>

<?php endif; ?>
