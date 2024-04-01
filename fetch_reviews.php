<?php
include('connect.php');

// Fetch reviews from the database based on the product name
if (isset($_POST["product_name"])) { // Change to $_POST
    $Product_Name = $_POST["product_name"]; // Get the product name
    $reviews_query = "SELECT * FROM managereview WHERE Product_Name = '$Product_Name'";
    $reviews_result = mysqli_query($conn, $reviews_query);

    // Check if there are reviews
    if (mysqli_num_rows($reviews_result) > 0) {
        // Start building the HTML markup for reviews
        $reviews_html = '';
        while ($row = mysqli_fetch_assoc($reviews_result)) {
            // Append each review to the HTML markup
            $reviews_html .= '<div class="review">';
            $reviews_html .= '<h3>' . $row['Customer_Name'] . '</h3>';
            $reviews_html .= '<p>' . $row['Review_Message'] . '</p>';
            $reviews_html .= '<p class="rating">Rating: ';
            $rating = intval($row['Rating']);
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $reviews_html .= '<i class="fas fa-star"></i>';
                } else {
                    $reviews_html .= '<i class="far fa-star"></i>';
                }
            }
            $reviews_html .= '</p></div>';
        }
        // Output the HTML markup for reviews
        echo $reviews_html;
    } else {
        // If there are no reviews, display a message
        echo '<p>No reviews found for this product.</p>';
    }
} else {
    // If the product name is not provided, display a message
    echo '<p>Please select a product to view reviews.</p>';
}
?>
