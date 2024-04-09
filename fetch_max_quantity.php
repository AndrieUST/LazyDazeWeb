<?php
// Include your database connection file
include('connect.php');

// Check if the size is set in the POST data
if(isset($_POST['size'])) {
    // Sanitize the input to prevent SQL injection
    $size = mysqli_real_escape_string($conn, $_POST['size']);

    // Query to fetch the maximum quantity for the selected size from the manageprod table
    $query = "SELECT Quantity_$size FROM manageprod";
    $result = mysqli_query($conn, $query);

    if($result) {
        // Fetch the row from the result set
        $row = mysqli_fetch_assoc($result);
        // Retrieve the maximum quantity for the selected size
        $maxQuantity = $row["Quantity_$size"];
        // Return the maximum quantity as a response
        echo $maxQuantity;
    } else {
        // If the query fails, return an error message
        echo "Error: Unable to fetch maximum quantity for selected size.";
    }
} else {
    // If the size is not set in the POST data, return an error message
    echo "Error: Size parameter not set.";
}
?>
