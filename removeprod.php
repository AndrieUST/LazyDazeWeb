<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == "remove" && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        // Delete the product from the database
        $sql = "DELETE FROM manageprod WHERE ProductID = $product_id";
        if (mysqli_query($conn, $sql)) {
            // Product removed successfully
            header("Location: prod.php"); // Redirect back to the product management page
            exit();
        } else {
            // Error deleting product
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Action or product ID not provided
        echo "Action or product ID not provided.";
    }
}
?>
