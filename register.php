<?php
include('connect.php'); // Include database connection file

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (!empty($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["submit"])) {
    $Customer_Email = $_POST["register_email"];
    $Customer_PW = $_POST["register_password"];
    $Customer_Address = $_POST["Address"];
    $Customer_Number = $_POST["Number"];
    $ConfirmPassword = $_POST["Confirmpassword"];

    // Check if password meets the minimum length requirement
    if (strlen($Customer_PW) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.');</script>";
        
    }

    // Check if the email is already taken
    $duplicate_check = mysqli_query($conn, "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'");
    if (mysqli_num_rows($duplicate_check) > 0) {
        echo "<script>alert('Email Has Already Taken');</script>";
    } else {
        if ($Customer_PW == $ConfirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($Customer_PW, PASSWORD_DEFAULT);

            // Generate verification code
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            // Send verification email
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
                $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

                $mail->send();

                // Insert user into the database
                $query = "INSERT INTO users (Customer_Email, Customer_PW, Customer_Address, Customer_Number, verification_code, email_verified_at) 
                          VALUES ('$Customer_Email', '$hashedPassword', '$Customer_Address', '$Customer_Number', '$verification_code', NULL)";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['registered_email'] = $Customer_Email;
                    header("Location: email_code.php?register_email=" . $Customer_Email);
                    exit;
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<script>alert('Password Does Not Match');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./register.css" rel="stylesheet" type="text/css"/>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
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

    <!-- Register Page -->
    <h1>Create an account</h1>
    <div class = "register-center">
    <form id = "register"  action = "register.php" method ="post">
        <label>Email</label>
        <input type = "text" class = "email-input"  name ="register_email" required>
        <label>Address</label>
        <input type = "text" class = "Address-input"  name ="Address" required>
        <label>Contact Number</label>
        <input type = "number" class = "number-input"  name ="Number" required>
        <label>Password</label>
        <input type = "password" class = "password-input"  name ="register_password" required>
        <label>ConfirmPassword</label>
        <input type = "password" class = "password-input"   name ="Confirmpassword" minlength="8" required>
        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">Sign Up</button>
        <div class = "center">
        <p>Already have an account? <a href="login.php" class = "sign-in-text">Sign In</a>!</p>
        </div>
    </form>
    </div>
    </div>
</body>
</html>
