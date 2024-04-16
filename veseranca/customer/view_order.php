<?php
session_start();

if(!isset($_SESSION['customer_email'])){
    echo "<script>window.open('../checkout.php','_self')</script>";
} else {
    include("includes/db.php");
    include("../includes/header.php");
    include("functions/functions.php");
    include("includes/main.php");
?>

<main>
    <!-- HERO -->
    <div class="nero">
        <div class="nero__heading">
            <span class="nero__bold">Product </span>View
        </div>
        <p class="nero__text"></p>
    </div>
</main>

<div id="content"><!-- content Starts -->
    <div class="container"><!-- container Starts -->
        <div class="container mt-5">
            <h2>Order Details</h2>
            <hr>
            <?php
            // Retrieve invoice number from URL parameter
            if(isset($_GET['invoice_no'])) {
                $invoice_no = $_GET['invoice_no'];

                // Query to retrieve orders with the given invoice number
                $get_order_details = "SELECT * FROM customer_orders WHERE invoice_no='$invoice_no'";
                $run_order_details = mysqli_query($con, $get_order_details);

                // Check if any orders are found with the given invoice number
                if(mysqli_num_rows($run_order_details) > 0) {
                    while($row_order_details = mysqli_fetch_array($run_order_details)) {
                        // Display order details for each order with the same invoice number
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Invoice Number:</strong> <?php echo $row_order_details['invoice_no']; ?></p>
                                <p><strong>Order Date:</strong> <?php echo $row_order_details['order_date']; ?></p>
                                <p><strong>Status:</strong> <?php echo $row_order_details['order_status']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Amount Due:</strong> ₱<?php echo $row_order_details['due_amount']; ?></p>
                                <p><strong>Product Title:</strong> <?php echo $row_order_details['product_title']; ?></p>
                                <img src="../admin_area/product_images/<?php echo $row_order_details['product_img1']; ?>" alt="Product Image" style="max-width: 200px;">
                            </div>
                            <a href="confirm.php?order_id=<?php echo $row_order_details['order_id']; ?>" target="blank" class="btn btn-success btn-xs">Order Received</a>
                        </div>
                        <hr>
                        <?php
                    }
                } else {
                    echo "<p>No orders found with the given invoice number.</p>";
                }
            } else {
                echo "<p>Invoice number not provided.</p>";
            }
            ?>
        </div>
    </div><!-- container Ends -->
</div><!-- content Ends -->

<?php } ?>
