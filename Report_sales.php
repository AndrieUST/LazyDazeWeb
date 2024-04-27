<?php
include('connect.php');

// Function to calculate total income for the given time period
function calculateIncome($start_date, $end_date) {
    global $conn;
    $income_query = "SELECT SUM(TotalPrice) AS total_income FROM manageorders WHERE Order_Date BETWEEN '$start_date' AND '$end_date'";
    $income_result = mysqli_query($conn, $income_query);
    $income_row = mysqli_fetch_assoc($income_result);
    return $income_row['total_income'];
}

// Function to find the most ordered product
function findMostOrderedProduct() {
    global $conn;
    $most_ordered_query = "SELECT Product_Name, SUM(Quantity) AS total_quantity FROM manageorders GROUP BY Product_Name ORDER BY total_quantity DESC LIMIT 1";
    $most_ordered_result = mysqli_query($conn, $most_ordered_query);
    $most_ordered_row = mysqli_fetch_assoc($most_ordered_result);
    return $most_ordered_row;
}

// Function to find the least ordered product
function findLeastOrderedProduct() {
    global $conn;
    $least_ordered_query = "SELECT Product_Name, SUM(Quantity) AS total_quantity FROM manageorders GROUP BY Product_Name ORDER BY total_quantity ASC LIMIT 1";
    $least_ordered_result = mysqli_query($conn, $least_ordered_query);
    $least_ordered_row = mysqli_fetch_assoc($least_ordered_result);
    return $least_ordered_row;
}

// Get current date
$current_date = date('Y-m-d');

// Calculate income for the past week
$week_start_date = date('Y-m-d', strtotime('-1 week', strtotime($current_date)));
$week_income = calculateIncome($week_start_date, $current_date);

// Calculate income for the past month
$month_start_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));
$month_income = calculateIncome($month_start_date, $current_date);

// Calculate income for the past year
$year_start_date = date('Y-m-d', strtotime('-1 year', strtotime($current_date)));
$year_income = calculateIncome($year_start_date, $current_date);

// Calculate income for the current day
$day_income = calculateIncome($current_date, $current_date);

// Find the most ordered product
$most_ordered_product = findMostOrderedProduct();

// Find the least ordered product
$least_ordered_product = findLeastOrderedProduct();
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
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<div class="topnav">
        <a href="">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="nav-h-layout">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                </a>
            </div>   
            <div class="nav-line"></div>
        </div>
  </div>

  <div class="container">
    <h2 class="text-center">Sales Report</h2>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Time Period</th>
              <th>Income</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Current Day</td>
              <td><?php echo $day_income; ?></td>
            </tr>
            <tr>
              <td>Past Week</td>
              <td><?php echo $week_income; ?></td>
            </tr>
            <tr>
              <td>Past Month</td>
              <td><?php echo $month_income; ?></td>
            </tr>
            <tr>
              <td>Past Year</td>
              <td><?php echo $year_income; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Most Ordered Product</th>
              <th>Total Quantity</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $most_ordered_product['Product_Name']; ?></td>
              <td><?php echo $most_ordered_product['total_quantity']; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Least Ordered Product</th>
              <th>Total Quantity</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $least_ordered_product['Product_Name']; ?></td>
              <td><?php echo $least_ordered_product['total_quantity']; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
