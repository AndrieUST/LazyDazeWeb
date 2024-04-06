<?php
include('connect.php');

// Fetch cart items from the database for the current user
// Assuming you have a mechanism to retrieve the logged-in user's email
$customer_email = $_SESSION['registered_email']; // Assuming the email is stored in the session
$query = "SELECT * FROM managecart WHERE Customer_Email = '$customer_email'";
$result = mysqli_query($conn, $query);

// Count the number of rows (i.e., items in the cart)
$cart_count = mysqli_num_rows($result);

// Return the cart count as a JSON response
echo json_encode($cart_count);
?>
