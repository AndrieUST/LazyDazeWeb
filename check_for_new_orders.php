<?php
// Include your database connection file
include('connect.php');

// Fetch the count of unconfirmed orders from the database
$order_query = "SELECT COUNT(*) AS newOrders FROM manageorders WHERE Confirmed = 0";
$order_result = mysqli_query($conn, $order_query);

if ($order_result) {
    // Fetch the count from the result set
    $row = mysqli_fetch_assoc($order_result);
    $newOrdersCount = $row['newOrders'];

    // Return the count as JSON
    echo json_encode(array('newOrders' => $newOrdersCount));
} else {
    // Handle the case where there's an error fetching the count
    echo json_encode(array('error' => 'Error fetching new orders count'));
}
?>
