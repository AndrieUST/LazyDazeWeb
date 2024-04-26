<?php
include('connect.php');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["confirm"])) {
    // Get the verification code submitted by the user
    $verification_code = $_POST["email_input"];
    
    // Retrieve the registered email from the session
    $Customer_Email = $_SESSION['registered_email'];

    // Check if the verification code matches the one sent to the user
    $query = "SELECT verification_code, email_verified_at FROM users WHERE Customer_Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $Customer_Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_verification_code = $row['verification_code'];
        $email_verified_at = $row['email_verified_at'];

        if ($email_verified_at !== null) {
            echo "Email already verified. Redirecting to main page...";
            header("Refresh:2; url=mainpage.php");
            exit;
        }

        if($stored_verification_code === $verification_code) {
            // Update the email_verified_at field to mark the email as verified
            $update_query = "UPDATE users SET email_verified_at = NOW(), Confirmed = 1 WHERE Customer_Email = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("s", $Customer_Email);
            if($stmt->execute()) {
                // Redirect the user to the main page or any other destination
                header("Location: mainpage.php");
                exit;
            } else {
                echo "Error updating record: " . $stmt->error;
            }
        } else {
            echo "<div class='warning'>Invalid verification code. Please try again.</div>";
        }
    } else {
        echo "<div class='warning'>User not found or multiple users with the same email. Please contact support.</div>";
    }
}

if(isset($_POST["resend"])) {
    // Retrieve the registered email from the session
    $Customer_Email = $_SESSION['registered_email'];

    // Generate a new verification code
    $new_verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    // Update the verification code in the database
    $update_query = "UPDATE users SET verification_code = ?, Confirmed = 0 WHERE Customer_Email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ss", $new_verification_code, $Customer_Email);
    if($stmt->execute()) {
        // Send the verification email with the new code
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Specify SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'johnlinga0949@gmail.com'; // SMTP username
            $mail->Password   = 'vhyp kqbj ewaq igdr';            // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
        
            //Recipients
            $mail->setFrom('johnlinga0949@gmail.com', 'LazyDaze.com');
            $mail->addAddress($Customer_Email);     // Add a recipient
        
            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your new verification code is: ' . $new_verification_code;
        
            $mail->send();
            echo 'Verification code resent successfully.';
            $_SESSION['registered_email'] = $Customer_Email;
            $_SESSION['email_verified_at'] = date('Y-m-d H:i:s'); // Set to the current timestamp
        } catch (Exception $e) {
            echo "Error sending verification code: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error updating verification code: " . $stmt->error;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Verification Code</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./email.css" rel="stylesheet" type="text/css"/>
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

    <h1>Verify Account</h1>
    <div class = "email-center">
    <form id = "email"  action = "email_code.php" method ="post">
        <label>Verification Code</label>
        <input type = "text" class = "email-input"  name ="email_input">
        <button type= "resend" class = "resend-btn" name = "resend" value = "resend">Resend Code</button>
        <button type= "confirm" class = "confirm-btn" name = "confirm" value = "confirm">Confirm</button>
       
    </form>
    </div>
    </div>
	</body>
</html>