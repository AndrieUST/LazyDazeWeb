<?php
include('connect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the order ID and reason for denial from the form submission
    $orderID = $_POST['deny'];
    // Retrieve reason value properly from the form submission
    $reason = isset($_POST['reason']) ? $_POST['reason'] : 'No reason provided';

    // Fetch the order details from the database
    $order_query = "SELECT * FROM manageorders WHERE OrderRefID = '$orderID'";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_result);

    // Update order status to cancelled in the database
    $update_query = "UPDATE manageorders SET Confirmed = 2 WHERE OrderRefID = '$orderID'"; // Assuming 2 represents cancelled status
    mysqli_query($conn, $update_query);

    // Send email notification to the user
    // Replace the placeholders with your SMTP credentials and appropriate email content
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
        $mail->addAddress($order['Customer_Email'], $order['Customer_Name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Denial Notification';
        $mail->Body = 'Dear customer,<br><br>Your order with OrderRefID: ' . $orderID . ' has been denied due to the following reason/s:<br>' . $reason . '<br>Your Payment will be refunded immediately.Wait for our Refund Confirmation thru Email. If you have any questions, please send us an inquiry from our inquiry page. Thank you!<br><br>Order Details:<br>';
        $mail->Body .= '<ul>';
        $mail->Body .= '<li>Customer Name: ' . $order['Customer_Name'] . '</li>';
        $mail->Body .= '<li>Customer Email: ' . $order['Customer_Email'] . '</li>';
        $mail->Body .= '<li>Customer House Number: ' . $order['Customer_HouseNumber'] . '</li>';
        $mail->Body .= '<li>Customer Street: ' . $order['Customer_Street'] . '</li>';
        $mail->Body .= '<li>Customer Barangay: ' . $order['Customer_Barangay'] . '</li>';
        $mail->Body .= '<li>Customer City: ' . $order['Customer_City'] . '</li>';
        $mail->Body .= '<li>Customer Postal: ' . $order['Customer_Postal'] . '</li>';
        $mail->Body .= '<li>Customer Number: ' . $order['Customer_Number'] . '</li>';
        $mail->Body .= '<li>Product Name: ' . $order['Product_Name'] . '</li>';
        $mail->Body .= '<li>Size: ' . $order['Size'] . '</li>';
        $mail->Body .= '<li>Quantity: ' . $order['Quantity'] . '</li>';
        $mail->Body .= '<li>Total Price: ' . $order['TotalPrice'] . '</li>';
        $mail->Body .= '</ul>';

        $mail->send();
        echo 'Email notification sent successfully';
        header('Location: Admin_transaction.php');
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
