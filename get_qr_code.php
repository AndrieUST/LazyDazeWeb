<?php
// Include the database connection file
include('connect.php');

// Check if the paymentMethodId is set in the POST request
if(isset($_POST['paymentMethodId'])) {
    // Sanitize the input to prevent SQL injection
    $paymentMethodId = mysqli_real_escape_string($conn, $_POST['paymentMethodId']);

    // Query to fetch the QR code image path based on the payment method ID
    $query = "SELECT qr_code FROM payment_methods WHERE id = '$paymentMethodId'";
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if($result) {
        // Fetch the QR code image path from the result
        $row = mysqli_fetch_assoc($result);
        $qrCodeImagePath = $row['qr_code'];

        // Return the QR code image path as a response
        echo $qrCodeImagePath;
    } else {
        // Error handling if the query fails
        echo "Error: Unable to fetch QR code image path";
    }
} else {
    // Error handling if paymentMethodId is not set
    echo "Error: Payment method ID is not set";
}
?>
