<?php
include('connect.php');
// Import PHPMailer classes into the global namespace

// Load Composer's autoloader
require 'vendor/autoload.php';
$adminEmail = "johnlinga0949@gmail.com";

// Fetch data from managecart table
if (isset($_SESSION['registered_email']) && isset($_SESSION['email_verified_at']) && $_SESSION['email_verified_at'] !== null) {
    $customer_email = $_SESSION['registered_email'];
    $cart_query = "SELECT * FROM managecart WHERE Customer_Email = '$customer_email'";
    $cart_result = mysqli_query($conn, $cart_query);
}

// Fetch customer details from users table
$customer_query = "SELECT Customer_Email, Customer_Address, Customer_Number FROM users WHERE Customer_Email = '$customer_email'";
$customer_result = mysqli_query($conn, $customer_query);
$customer_row = mysqli_fetch_assoc($customer_result);
$customer_address = $customer_row['Customer_Address'];
$customer_number = $customer_row['Customer_Number'];

// Initialize total price variable
$total_price = 0;

// Calculate total price
while ($row = mysqli_fetch_assoc($cart_result)) {
    $total_price += $row['TotalPrice'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = $_POST['Customer_Name'];
    $customer_email = $_POST['Customer_Email'];
    $customer_address = $_POST['Customer_Address'];
    $customer_number = $_POST['Customer_Number'];
    $receipt_img = $_FILES['Receipt_img']['name']; // Retrieve receipt image file name

    // File upload handling
    if (isset($_FILES["Receipt_img"])) {
        $target_dir = "uploads/"; // Specify the directory where you want to store uploaded files
        $target_file = $target_dir . basename($_FILES["Receipt_img"]["name"]);

        // Move uploaded file to the desired directory
        if (move_uploaded_file($_FILES["Receipt_img"]["tmp_name"], $target_file)) {
            // File uploaded successfully
            // Continue processing the form data

            // Create a flag to check if email sending is successful
            $emailSent = false;

            // Send email
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'johnlinga0949@gmail.com'; // SMTP username
            $mail->Password = 'vhyp kqbj ewaq igdr'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set email parameters
            $mail->setFrom('johnlinga0949@gmail.com', 'Lazy Daze Admin');
            $mail->addAddress($adminEmail, 'Lazy Daze');
            $mail->addReplyTo($customer_email); // Customer's email address for reply
            $mail->isHTML(true);
            $mail->Subject = 'New Order Received';
            // Construct email body with inserted data
            $emailBody = '<p>A new order has been received:</p>';
            $emailBody .= '<p><strong>Customer Name:</strong> ' . $customer_name . '</p>';
            $emailBody .= '<p><strong>Customer Email:</strong> ' . $customer_email . '</p>';
            $emailBody .= '<p><strong>Customer Address:</strong> ' . $customer_address . '</p>';
            $emailBody .= '<p><strong>Customer Number:</strong> ' . $customer_number . '</p>';
            $emailBody .= '<p><strong>Total Price:</strong> ' . $total_price . '</p>';
            $emailBody .= '<p><strong>Products:</strong></p>';
            $emailBody .= '<ul>';

            // Fetch data from managecart table
            mysqli_data_seek($cart_result, 0);
            while ($row = mysqli_fetch_assoc($cart_result)) {
                $emailBody .= '<li>';
                $emailBody .= 'Product Name: ' . $row['Product_Name'] . ', ';
                $emailBody .= 'Size: ' . $row['Size'] . ', ';
                $emailBody .= 'Quantity: ' . $row['Quantity'] . ', ';
                $emailBody .= 'Price: ' . $row['Price'];
                $emailBody .= '</li>';
            }

            $emailBody .= '</ul>';

            // Set email body
            $mail->Body = $emailBody;
            $mail->AltBody = 'A new order has been received. Please check the admin panel for details.';

            // Attempt to send email
            if ($mail->send()) {
                $emailSent = true;
                echo 'Message has been sent';
            } else {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // If email sent successfully, insert data into manageorders table
            if ($emailSent) {
                // Reset pointer of cart_result
                mysqli_data_seek($cart_result, 0);
                while ($row = mysqli_fetch_assoc($cart_result)) {
                    // Fetch necessary data
                    $product_name = $row['Product_Name'];
                    $size = $row['Size'];
                    $quantity = $row['Quantity'];
                    $total_price = $row['TotalPrice'];
                    $img = $row['img']; // Fetch 'img' field from managecart

                    // Insert order into manageorders table
                    $insert_query = "INSERT INTO manageorders (Customer_Email, Customer_Name, Customer_Address, Customer_Number, Product_Name, Size, Quantity, TotalPrice, img, Receipt_img) VALUES ('$customer_email', '$customer_name', '$customer_address', '$customer_number', '$product_name', '$size', '$quantity', '$total_price', '$img', '$target_file')";
                    mysqli_query($conn, $insert_query);

                    // Update Quantity in manageprod table
                    $update_query = "UPDATE manageprod SET Quantity_$size = Quantity_$size - $quantity WHERE Product_Name = '$product_name'";
                    mysqli_query($conn, $update_query);
                }

                // Delete orders from managecart table
                $delete_query = "DELETE FROM managecart WHERE Customer_Email = '$customer_email'";
                mysqli_query($conn, $delete_query);

                // Reset cart count to 0
                $_SESSION['cart_count'] = 0;

                // Redirect to another page after successful insertion
                header("Location: success.php");
                exit();
            }
        } else {
            // Error occurred while moving the file
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
       
        <div class="container">
            <h2>Your Orders</h2>
            <table class="table">
                <thead>
                    <tr class="order-headers">
                        <th></th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Fetch data from managecart table
                mysqli_data_seek($cart_result, 0);
                while ($row = mysqli_fetch_assoc($cart_result)) {
                    echo "<tr class='orders'>";
                    echo '<td><img src="' . $row['img'] . '" class="item-image" alt="Product Image"></td>';
                    echo "<td>" . $row['Product_Name'] . "</td>";
                    echo "<td>" . $row['Size'] . "</td>";
                    echo "<td>" . $row['Quantity'] . "</td>";
                    echo "<td>" . $row['TotalPrice'] . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <section class="container">
            <form method="post" action="" enctype="multipart/form-data">
                <section class="form-container">
                    <div class="form-group">
                        <label for="name">Customer Name:</label>
                        <input type="text" class="form-control" id="name" name="Customer_Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Customer Email:</label>
                        <input type="email" class="form-control" id="email" name="Customer_Email" value="<?php echo $customer_email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Customer Address:</label>
                        <input type="text" class="form-control" id="address" name="Customer_Address" value="<?php echo $customer_address; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Customer Number:</label>
                        <input type="number" class="form-control" id="number" name="Customer_Number" value="<?php echo $customer_number; ?>" required>
                    </div>
                    <div class="form-group">
                        <div class="qr-title">Click to enlarge image.</div>
                        <img id="qr" src="LDAssets/gcash-qr.png" class="qr-image" alt="Pay here!" style="width:100%;max-width:100px">
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="receiptImg">Upload Receipt Image:</label>
                        <input type="file" class="form-control-receipt" id="receiptImg" name="Receipt_img">
                    </div>
                    
                    <div class="form-group">
                        <label for="totalPrice">Overall Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice" value="<?php echo $total_price; ?>" readonly>
                    </div>
                    <button type="submit" class="submit-btn" name="submit">Submit Payment</button>
                </section>
            </form>
        </section>
    </div>
    <script>
        var modal = document.getElementById("myModal");

        var img = document.getElementById("qr");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
        }

        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
    </script>
</body>
</html>
