<?php
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];

    // Retrieve product details to calculate total price
    $product_query = "SELECT * FROM managecart WHERE id = '$product_id'";
    $product_result = mysqli_query($conn, $product_query);

    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        $price = $product_row['Price'];
        
        // Calculate total price
        $total_price = $price * $quantity;

        // Update the managecart table with the new size, quantity, and total price
        $update_query = "UPDATE managecart SET Size = '$size', Quantity = '$quantity', TotalPrice = '$total_price' WHERE id = '$product_id'";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            // Redirect back to the cart page
            header("Location: cart.php");
            exit();
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Handle product not found error
        echo "Product not found.";
    }
}
?>
