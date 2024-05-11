<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_POST["confirm"])) {
    // Get the email input from the form
    $Customer_Email = $_POST["email_input"];

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
            // Send the password reset email with the reset code
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
                $mail->Subject = 'Password Reset Verification';
                $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $reset_code . '</b></p>';

                if ($mail->send()) {
                    echo "Password reset code sent successfully.";
                    $_SESSION['registered_email'] = $Customer_Email;
                    $_SESSION['email_verified_at'] = date('Y-m-d H:i:s'); // Set to the current timestamp
                    // Redirect to pass-resetcode.php
                    header("Location: pass-resetcode.php");
                    exit();
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
    
    // Check if the email belongs to the admin
    $admin_email = 'doffy.dualpass12@gmail.com'; // Admin email
    if ($Customer_Email === $admin_email) {
        // Generate a new password reset code for admin
        $reset_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // Update the admin's record with the reset code
        $update_query = "UPDATE admin SET verification_code = '$reset_code' WHERE Admin_Email = '$admin_email'";
        if (mysqli_query($conn, $update_query)) {

            // Send the password reset email with the reset code directly to admin's email
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
                $mail->addAddress($admin_email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Verification';
                $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $reset_code . '</b></p>';

                if ($mail->send()) {
                    echo "Password reset code sent successfully to admin.";
                    // Redirect to admin_pass_resetcode.php
                    header("Location: admin_pass_resetcode.php");
                    exit();
                } else {
                    echo "Error sending password reset code to admin: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Error sending password reset code to admin: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating reset code: " . mysqli_error($conn);
        }
    } else {
        // Handle other cases here if needed
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Verification</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./pass-reset.css" rel="stylesheet" type="text/css" />
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

        <h1>Reset Password</h1>
        <div class="email-center">
            <form id="email" action="password-reset.php" method="post">
                <label>Email Verification</label>
                <input type="text" class="email-input" name="email_input" required>
                <button type="submit" class="reset-btn" name="confirm" value="confirm">Send Password Reset Code</button><br><br>

            </form>
        </div>
    </div>
</body>

</html>
