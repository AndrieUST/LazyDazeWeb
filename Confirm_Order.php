<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the confirm button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    // Get the order ID
    $orderID = $_POST['confirm'];

    // Fetch the order details from the database
    $order_query = "SELECT * FROM manageorders WHERE OrderRefID = $orderID";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_result);

    // Send an email to the customer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'doffy.dualpass12@gmail.com'; // Update with your Gmail address
        $mail->Password = 'qekn szpe wxsx ttzz'; // Update with your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('doffy.dualpass12@gmail.com', 'Lazy Daze.com');
        $mail->addAddress($order['Customer_Email'], $order['Customer_Name']);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your Order Confirmation';
        
        // Email body with order details
        $emailBody = 'Dear ' . $order['Customer_Name'] . ',<br><br>Your order has been confirmed.<br><br>Order Details:<br>';
        $emailBody .= '<ul>';
        $emailBody .= '<li>Order ID: ' . $order['OrderRefID'] . '</li>';
        $emailBody .= '<li>Product Name: ' . $order['Product_Name'] . '</li>';
        $emailBody .= '<li>Size: ' . $order['Size'] . '</li>';
        $emailBody .= '<li>Quantity: ' . $order['Quantity'] . '</li>';
        $emailBody .= '<li>Total Price: ' . $order['TotalPrice'] . '</li>';
        $emailBody .= '</ul>';
        $emailBody .= '<br>Please check your email for updates regarding your order delivery<br><br>Best regards,<br>Lazy Daze';
        
        $mail->Body = $emailBody;

        $mail->send();
        
        // Update the database to mark the order as confirmed
        $update_query = "UPDATE manageorders SET Confirmed = 1 WHERE OrderRefID = $orderID";
        mysqli_query($conn, $update_query);
        
        // Redirect back to the admin transaction page after sending the email
        header('Location: Admin_transaction.php');
        exit();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // If the "confirm" button is not clicked, redirect back to the admin transaction page
    header('Location: Admin_transaction.php');
    exit();
}
?>
