<?php
include('connect.php');

// Check if the 'registered_email' key is set in the $_SESSION array
if(isset($_SESSION['registered_email'])) {
    // Fetch cart items from the database for the current user
    $customer_email = $_SESSION['registered_email'];
    $query = "SELECT * FROM managecart WHERE Customer_Email = '$customer_email'";
    $result = mysqli_query($conn, $query);

    // Count the number of rows (i.e., items in the cart)
    $cart_count = mysqli_num_rows($result);

    // Return the cart count as a JSON response
    echo json_encode($cart_count);
} else {
    // If 'registered_email' is not set in the $_SESSION array, return 0 as the cart count
    echo json_encode(0);
}
?>