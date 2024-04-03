<?php

include('connect.php');

function send_password_reset($get_email,$token)
{
    
}


if($_POST ['resend'])
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