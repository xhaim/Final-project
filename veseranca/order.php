<?php
// Start PHP code

// Include necessary files
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");

// Check if customer ID is set
if(isset($_GET['c_id'])){
    $customer_id = $_GET['c_id'];
}

// Get the real user IP address
$ip_add = getRealUserIp();

// Set order status to pending
$status = "pending";

// Generate a random invoice number
$invoice_no = mt_rand();

// Select items from the cart using the IP address
$select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";
$run_cart = mysqli_query($con, $select_cart);

// Insert orders into the database
while($row_cart = mysqli_fetch_array($run_cart)){
    $pro_id = $row_cart['p_id'];
    $pro_size = $row_cart['size'];
    $pro_qty = $row_cart['qty'];
    $sub_total = $row_cart['p_price'] * $pro_qty;

    // Fetch product details from products table
    $get_product = "SELECT product_title, product_img1 FROM products WHERE product_id='$pro_id'";
    $run_product = mysqli_query($con, $get_product);
    $row_product = mysqli_fetch_array($run_product);

    $product_title = $row_product['product_title'];
    $product_img1 = $row_product['product_img1'];

    // Insert into customer_orders table
    $insert_customer_order = "INSERT INTO customer_orders (customer_id, due_amount, invoice_no, qty, size, order_date, order_status, product_title, product_img1) VALUES ('$customer_id', '$sub_total', '$invoice_no', '$pro_qty', '$pro_size', NOW(), '$status', '$product_title', '$product_img1')";
    $run_customer_order = mysqli_query($con, $insert_customer_order);

    // Insert into pending_orders table
    $insert_pending_order = "INSERT INTO pending_orders (customer_id, invoice_no, product_id, qty, size, order_status, product_title, product_img1) VALUES ('$customer_id', '$invoice_no', '$pro_id', '$pro_qty', '$pro_size', '$status', '$product_title', '$product_img1')";
    $run_pending_order = mysqli_query($con, $insert_pending_order);

}

// Delete items from the cart
$delete_cart = "DELETE FROM cart WHERE ip_add='$ip_add'";
$run_delete = mysqli_query($con, $delete_cart);

// Display success message and redirect to my_account.php
echo "<script>alert('Your order has been submitted. Thank you.')</script>";
echo "<script>window.open('customer/my_account.php?my_orders', '_self')</script>";

// End PHP code
?>
