<?php
include('connect.php');
require 'vendor/autoload.php'; // Include PHPMailer autoload file

// Admin's email
$adminEmail = "johnlinga0949@gmail.com";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Customer_Email = $_SESSION['registered_email']; // Get the dynamic email from the session variable
    $Customer_Name = $_POST['name-text-box'];
    $Inquiry_Message = $_POST['inquiry-text-box'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'johnlinga0949@gmail.com'; // SMTP username
    $mail->Password = 'vhyp kqbj ewaq igdr'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; // TCP port to connect to

    // Sender and recipient
    $mail->setFrom($adminEmail); // Admin's email address
    $mail->addAddress($adminEmail, 'John Linga'); // Admin's email address and name

    // Set the "Reply-To" header to the customer's email
    $mail->addReplyTo($Customer_Email);

    // Email subject and message
    $mail->Subject = 'New Inquiry';
    $mail->Body = "Customer Email: $Customer_Email\n\nName: $Customer_Name\n\nInquiry: $Inquiry_Message";

    // Send email
    if ($mail->send()) {
        // Insert details into the database
        $query = "INSERT INTO manageinquiry (Customer_Email, Customer_Name, Inquiry_Message) VALUES ('$Customer_Email', '$Customer_Name', '$Inquiry_Message')";
        if (mysqli_query($conn, $query)) {
            // Alert message using JavaScript
            echo '<script>alert("Your inquiry has been submitted successfully. Please await our response via email. Thank you!");</script>';
            // Redirect to inquiries.php after successful submission
            echo '<script>window.location.href = "inquiries.php";</script>';
            exit(); // Ensure that no other content is sent after the redirection
        } else {
            echo 'Failed to submit your inquiry. Please try again later.';
        }
    } else {
        echo 'Failed to submit your inquiry. Please try again later.';
    }
}
?>
