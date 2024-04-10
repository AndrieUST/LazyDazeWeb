<?php
include('connect.php');

// Initialize error message
$error_message = "";

if(isset($_POST['id']) && isset($_POST['size']) && isset($_POST['quantity'])) {
    // Sanitize input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Fetch price from manageprod table based on product name and size
    if ($size == 'XL') {
        $price_query = "SELECT Price FROM manageprod WHERE ProductID IN (SELECT ProductID FROM managecart WHERE id = $id)";
    } else {
        $price_query = "SELECT Price FROM manageprod WHERE ProductID IN (SELECT ProductID FROM managecart WHERE id = $id)";
    }
    
    $price_result = mysqli_query($conn, $price_query);

    if($price_result && mysqli_num_rows($price_result) > 0) {
        $price_row = mysqli_fetch_assoc($price_result);
        $price = $price_row['Price'];

        // Fetch available quantity from manageprod table based on product name and size
        if ($size == 'XL') {
            $available_quantity_query = "SELECT Quantity_XL as AvailableQuantity FROM manageprod WHERE ProductID IN (SELECT ProductID FROM managecart WHERE id = $id)";
        } else {
            $available_quantity_query = "SELECT Quantity_$size as AvailableQuantity FROM manageprod WHERE ProductID IN (SELECT ProductID FROM managecart WHERE id = $id)";
        }

        $available_quantity_result = mysqli_query($conn, $available_quantity_query);

        if($available_quantity_result && mysqli_num_rows($available_quantity_result) > 0) {
            $available_quantity_row = mysqli_fetch_assoc($available_quantity_result);
            $available_quantity = $available_quantity_row['AvailableQuantity'];

            // Check if the requested quantity exceeds the available quantity
            if($quantity > $available_quantity) {
                // If quantity exceeds available quantity, set error message
                $error_message = "Maximum quantity of has been reached for this product!";
            } else {
                // Calculate total price for the updated quantity
                $total_price = $price * $quantity;

                // Update the product in the database with new size, quantity, and total price
                $update_query = "UPDATE managecart SET Size = '$size', Quantity = '$quantity', TotalPrice = '$total_price' WHERE id = $id";
                $result = mysqli_query($conn, $update_query);

                if($result) {
                    // If update query is successful, set success message
                    $_SESSION['success_message'] = "Product updated successfully!";
                } else {
                    // If update query fails, set error message
                    $error_message = "Error updating product: " . mysqli_error($conn);
                }
            }
        } else {
            // If no rows are returned or available quantity query fails, set error message
            $error_message = "Error fetching available quantity for the product.";
        }
    } else {
        // If no rows are returned or price query fails, set error message
        $error_message = "Error fetching price information for the product.";
    }
} else {
    // Handle the case when data is not provided
    $error_message = "Error: Data not provided.";
}

// Set error message in session
$_SESSION['error_message'] = $error_message;

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
