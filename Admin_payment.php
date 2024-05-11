<?php
include('connect.php');

// Directory where QR code images are stored
$qr_code_directory = 'qr_codes/';

// Handle form submission to add new payment method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_payment_method'])) {
    $payment_method = $_POST['payment_method'];

    // Handle file upload
    $qr_code = ''; // Initialize the variable to store the file path
    if ($_FILES['qr_code_file']['error'] === UPLOAD_ERR_OK) {
        $temp_name = $_FILES['qr_code_file']['tmp_name'];
        $file_name = $_FILES['qr_code_file']['name'];
        $upload_dir = 'qr_codes/'; // Directory to upload QR code images
        $qr_code = $qr_code_directory . $file_name; // Set the full file path
        move_uploaded_file($temp_name, $qr_code);
    }

    // Insert new payment method into the database
    $insert_query = "INSERT INTO payment_methods (payment_method, qr_code) VALUES ('$payment_method', '$qr_code')";
    mysqli_query($conn, $insert_query);

    // Redirect to refresh the page
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Handle form submission to remove payment method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_payment_method'])) {
    $payment_method_id = $_POST['payment_method_id'];

    // Remove payment method from the database
    $delete_query = "DELETE FROM payment_methods WHERE id = $payment_method_id";
    mysqli_query($conn, $delete_query);

    // Redirect to refresh the page
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Fetch payment methods from the database
$payment_query = "SELECT * FROM payment_methods";
$payment_result = mysqli_query($conn, $payment_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./Admin_payment.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<div class="topnav">
        <a href="admin_mainpage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="nav-h-layout">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="./logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                </a>
            </div>   
            <div class="nav-line"></div>
        </div>
  </div>
<body>
    <div class="container">
        <h2>Payment Methods</h2>
        <table class="table">
            <thead>
                <tr>
                    
                    <th>Payment Method</th>
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($payment_result)) {
                    echo "<tr>";
                    
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td><img src='" . $row['qr_code'] . "' alt='QR Code' style='max-width: 100px;'></td>";
                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='payment_method_id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-danger' name='remove_payment_method'>Remove</button>
                            </form>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Form to add new payment method -->
        <h2>Add New Payment Method</h2>
        <form method="post" action="" enctype="multipart/form-data"> <!-- Add enctype attribute for file upload -->
            <div class="form-group">
                <label for="paymentMethod">Payment Method:</label>
                <input type="text" class="form-control" id="paymentMethod" name="payment_method" required>
            </div>
            <div class="form-group">
                <label for="qrCodeFile">Upload QR Code Image:</label> <!-- Add input for file upload -->
                <input type="file" class="form-control-file" id="qrCodeFile" name="qr_code_file" required>
            </div>
            <button type="submit" class="submit-btn" name="add_payment_method">Add Payment Method</button>
        </form>
    </div>
</body>
</html>
