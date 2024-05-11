<?php
include('connect.php');

// Check if a date parameter is provided
if(isset($_GET['date'])) {
    $date = $_GET['date'];
    // Check if end_date is provided, otherwise set it as the same as date
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : $date;

    // Fetch confirmed orders (Received) from the manageorders table for the selected date range, sorted by Date Completed in descending order
    $received_order_query = "SELECT * FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date' ORDER BY Date_Completed DESC";
    $received_order_result = mysqli_query($conn, $received_order_query);

    // Fetch refunded orders from the manageorders table for the selected date range, sorted by Date Completed in descending order
    $refunded_order_query = "SELECT * FROM manageorders WHERE Confirmed = 2 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date' ORDER BY Date_Completed DESC";
    $refunded_order_result = mysqli_query($conn, $refunded_order_query);

    // Fetch most ordered products and their sizes
    $most_ordered_query = "SELECT Product_Name, Size, SUM(Quantity) AS total_quantity FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date' GROUP BY Product_Name, Size ORDER BY total_quantity DESC LIMIT 5";
    $most_ordered_result = mysqli_query($conn, $most_ordered_query);

    // Fetch least ordered products and their sizes
    $least_ordered_query = "SELECT Product_Name, Size, SUM(Quantity) AS total_quantity FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date' GROUP BY Product_Name, Size ORDER BY total_quantity ASC LIMIT 5";
    $least_ordered_result = mysqli_query($conn, $least_ordered_query);

    // Fetch non-ordered products from the manageprod table
    $non_ordered_query = "SELECT Product_Name FROM manageprod WHERE Product_Name NOT IN (SELECT DISTINCT Product_Name FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date')";
    $non_ordered_result = mysqli_query($conn, $non_ordered_query);

    // Calculate total sales for the selected date range
    $total_sales_query = "SELECT SUM(TotalPrice) AS total_sales FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date'";
    $total_sales_result = mysqli_query($conn, $total_sales_query);
    $total_sales_row = mysqli_fetch_assoc($total_sales_result);
    $total_sales = $total_sales_row['total_sales'];

    // Calculate total refunded for the selected date range
    $total_refunded_query = "SELECT SUM(TotalPrice) AS total_refunded FROM manageorders WHERE Confirmed = 2 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date'";
    $total_refunded_result = mysqli_query($conn, $total_refunded_query);
    $total_refunded_row = mysqli_fetch_assoc($total_refunded_result);
    $total_refunded = $total_refunded_row['total_refunded'];

    // Calculate total production cost for the selected date range
    $total_prod_cost_query = "SELECT SUM(Prod_Cost) AS total_prod_cost FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') AND DATE(Date_Completed) BETWEEN '$date' AND '$end_date'";
    $total_prod_cost_result = mysqli_query($conn, $total_prod_cost_query);
    $total_prod_cost_row = mysqli_fetch_assoc($total_prod_cost_result);
    $total_prod_cost = $total_prod_cost_row['total_prod_cost'];

    // Calculate Total Gross Income for the selected date range
    $total_gross_income = $total_sales;

    // Calculate Net Income for the selected date range
    $net_income = $total_sales - $total_prod_cost;
} else {
    // If no date parameter is provided, fetch all orders and calculate total sales, total refunded, etc. for all orders
    // Fetch confirmed orders (Received) from the manageorders table, sorted by Date Completed in descending order
    $received_order_query = "SELECT * FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') ORDER BY Date_Completed DESC";
    $received_order_result = mysqli_query($conn, $received_order_query);

    // Fetch refunded orders from the manageorders table, sorted by Date Completed in descending order
    $refunded_order_query = "SELECT * FROM manageorders WHERE Confirmed = 2 AND Status NOT IN ('Pending', 'Delivering') ORDER BY Date_Completed DESC";
    $refunded_order_result = mysqli_query($conn, $refunded_order_query);

    // Fetch most ordered products and their sizes
    $most_ordered_query = "SELECT Product_Name, Size, SUM(Quantity) AS total_quantity FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering') GROUP BY Product_Name, Size ORDER BY total_quantity DESC LIMIT 5";
    $most_ordered_result = mysqli_query($conn, $most_ordered_query);

    // Fetch non-ordered products from the manageprod table
    $non_ordered_query = "SELECT Product_Name FROM manageprod WHERE Product_Name NOT IN (SELECT DISTINCT Product_Name FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering'))";
    $non_ordered_result = mysqli_query($conn, $non_ordered_query);

    // Calculate total sales
    $total_sales_query = "SELECT SUM(TotalPrice) AS total_sales FROM manageorders WHERE Confirmed = 1 AND Status NOT IN ('Pending', 'Delivering')";
    $total_sales_result = mysqli_query($conn, $total_sales_query);
    $total_sales_row = mysqli_fetch_assoc($total_sales_result);
    $total_sales = $total_sales_row['total_sales'];

    // Calculate total refunded
    $total_refunded_query = "SELECT SUM(TotalPrice) AS total_refunded FROM manageorders WHERE Confirmed = 2 AND Status NOT IN ('Pending', 'Delivering')";
    $total_refunded_result = mysqli_query($conn, $total_refunded_query);
    $total_refunded_row = mysqli_fetch_assoc($total_refunded_result);
    $total_refunded = $total_refunded_row['total_refunded'];

    // Calculate total production cost
    $total_prod_cost_query = "SELECT SUM(Prod_Cost) AS total_prod_cost FROM manageorders WHERE Status NOT IN ('Pending', 'Delivering')";
    $total_prod_cost_result = mysqli_query($conn, $total_prod_cost_query);
    $total_prod_cost_row = mysqli_fetch_assoc($total_prod_cost_result);
    $total_prod_cost = $total_prod_cost_row['total_prod_cost'];

    // Calculate Total Gross Income
    $total_gross_income = $total_sales;

    // Calculate Net Income
    $net_income = $total_sales  - $total_prod_cost;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./Report_sales.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
    <!-- Background Image -->
    <div class="bg">
        <!-- Navigation Bar -->
        <div class="topnav">
            <a href="admin_mainpage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
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
         
        <!-- Received Orders Section -->
        <div class = "container">
        <div id="receivedOrders">
            <h2>Received Orders</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>OrderRefID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Production Cost</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Date Completed</th>
                        <!-- Add more headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display received orders
                    while ($row = mysqli_fetch_assoc($received_order_result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['OrderRefID']; ?></td>
                        <td><?php echo $row['Product_Name']; ?></td>
                        <td><?php echo $row['Price']; ?></td> <!-- Display Price -->
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['Prod_Cost']; ?></td> <!-- Display Prod Cost -->
                        <td><?php echo $row['TotalPrice']; ?></td> <!-- Display Total Price -->
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Order_Date']; ?></td> <!-- Display Order Date -->
                        <td><?php echo $row['Date_Completed']; ?></td> <!-- Display Date Completed -->
                        <!-- Add more cells for additional order details -->
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <p>Total Sales: <?php echo $total_sales; ?></p>
        </div>

        <!-- Refunded Orders Section -->
        <div id="refundedOrders">
            <h2>Refunded Orders</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>OrderRefID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Production Cost</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Date Completed</th>
                        <!-- Add more headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display refunded orders
                    while ($row = mysqli_fetch_assoc($refunded_order_result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['OrderRefID']; ?></td>
                        <td><?php echo $row['Product_Name']; ?></td>
                        <td><?php echo $row['Price']; ?></td> <!-- Display Price -->
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['Prod_Cost']; ?></td> <!-- Display Prod Cost -->
                        <td><?php echo $row['TotalPrice']; ?></td> <!-- Display Total Price -->
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Order_Date']; ?></td> <!-- Display Order Date -->
                        <td><?php echo $row['Date_Completed']; ?></td> <!-- Display Date Completed -->
                        <!-- Add more cells for additional order details -->
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <p>Total Refunded: <?php echo $total_refunded; ?></p>
        </div>

        <!-- Most Ordered Products Section -->
        <div id="mostOrderedProducts">
            <h2>Most Ordered Products</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display most ordered products
                    while ($row = mysqli_fetch_assoc($most_ordered_result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['Product_Name']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['total_quantity']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Non-Ordered Products Section -->
        <div id="nonOrderedProducts">
            <h2>Non-Ordered Products</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display non-ordered products
                    while ($row = mysqli_fetch_assoc($non_ordered_result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['Product_Name']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Income Summary Section -->
        <div id="income">
            <h2>Income Summary</h2>
            <p>Total Gross Income: <?php echo $total_gross_income; ?></p>
            <p>Total Product Cost: <?php echo $total_prod_cost; ?></p>
            <p>Net Income: <?php echo $net_income; ?></p>
        </div>
        
        <!-- Button to Show Graph -->
        <button id="showGraphButton" class = "graph-btn">Show Graph</button>

        <!-- Line Chart Section (Initially Hidden) -->
        <div id="lineChartContainer" style="display: none;">
            <canvas id="lineChart" width="400" height="300"></canvas>
        </div>
    </div>
    </div>

    <script>
    $(document).ready(function() {
        // Show/hide graph when button is clicked
        $('#showGraphButton').click(function() {
            $('#lineChartContainer').toggle();
            // Render chart if container is visible
            if ($('#lineChartContainer').is(':visible')) {
                renderChart();
            }
        });

        // Function to render the chart
        function renderChart() {
            // Data for the line chart
            var salesData = {
                labels: ["Sales", "Refunds", "Production Cost", "Net Income"],
                datasets: [{
                    label: "Income",
                    data: [<?php echo $total_sales; ?>, <?php echo $total_refunded; ?>, <?php echo $total_prod_cost; ?>, <?php echo $net_income; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            // Options for the line chart
            var salesOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            // Get the context of the canvas element we want to select
            var ctx = document.getElementById("lineChart").getContext('2d');

            // Instantiate a new line chart
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: salesData,
                options: salesOptions
            });
        }
    });
    </script>
</body>
</html>
