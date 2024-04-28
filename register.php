<?php
include('connect.php'); // Include database connection file

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
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
    <form id = "register"  action = "register.php" method ="post" onsubmit="return validateForm()">
        <label>Email</label>
        <input type = "text" class = "email-input"  name ="register_email" required>
        <label>House Number/Building</label>
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
        <div class = "pass-conditions">
        <h5>For security purposes your password must have the following conditions:</h5>
        <ul>
            <li>One uppercase letter.</li>
            <li>One lowercase letter.</li>
            <li>One number.</li>
            <li>One special character.</li>
            <li>At least 8 characters long.</li>
        </ul>
        </div>
        
        <!-- Checkbox for agreeing to terms -->
        <div class="tnc-container">
        <input class = "chkbox" type="checkbox" id="agreeCheckbox" disabled required><p>Read the <a href="#" id="termsLink" data-toggle="modal" data-target="#termsModal">terms and conditions here</a> before agreeing.</p>
        </div>

        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">Sign Up</button>
        <div class = "center">
        <p>Already have an account? <a href="login.php" class = "sign-in-text">Sign In</a>!</p>
        </div>
    </form>
    </div>
    </div>
    <!-- Modal for displaying Terms and Conditions -->
    <div id="termsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms and Conditions</h4>
            </div>
            <div class="modal-body">
                <!-- Insert your Terms and Conditions content here -->
                <p>
                    <!-- Sample Terms and Conditions content -->
                    1. Ordering Procedure:<br>
                    Customers must view the Product and add desired Size and Quantity to the cart and proceed to the Cart. After Finalizing the Size and quantity, customers should proceed to Payment details and are required to fill out an order form with their details. Payment can be made online via GCash, bank transfer (upon prior coordination with the client). Customers must click the "Place Order" button to finalize their order.<br><br>
                    2. Payment Methods:<br>
                    Accepted payment methods include GCash, PayMaya, and bank transfer (upon coordination with the client).<br><br>
                    3. Shipping and Delivery:<br>
                    Shipping fees are not included unless explicitly stated. Customers are responsible for any applicable shipping fees. LazyDaze is not liable for shipping delays beyond our control, such as customs issues or adverse weather conditions. Customers must provide accurate shipping information, as we are not responsible for delays or losses due to incorrect information provided.<br><br>
                    4. Data Privacy:<br>
                    LazyDaze complies with the Data Privacy Act and ensures the confidentiality of customers' personal information. Any data collected is solely used for order processing and receipts. We do not share, sell, or rent personal information for marketing purposes. By using our services, you consent to our Privacy Policy.<br><br>
                    5. Product Details:<br>
                    We aim to provide accurate product descriptions and images on our website. However, slight variations in color and size may occur due to monitor settings and manufacturing processes.<br><br>
                    6. No Return Policy:<br>
                    We have a strict no-return policy, except for damaged or defective products upon receipt. Customers should carefully review product descriptions before purchasing. By using our services, you agree to adhere to these Terms and Conditions. If you disagree with any part, please refrain from using our services or making a purchase.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- Button to indicate agreement with Terms and Conditions -->
                <button type="button" class="btn btn-primary" id="agreeBtn" data-dismiss="modal" onclick="enableCheckbox()">I Agree</button>
            </div>
        </div>
    </div>
</div>

<!-- Script to handle showing Terms and Conditions modal and enabling the checkbox -->
<script>
    // Function to enable the checkbox when the user agrees with the Terms and Conditions
    function enableCheckbox() {
        $('#agreeCheckbox').prop('checked', true);
        $('#agreeCheckbox').prop('disabled', false);
    }

    // Validate the form before submission
    function validateForm() {
        if (!document.getElementById('agreeCheckbox').checked) {
            alert('Please agree to the Terms and Conditions.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
