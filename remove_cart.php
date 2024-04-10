<?php
include('connect.php');

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Check if the user is logged in and email is verified
    if(isset($_SESSION['registered_email']) && isset($_SESSION['email_verified_at']) && $_SESSION['email_verified_at'] !== null) {
        $customer_email = $_SESSION['registered_email'];
        
        // Delete the product from managecart table
        $delete_query = "DELETE FROM managecart WHERE id = '$id' AND Customer_Email = '$customer_email'";
        $delete_result = mysqli_query($conn, $delete_query);
        
        if($delete_result) {
            // Send a success message back to the client-side JavaScript
            echo "Product deleted successfully.";
        } else {
            // Send an error message back to the client-side JavaScript
            echo "Failed to delete product. Please try again.";
        }
    } else {
        // If the user is not logged in or email is not verified, display an appropriate message
        echo "User is not logged in or email is not verified.";
        // You may want to handle this case differently
    }
} else {
    // If product ID is not provided, display an appropriate message
    echo "Product ID is not provided.";
    // You may want to handle this case differently
}
?>
