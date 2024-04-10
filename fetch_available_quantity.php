<?php
include('connect.php');

if(isset($_POST['productName']) && isset($_POST['size'])) {
    $productName = $_POST['productName'];
    $size = $_POST['size'];

    // Fetch available quantity from manageprod table based on product name and size
    if ($size == 'XL') {
        $available_quantity_query = "SELECT Quantity_XL as AvailableQuantity FROM manageprod WHERE Product_Name = '$productName'";
    } else {
        $available_quantity_query = "SELECT Quantity_$size as AvailableQuantity FROM manageprod WHERE Product_Name = '$productName'";
    }

    $available_quantity_result = mysqli_query($conn, $available_quantity_query);

    if($available_quantity_result) {
        $available_quantity_row = mysqli_fetch_assoc($available_quantity_result);
        $available_quantity = $available_quantity_row['AvailableQuantity'];
        echo $available_quantity; // Return the available quantity
    } else {
        echo "Error fetching available quantity.";
    }
} else {
    echo "Error: Data not provided.";
}
?>
