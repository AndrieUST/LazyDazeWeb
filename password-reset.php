<?php


include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["confirm"])) {
    // Get the email input from the form
    $Customer_Email = $_POST["email_input"];

    // Set the registered email in the session
    $_SESSION['registered_email'] = $Customer_Email;

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        

        // Generate a new password reset code
        $reset_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        

        // Update the user's record with the reset code
        $update_query = "UPDATE users SET verification_code = '$reset_code' WHERE Customer_Email = '$Customer_Email'";
        if(mysqli_query($conn, $update_query)) {
           

            // Send the password reset email with the reset code
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'johnlinga0949@gmail.com'; // Update with your Gmail address
                $mail->Password = 'vhyp kqbj ewaq igdr'; // Update with your Gmail password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('johnlinga0949@gmail.com', 'LazyDaze.com');
                $mail->addAddress($Customer_Email);

                $mail->isHTML(true);
                $mail->Subject = 'Email verification';
                $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $reset_code . '</b></p>';

                if($mail->send()) {
                    echo "Password reset code sent successfully.";
                    // Redirect to pass-resetcode.php
                    header("Location: pass-resetcode.php");
                    
                } else {
                    echo "Error sending password reset code: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Error sending password reset code: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating reset code: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('User\'s Email is not registered.');</script>";
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
    <form id = "email"  action = "password-reset.php" method ="post">
        <label>Email Verification</label>
        <input type = "text" class = "email-input"  name ="email_input" required>
        <button type= "submit" class = "reset-btn" name = "confirm" value = "confirm">Send Password Reset Code</button><br><br>
    
    </form>
    </div>
    </div>
	</body>
</html>
