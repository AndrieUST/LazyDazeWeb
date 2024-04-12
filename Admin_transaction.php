<?php
include('connect.php');

// Fetch all orders from the manageorders table
$order_query = "SELECT * FROM manageorders";
$order_result = mysqli_query($conn, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out your orders!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="./Admin_Transaction.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" href="./LDAssets/lz logo.png">
  
</head>
<body>
    <div class="bg">
        <div class="topnav">
            <a href="admin_mainpage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
            </a>
            <div class="nav-h-layout">
                <div class="nav-icon">
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                    </a>
                </div>
                 <div class="nav-line"></div>
            </div>
        </div>
        <div class="container">
            <h2>All Orders</h2>
            <form action="Confirm_Order.php" method="post">
            <table class="table">
                <thead>
                    <tr class="order-headers">
                        <th>OrderRefID</th>
                        <th>Customer Email</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Customer Number</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Image</th>
                        <th>Receipt Image</th>
                        <th>Action</th> <!-- Header for action buttons -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                   while ($row = mysqli_fetch_assoc($order_result)) {
                    // Add the class 'confirmed' if the order is confirmed
                    $class = ($row['Confirmed'] == 1) ? 'confirmed' : '';
                
                    echo "<tr class='orders $class'>"; 
                    // Echo order details in each column
                    echo "<td>" . $row['OrderRefID'] . "</td>";
                    echo "<td>" . $row['Customer_Email'] . "</td>";
                    echo "<td>" . $row['Customer_Name'] . "</td>";
                    echo "<td>" . $row['Customer_Address'] . "</td>";
                    echo "<td>" . $row['Customer_Number'] . "</td>";
                    echo "<td>" . $row['Product_Name'] . "</td>";
                    echo "<td>" . $row['Size'] . "</td>";
                    echo "<td>" . $row['Quantity'] . "</td>";
                    echo "<td>" . $row['TotalPrice'] . "</td>";
                    echo "<td><img src='" . $row['img'] . "' alt='Product Image' width='135px'></td>";
                    echo "<td><img src='" . $row['Receipt_img'] . "' width='100' onclick='showLargerImage(this.src)' style='cursor:pointer'></td>"; 
                    echo "<td>";
                    
                    // Check if the order is confirmed
                    if ($row['Confirmed'] == 1) {
                        // If confirmed, disable the buttons
                        echo "<button type='button' class='confirm-btn' disabled>Confirm</button>";
                        echo "<button type='button' class='deny-btn' disabled>Deny</button>";
                    } else {
                        // If not confirmed, display the buttons with form submission
                        echo "<form action='Confirm_Order.php' method='post' onsubmit='return confirmOrder()'>";
                        echo "<button type='submit' name='confirm' class='confirm-btn' value='" . $row['OrderRefID'] . "'>Confirm</button>";
                        echo "</form>";
                        echo "<form action='Deny_Order.php' method='post' onsubmit='return confirmDeny()'>";
                        echo "<button type='submit' class='deny-btn' name='deny' value='" . $row['OrderRefID'] . "'>Deny</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                    ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>
    <script>
        function showLargerImage(imageSrc) {
            var modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.position = 'fixed';
            modal.style.zIndex = '999';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.overflow = 'auto';
            modal.onclick = function() { modal.style.display = 'none'; };

            var modalContent = document.createElement('div');
            modalContent.classList.add('modal-content');
            modalContent.style.margin = 'auto';
            modalContent.style.display = 'block';
            modalContent.style.width = '80%';
            modalContent.style.maxWidth = '700px';
            modalContent.style.position = 'relative';
            modal.appendChild(modalContent);

            var img = document.createElement('img');
            img.src = imageSrc;
            img.style.width = '100%';
            img.style.height = '75%';
            img.style.cursor = 'pointer';
            img.onclick = function(event) { event.stopPropagation(); };
            modalContent.appendChild(img);

            document.body.appendChild(modal);
        }
        
        // Add click event listener to all confirm buttons
        function confirmOrder() {
            
                var input = document.createElement('input');
                input.type = 'hidden';
                document.forms[0].appendChild(input);
                return true;
            }
        

        function confirmDeny() {
            if (confirm('Do you want to Deny the Order of this User?')) {
                var input = document.createElement('input');
                input.type = 'hidden';
                document.forms[0].appendChild(input);
                return true;
            }
            return false; // Cancel submission if Admin cancels the prompt or provides no reason
        }
    </script>
</body>
</html>
