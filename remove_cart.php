<?php
include('connect.php');

// Check if the product_id is set in the POST request
if (isset($_POST['product_id'])) {
    // Retrieve the product_id
    $product_id = $_POST['product_id'];

    // Remove the product from the managecart table
    $remove_query = "DELETE FROM managecart WHERE id = '$product_id'";
    $result = mysqli_query($conn, $remove_query);

    if ($result) {
        // Return success message (optional)
        echo "Product removed successfully";
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    }
}
?>
