<?php
// Database configuration
$servername = "localhost"; // Change this if your database server is hosted elsewhere
$username = "your_username"; // Replace with your database username
$password = "your_password"; // Replace with your database password
$database = "lazydaze"; // Replace with your database name

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Fetch email from the managecart table
$manageCartQuery = "SELECT DISTINCT Customer_Email FROM managecart";
$manageCartResult = mysqli_query($connection, $manageCartQuery);

// Fetch the first email address from the result set
$row = mysqli_fetch_assoc($manageCartResult);
$customerEmail = $row['Customer_Email'];

// Fetch data from the managecart table based on Customer_Email
$manageCartQuery = "SELECT * FROM managecart WHERE Customer_Email = '$customerEmail'";
$manageCartResult = mysqli_query($connection, $manageCartQuery);


// Check if any rows are returned
if (mysqli_num_rows($manageCartResult) > 0) {
    // Fetch the data from the users table
    $userDetailsQuery = "SELECT Customer_Number, Customer_Address FROM users WHERE Customer_Email = '$customerEmail'";
    $userDetailsResult = mysqli_query($connection, $userDetailsQuery);

    // Check if the query executed successfully
    if ($userDetailsResult === false) {
        die("ERROR: Could not execute query. " . mysqli_error($connection));
    }

    // Check if user details are found
    if (mysqli_num_rows($userDetailsResult) > 0) {
        // Fetch and display Customer_Number and Customer_Address
        $userDetails = mysqli_fetch_assoc($userDetailsResult);
        $customerNumber = $userDetails['Customer_Number'];
        $customerAddress = $userDetails['Customer_Address'];

        // Output the Customer_Number and Customer_Address
        echo "Customer Email: $customerEmail <br>";
        echo "Customer Number: $customerNumber <br>";
        echo "Customer Address: $customerAddress <br>";
    } else {
        echo "User details not found for email: $customerEmail";
    }
} else {
    echo "No items found in the cart for email: $customerEmail";
}

// Close the database connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lazy Daze!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="./Payment.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
    <div class="bg">
        <div class="topnav">
            <a href="homepage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
            </a>
            <div class="nav-h-layout">
                <div class="nav-icon">
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
                <div class="nav-icon">
                    <a href="cart.php">
                        <i class="fa-solid fa-cart-shopping fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
                <div class="nav-icon">
                    <a href="reviews.php">
                        <i class="fa-solid fa-star fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
                <div class="nav-icon">
                    <a href="inquiries.php">
                        <i class="fa-solid fa-circle-info fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
            </div>
        </div>
       
        <section class="container">
            <form method="post" action="">
                <section class="container">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                          </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </section>
            </form>
        </section>
    </div>
</body>
</html>
