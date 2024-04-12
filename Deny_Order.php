<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the order ID and reason for denial from the form submission
    $orderID = $_POST['deny'];
    // Check if 'reason' key exists in $_POST array
  

    // Fetch the order details from the database
    $order_query = "SELECT * FROM manageorders WHERE OrderRefID = '$orderID'";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_result);

    // Send email notification to the user
    // Replace the placeholders with your SMTP credentials and appropriate email content
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'johnlinga0949@gmail.com'; // Update with your Gmail address
        $mail->Password = 'vhyp kqbj ewaq igdr'; // Update with your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('johnlinga0949@gmail.com', 'Lazy Daze.com');
        $mail->addAddress($order['Customer_Email'], $order['Customer_Name']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Denial Notification';
        $mail->Body = 'Dear customer,<br><br>Your order with OrderRefID ' . $orderID . ' has been denied due to the following reason: Did not Follow the Availability Of Quantity Per size<br>Did not match the Receipt.<br>If you have any questions, please send us an inquiry from our page. Thank you!<br><br>Order Details:<br>';
        $mail->Body .= '<ul>';
        $mail->Body .= '<li>Customer Name: ' . $order['Customer_Name'] . '</li>';
        $mail->Body .= '<li>Customer Email: ' . $order['Customer_Email'] . '</li>';
        $mail->Body .= '<li>Customer Address: ' . $order['Customer_Address'] . '</li>';
        $mail->Body .= '<li>Customer Number: ' . $order['Customer_Number'] . '</li>';
        $mail->Body .= '<li>Product Name: ' . $order['Product_Name'] . '</li>';
        $mail->Body .= '<li>Size: ' . $order['Size'] . '</li>';
        $mail->Body .= '<li>Quantity: ' . $order['Quantity'] . '</li>';
        $mail->Body .= '<li>Total Price: ' . $order['TotalPrice'] . '</li>';
        $mail->Body .= '</ul>';
        
        $mail->send();
        echo 'Email notification sent successfully';

    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
      
    // Delete the order data from the manageorders table
    $delete_query = "DELETE FROM manageorders WHERE OrderRefID = '$orderID'";
    if (mysqli_query($conn, $delete_query)) {
        echo 'Order data deleted successfully';
        header('Location: Admin_transaction.php');
    } else {
        echo 'Error deleting order data: ' . mysqli_error($conn);
    }
}
?>
