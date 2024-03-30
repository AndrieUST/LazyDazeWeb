<?php

include('connect.php'); // Include database connection file

if (isset($_POST['submit']) && $_POST['submit'] === 'submit_review') {
    $Customer_Email = $_SESSION['registered_email'];
    $Customer_Name = $_POST['customerName'];
    $Review_Message = $_POST['reviewText'];
    $Rating = $_POST['rating'];

    // Insert review into database
    $query = "INSERT INTO managereview (Customer_Email, Customer_Name, Review_Message, Rating) 
              VALUES ('$Customer_Email', '$Customer_Name', '$Review_Message', '$Rating')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Review submitted successfully.');</script>";
        header("Location: reviews.php"); // Redirect back to reviews.php after submission
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
