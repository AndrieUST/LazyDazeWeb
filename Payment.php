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
$customer_query = "SELECT Customer_Email, Customer_HouseNumber, Customer_Street, Customer_Barangay, Customer_City, Customer_Postal, Customer_Number FROM users WHERE Customer_Email = '$customer_email'";
$customer_result = mysqli_query($conn, $customer_query);
$customer_row = mysqli_fetch_assoc($customer_result);
$customer_house_number = $customer_row['Customer_HouseNumber'];
$customer_street = $customer_row['Customer_Street'];
$customer_barangay = $customer_row['Customer_Barangay'];
$customer_city = $customer_row['Customer_City'];
$customer_postal = $customer_row['Customer_Postal'];
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
    $customer_house_number = $_POST['Customer_HouseNumber'];
    $customer_street = $_POST['Customer_Street'];
    $customer_barangay = $_POST['Customer_Barangay'];
    $customer_city = $_POST['Customer_City'];
    $customer_postal = $_POST['Customer_Postal'];
    $customer_number = $_POST['Customer_Number'];
    $receipt_img = $_FILES['Receipt_img']['name'];

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
            $emailBody .= '<p><strong>Customer House Number:</strong> ' . $customer_house_number . '</p>';
            $emailBody .= '<p><strong>Customer Street:</strong> ' . $customer_street . '</p>';
            $emailBody .= '<p><strong>Customer Barangay:</strong> ' . $customer_barangay . '</p>';
            $emailBody .= '<p><strong>Customer City:</strong> ' . $customer_city . '</p>';
            $emailBody .= '<p><strong>Customer Postal:</strong> ' . $customer_postal . '</p>';
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

            // Attach the image file
           $mail->addAttachment($target_file);

            // Attempt to send email
            if ($mail->send()) {
                $emailSent = true;
                echo 'Message has been sent';
                // Convert UTC timestamp to Philippine time
                $order_date_local = new DateTime($order_date, new DateTimeZone('UTC'));
                $order_date_local->setTimezone(new DateTimeZone('Asia/Manila'));
                $local_order_date_formatted = $order_date_local->format('Y-m-d H:i:s');
                echo "Order Date (Philippine Time): " . $local_order_date_formatted;
            } else {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
            // If email sent successfully, insert data into manageorders table
            if ($emailSent) {
                // Reset pointer of cart_result
                // Fetch data from managecart table
mysqli_data_seek($cart_result, 0);
while ($row = mysqli_fetch_assoc($cart_result)) {
    // Fetch necessary data from managecart table
    $product_name = $row['Product_Name'];
    $size = $row['Size'];
    $quantity = $row['Quantity'];
    $price =$row['Price'];
    $total_price = $row['TotalPrice'];
    $img = $row['img']; // Fetch 'img' field from managecart

    // Fetch ProductID and Prod_Cost from manageprod table
    $prod_query = "SELECT ProductID, Prod_Cost FROM manageprod WHERE Product_Name = '$product_name'";
    $prod_result = mysqli_query($conn, $prod_query);
    $prod_row = mysqli_fetch_assoc($prod_result);
    $product_id = $prod_row['ProductID'];
    $prod_cost = $prod_row['Prod_Cost'];

    // Insert order into manageorders table
    $insert_query = "INSERT INTO manageorders (Customer_Email, Customer_Name, Customer_HouseNumber, Customer_Street, Customer_Barangay, Customer_City, Customer_Postal, Customer_Number, ProductID, Product_Name, Price, Size, Quantity, TotalPrice, Prod_Cost, img, Receipt_img, Order_Date) VALUES ('$customer_email', '$customer_name', '$customer_house_number', '$customer_street', '$customer_barangay', '$customer_city', '$customer_postal', '$customer_number', '$product_id', '$product_name','$price', '$size', '$quantity', '$total_price', '$prod_cost', '$img', '$target_file', '$local_order_date_formatted')";
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
    <label>Total Price for All Items:</label>
    <p style="font-weight: bold; font-size: 1.2em;"><?php echo $total_price; ?></p>
</div>
                    <div class="form-group">
                        <label for="name">Customer Name:</label>
                        <input type="text" class="form-control" id="name" name="Customer_Name">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Customer Email:</label>
                        <input type="email" class="form-control" id="email" name="Customer_Email" value="<?php echo $customer_email; ?>" readonly>
                        
                    </div>
                    <div class="form-group">
                        <label for="houseNumber">House Number:</label>
                        <input type="text" class="form-control" id="houseNumber" name="Customer_HouseNumber" value="<?php echo $customer_house_number; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" id="street" name="Customer_Street" value="<?php echo $customer_street; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay:</label>
                        <input type="text" class="form-control" id="barangay" name="Customer_Barangay" value="<?php echo $customer_barangay; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" id="city" name="Customer_City" value="<?php echo $customer_city; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="postal">Postal:</label>
                        <input type="text" class="form-control" id="postal" name="Customer_Postal" value="<?php echo $customer_postal; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Customer Number:</label>
                        <input type="number" class="form-control" id="number" name="Customer_Number" value="<?php echo $customer_number; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="paymentMethod">Select Payment Method:</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod">
                            <option value=""></option> <!-- Added default blank option -->
                            <?php
                            // Fetch payment methods from the database
                            $payment_methods_query = "SELECT * FROM payment_methods";
                            $payment_methods_result = mysqli_query($conn, $payment_methods_query);
                            while ($row = mysqli_fetch_assoc($payment_methods_result)) {
                                $selected = ''; // Initialize selected variable
                                if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == $row['id']) {
                                    $selected = 'selected'; // Mark as selected if payment method matches
                                }
                                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['payment_method'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <div id="qrCodeContainer">
                        <?php
                        // Display blank image initially
                        echo '<img id="qrCodeImage" src="" alt="QR Code" style="max-width: 200px;">';
                        ?>
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="receiptImg">Upload Receipt Image:</label>
                        <input type="file" class="form-control-receipt" id="receiptImg" name="Receipt_img">
                    </div>


                    <button type="submit" class="submit-btn">Place Order</button>
                </section>
            </form>
        </section>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    // Function to update QR code image source based on selected payment method
    $(document).ready(function(){
        $('#paymentMethod').change(function(){
            var paymentMethodId = $(this).val();
            $.ajax({
                url: 'get_qr_code.php', // PHP script to fetch QR code image path based on payment method ID
                method: 'POST',
                data: {paymentMethodId: paymentMethodId},
                success: function(response){
                    $('#qrCodeImage').attr('src', response);
                }
            });
        });

        // Add click event listener to QR code image
        $('#qrCodeImage').click(function(){
            // Toggle zoom effect by adding/removing CSS class
            $(this).toggleClass('zoomed');
        });
    });
</script>

</body>
</html>
