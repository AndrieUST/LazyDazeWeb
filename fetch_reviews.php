<?php
include('connect.php');

// Initialize customer email as null
$Customer_Email = null;

// Fetch reviews from the database
if (isset($_SESSION['registered_email'])) {
    $Customer_Email = $_SESSION['registered_email'];
    $reviews_query = "SELECT * FROM managereview WHERE Customer_Email = '$Customer_Email'";
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
        echo '<p>No reviews found.</p>';
    }
} else {
    // If the user is not logged in, display a message
    echo '<p>Please log in to view reviews.</p>';
}
?>
