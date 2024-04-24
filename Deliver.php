<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['deliver'])) {
    $orderRefID = $_POST['deliver'];
    $message = $_POST['message']; // Get the message provided by the admin
    
    // Update the status of the order to "Delivered" in the database
    $update_query = "UPDATE manageorders SET Status = 'Delivering' WHERE OrderRefID = '$orderRefID'";
    mysqli_query($conn, $update_query);

    // Fetch order details using $orderRefID
    $order_query = "SELECT * FROM manageorders WHERE OrderRefID = '$orderRefID'";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_result);
    
    // Send email notification to the user
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'johnlinga0949@gmail.com'; // SMTP username
        $mail->Password = 'vhyp kqbj ewaq igdr'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('johnlinga0949@gmail.com', 'Lazy Daze.com');
        $mail->addAddress($order['Customer_Email'], $order['Customer_Name']);     // Add a recipient

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your order is on the way!';
        $mail->Body = 'Dear ' . $order['Customer_Name'] . ',<br><br>' .
                      'Your order with OrderRefID ' . $orderRefID . ' is now on the way.<br><br>' .
                      'Order Details:<br>' .
                      'Product Name: ' . $order['Product_Name'] . '<br>' .
                      'Size: ' . $order['Size'] . '<br>' .
                      'Quantity: ' . $order['Quantity'] . '<br>' .
                      'Total Price: ' . $order['TotalPrice'] . '<br><br>' .
                      'Message from admin: ' . $message . '<br><br>Thank you for shopping with us!';

        $mail->send();
        echo 'Message has been sent';
        // Redirect back to Admin_transaction.php
        header("Location: Admin_transaction.php");
        exit(); // Ensure no further code execution
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
