<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the received button is clicked
if(isset($_POST['received'])) {
    $orderRefID = $_POST['received'];
    $update_query = "UPDATE manageorders SET Status = 'Received', Date_Completed = NOW() WHERE OrderRefID = '$orderRefID'";
    mysqli_query($conn, $update_query);

    // Send email to the user
    $customerEmailQuery = "SELECT Customer_Email, Customer_Name FROM manageorders WHERE OrderRefID = $orderRefID";
    $customerEmailResult = mysqli_query($conn, $customerEmailQuery);
    if($customerEmailResult) {
        $row = mysqli_fetch_assoc($customerEmailResult);
        $customerEmail = $row['Customer_Email'];
        
        // Email content
        $subject = "Order Successfully Received";
        $message = "Thank you for ordering! You Successfully Received your Order!.";
        
        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'johnlinga0949@gmail.com'; // SMTP username
            $mail->Password = 'vhyp kqbj ewaq igdr'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Set sender and recipient
            $mail->setFrom('johnlinga0949@gmail.com', 'Lazy Daze.com');
            $mail->addAddress($row['Customer_Email'], $row['Customer_Name']); // Use $row instead of $order

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send email
            $mail->send();
            echo 'Email has been sent.';
            header("Location: Admin_transaction.php");
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Unable to fetch customer email.";
    }
} else {
    echo "Error: Received button not clicked.";
}
?>
