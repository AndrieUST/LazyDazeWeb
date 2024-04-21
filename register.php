<?php
include('connect.php'); // Include database connection file

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST["submit"])) {
    $Customer_Email = $_POST["register_email"];
    $Customer_PW = $_POST["register_password"];
    $Customer_HouseNumber = $_POST["HouseNumber"];
    $Customer_Street = $_POST["Street"];
    $Customer_Barangay = $_POST["Barangay"];
    $Customer_City = $_POST["City"];
    $Customer_Postal = $_POST["PostalNumber"];
    $Customer_Number = $_POST["Number"];
    $ConfirmPassword = $_POST["Confirmpassword"];

    // Check if password meets the complexity requirements
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $Customer_PW)) {
        echo "<script>alert('Password must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Check if the email is already taken
    $duplicate_check_users = mysqli_query($conn, "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'");
    $duplicate_check_admin = mysqli_query($conn, "SELECT * FROM admin WHERE Admin_Email = '$Customer_Email'");
    
    // Check if the email is already taken in either users or admin table
    if (mysqli_num_rows($duplicate_check_users) > 0 || mysqli_num_rows($duplicate_check_admin) > 0) {
        echo "<script>alert('Email Has Already Taken'); window.location.href = 'register.php';</script>";
        exit;
    }

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
            $_SESSION['registered_email'] = $Customer_Email;
            $_SESSION['email_verified_at'] = date('Y-m-d H:i:s'); // Set to the current timestamp
            
            // Insert user into the database using prepared statements
            $stmt = $conn->prepare("INSERT INTO users (Customer_Email, Customer_PW, Customer_HouseNumber, Customer_Street, Customer_Barangay, Customer_City, Customer_Postal, Customer_Number, verification_code, email_verified_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)");
            $stmt->bind_param("sssssssis", $Customer_Email, $hashedPassword, $Customer_HouseNumber, $Customer_Street, $Customer_Barangay, $Customer_City, $Customer_Postal, $Customer_Number, $verification_code);
            if ($stmt->execute()) {
                $_SESSION['registered_email'] = $Customer_Email;
                header("Location: email_code.php?register_email=" . $Customer_Email);
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Password Does Not Match');</script>";
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
<div class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </div>

    <!-- Register Page -->
    <h1>Create an account</h1>
    <div class = "register-center">
    <form id = "register"  action = "register.php" method ="post">
        <label>Email</label>
        <input type = "text" class = "email-input"  name ="register_email" required>
        <label>House Number</label>
        <input type = "text" class = "Address-input"  name ="HouseNumber" required>
        <label>Street</label>
        <input type = "text" class = "Address-input"  name ="Street" required>
        <label>Barangay</label>
        <input type = "text" class = "Address-input"  name ="Barangay" required>
        <label>City</label>
        <input type = "text" class = "Address-input"  name ="City" required>
        <label>Postal number</label>
        <input type = "text" class = "Address-input"  name ="PostalNumber" required>
        <label>Contact Number (+63)</label>
        <input type="text" class="number-input" name="Number" required pattern="^(?:\+63|0)\d{10}$" title="Please enter a valid Philippine mobile number starting with +63 or 0 and followed by 10 digits">

        <label>Password</label>
        <input type = "password" class = "password-input"  name ="register_password" required>
        <label>Confirm Password</label>
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
