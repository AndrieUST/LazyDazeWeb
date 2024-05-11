<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (isset($_POST["confirm"])) {
    // Get the email input from the form
    $Customer_Email = $_POST['email_input'];
    
    // Set the registered email in the session
    $_SESSION['registered_email'] = $Customer_Email;
    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Generate a new password reset code
        $reset_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // Update the user's record with the reset code
        $update_query = "UPDATE users SET verification_code = '$reset_code' WHERE Customer_Email = '$Customer_Email'";
        if (mysqli_query($conn, $update_query)) {
            // Send the verification email with the reset code
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'doffy.dualpass12@gmail.com'; // Update with your Gmail address
                $mail->Password = 'qekn szpe wxsx ttzz'; // Update with your Gmail password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('doffy.dualpass12@gmail.com', 'LazyDaze.com');
                $mail->addAddress($Customer_Email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verify for Unverified Users account ';
                $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $reset_code . '</b></p>';

                if ($mail->send()) {
                    echo "Verification code sent successfully.";
                    // Set the registered email and email verification status in session
                    $_SESSION['registered_email'] = $Customer_Email;
                    $_SESSION['email_verified_at'] = date('Y-m-d H:i:s'); // Set to the current timestamp

                    // Redirect to the email verification page
                    header("Location: email_code2.php");
                    exit();
                } else {
                    echo "Error sending verification code: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Error sending verification code: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating reset code: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('User\'s Email is not registered.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify: Unverified Accounts</title>
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
<div class="bg">
  <!-- Navigation Bar -->
<div class="topnav">
        <a href="index.php">
          <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </div>

    <h1>Verify Email</h1>
    <div class="email-center">
    <form id="email" action="verify_email_again.php" method="post">
        <label>Email Verification</label>
        <input type="text" class="email-input" name="email_input" required>
        <button type="submit" class="verify-btn" name="confirm" value="confirm">Send Email to Verify</button><br><br>
    </form>
    </div>
    </div>
</body>
</html>
