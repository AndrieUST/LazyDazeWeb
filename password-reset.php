<?php

include('connect.php');

function send_password_reset($get_email,$token)
{
    
}


if(isset($_POST ['email_input']))
{
$email = mysqli_real_escape_string($conn, $_POST['Customer_Email']);
$token = md5(rand());

$check_email = "SELECT * FROM users WHERE Customer_Email ='$email' LIMIT 1";
$check_email_run = mysqli_query($conn, $check_email);

if(mysqli_num_rows($check_email_run) > 0)
{
    $row = mysqli_fetch_array($check_email_run);
    $get_email = $row['Customer_Email'];

    $update_token = "UPDATE users SET verify_token = '$token' WHERE Customer_Email='$get_email' LIMIT 1";
    $update_token_run = mysqli_query($conn, $update_token);
    if($update_token_run)
    {
        send_password_reset($get_email,$token);
        $_SESSION['status'] = "We e-emailed you a password reset link";
        header("Location: password-reset.php");
        exit(0);

    }
    else
    {
        $_SESSION['status'] = "Something went wrong. #1";
        header("Location: password-reset.php");
        exit(0);
    }
}
{
    $_SESSION['status'] = "No Email Found";
    header("Location: password-reset.php");
    exit(0);
}
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Verification</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./pass-reset.css" rel="stylesheet" type="text/css"/>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<header class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </header>

    <h1>Reset Password</h1>
    <div class = "email-center">
    <form id = "email"  action = "" method ="post">
        <label>Email Verification</label>
        <input type = "text" class = "email-input"  name ="email_input" required>
        <button type= "reset" class = "reset-btn" name = "reset" value = "reset">Send Password Reset Link</button>
    
    </form>
    </div>
    </div>
	</body>
</html>