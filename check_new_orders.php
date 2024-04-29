<?php
// Include your database connection file
include('connect.php');



// Fetch the count of confirmed orders with status "Delivering" or "Pending"
$confirmed_order_query = "SELECT COUNT(*) AS confirmedOrders FROM manageorders WHERE Confirmed = 1 AND Status IN ('Delivering', 'Pending')";
$confirmed_order_result = mysqli_query($conn, $confirmed_order_query);

// Fetch the count of cancelled orders with status "Pending"
$cancelled_order_query = "SELECT COUNT(*) AS cancelledOrders FROM manageorders WHERE Confirmed = 2 AND Status = 'Pending'";
$cancelled_order_result = mysqli_query($conn, $cancelled_order_query);



$confirmedOrdersCount = 0;
$cancelledOrdersCount = 0;


// Process results for confirmed orders
if ($confirmed_order_result) {
    $row = mysqli_fetch_assoc($confirmed_order_result);
    $confirmedOrdersCount = $row['confirmedOrders'];
}

// Process results for cancelled orders
if ($cancelled_order_result) {
    $row = mysqli_fetch_assoc($cancelled_order_result);
    $cancelledOrdersCount = $row['cancelledOrders'];
}

// Return the counts as JSON
echo json_encode(array(
    
    'confirmedCount' => $confirmedOrdersCount,
    'cancelledCount' => $cancelledOrdersCount
));
?>
