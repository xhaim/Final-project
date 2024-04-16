<?php
// Include the database connection file
include("../includes/db.php");
?>
<style>
@media print {
    button {
        display: none;
    }
}
</style>
<button onclick="printTable()"> Products PDF</button>

<div id="tableContainer" style="display:none;">
<?php
    // Query to fetch data from the products table
    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    // Check if the query was successful and if records are found
    if ($result && mysqli_num_rows($result) > 0) {
      // Echo the image and h1 header
    echo "<div style='display: flex; align-items: center; justify-content: center;'>";
    echo "<img src='../images/android-chrome-192x192.png' alt='Image' style='width: 50px; height: 50px; margin-right: 20px;'>";
    echo "<h1>VeSerAnCa Tidal Trend</h1>";
    echo "<h1>Products</h1>";
    echo "</div>";

        ?>
        <table border='1' style='width: 100%;'>
            <tr>
                <th>Product Title</th>
                <th>Product Price</th>
                <th>Product Sale Price</th>
            </tr>
            <?php
            // Loop through each row and print data in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['product_title']."</td>";
                echo "<td>".$row['product_price']."</td>";
                echo "<td>".$row['product_psp_price']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No records found</p>";
    }

    // Close the database connection
    mysqli_close($con);
?>
</div>

<script>
function printTable() {
    var tableContainer = document.getElementById("tableContainer");
    var oldDisplay = tableContainer.style.display;
    tableContainer.style.display = "block";
    window.print();
    tableContainer.style.display = "none";
}
</script>



<!-- customers -->

<button onclick="printTablecustomer()">Customers PDF</button>

<div id="tableContainerCustomer" style="display:none;">
<?php
    // Include the database connection file again
    include("../includes/db.php");

    // Query to fetch data from the customers table
    $query = "SELECT * FROM customers";
    $result = mysqli_query($con, $query);

    // Check if the query was successful and if records are found
    if ($result && mysqli_num_rows($result) > 0) {
        // Echo the h1 header
        echo "<div style='display: flex; align-items: center; justify-content: center;'>";
        echo "<img src='../images/android-chrome-192x192.png' alt='Image' style='width: 50px; height: 50px; margin-right: 20px;'>";
        echo "<h1>VeSerAnCa Tidal Trend</h1>";
        echo "<h1>Customers</h1>";
        echo "</div>";
        ?>
        <table border='1' style='width: 100%;'>
            <tr>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Contact</th>
                <th>Customer Address</th>
                <th>Customer Image</th>
            </tr>
            <?php
            // Loop through each row and print data in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['customer_name']."</td>";
                echo "<td>".$row['customer_email']."</td>";
                echo "<td>".$row['customer_city']."</td>";
                echo "<td>".$row['customer_contact']."</td>";
                echo "<td>".$row['customer_address']."</td>";
                echo "<td>".$row['customer_image']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No records found</p>";
    }

    // Close the database connection
    mysqli_close($con);
?>
</div>

<script>
function printTablecustomer() {
    var tableContainerCustomer = document.getElementById("tableContainerCustomer");
    var oldDisplay = tableContainerCustomer.style.display;
    tableContainerCustomer.style.display = "block";
    window.print();
    tableContainerCustomer.style.display = "none";
}
</script>

<!-- orders -->

<button onclick="printTableorders()">Orders PDF</button>

<div id="tableContainerorders" style="display:none;">
<?php
    // Include the database connection file again
    include("../includes/db.php");

    // Query to fetch data from the pending_orders table
    $query = "SELECT * FROM customer_orders";
    $result = mysqli_query($con, $query);

    // Check if the query was successful and if records are found
    if ($result && mysqli_num_rows($result) > 0) {
        // Echo the h1 header
        echo "<div style='display: flex; align-items: center; justify-content: center;'>";
        echo "<img src='../images/android-chrome-192x192.png' alt='Image' style='width: 50px; height: 50px; margin-right: 20px;'>";
        echo "<h1>VeSerAnCa Tidal Trend</h1>";
        echo "<h1>Orders</h1>";
        echo "</div>";
        ?>
        <table border='1' style='width: 100%;'>
    <tr>
        <th>Month</th>
        <th>Earnings</th>
    </tr>
    <?php
    // Initialize an array to store monthly earnings
    $monthlyEarnings = array();
    $totalEarnings = 0; // Initialize total earnings variable

    while ($row = mysqli_fetch_assoc($result)) {
        // Extract month and year from the order_date
        $orderDate = $row['order_date'];
        $monthYear = date('Y-m', strtotime($orderDate));
        
        // If the month doesn't exist in the array, initialize it
        if (!isset($monthlyEarnings[$monthYear])) {
            $monthlyEarnings[$monthYear] = 0;
        }
        
        // Add due_amount to monthly earnings for that month
        $monthlyEarnings[$monthYear] += $row['due_amount'];

        // Add due_amount to total earnings
        $totalEarnings += $row['due_amount'];
    }
    
    // Display monthly earnings
    foreach ($monthlyEarnings as $monthYear => $earnings) {
        echo "<tr>";
        echo "<td>$monthYear</td>";
        echo "<td>$earnings</td>";
        echo "</tr>";
    }

    // Display total earnings row
    echo "<tr>";
    echo "<td>Total Earnings</td>";
    echo "<td>$totalEarnings</td>";
    echo "</tr>";
    ?>
</table>

        <?php
    } else {
        echo "<p>No records found</p>";
    }

    // Close the database connection
    mysqli_close($con);
?>
</div>

<script>
function printTableorders() {
    var tableContainerorders = document.getElementById("tableContainerorders");
    var oldDisplay = tableContainerorders.style.display;
    tableContainerorders.style.display = "block";
    window.print();
    tableContainerorders.style.display = "none";
}
</script>

