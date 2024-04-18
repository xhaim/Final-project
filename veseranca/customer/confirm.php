<?php

session_start();

if(!isset($_SESSION['customer_email'])){

echo "<script>window.open('../checkout.php','_self')</script>";


}else {

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

if(isset($_GET['order_id'])){

$order_id = $_GET['order_id'];

}

?>



<div id="content" ><!-- content Starts -->
<div class="container" ><!-- container Starts -->


<div class="col-md-3"><!-- col-md-3 Starts -->

<?php include("includes/sidebar.php"); ?>

</div><!-- col-md-3 Ends -->

<div class="col-md-9"><!-- col-md-9 Starts -->

<div class="box"><!-- box Starts -->

<h1 align="center"> Please Confirm Your Payment </h1>


<form action="confirm.php?update_id=<?php echo $order_id; ?>" method="post" enctype="multipart/form-data"><!--- form Starts -->



<div class="form-group"><!-- form-group Starts -->
    <label>Amount Sent:</label>
    <?php
        // Fetch the due_amount from customer_orders table
        $get_due_amount = "SELECT due_amount FROM customer_orders WHERE order_id = '$order_id'";
        $run_due_amount = mysqli_query($con, $get_due_amount);
        $row_due_amount = mysqli_fetch_array($run_due_amount);
        $due_amount = $row_due_amount['due_amount'];
    ?>
    <!-- Populate the due_amount in the input field -->
    <input type="text" class="form-control" name="amount_sent" value="<?php echo $due_amount; ?>" readonly>
</div><!-- form-group Ends -->


<div class="form-group"><!-- form-group Starts -->

<label>Select Payment Mode:</label>

<select name="payment_mode" class="form-control"><!-- select Starts -->

<option>Select Payment Mode</option>
<option>Cash</option>
<option>Gcash</option>
<option>Maya</option>
<option>BDO Unibank Inc.</option>
<option>Metropolitan Bank and Trust Company</option>
<option>Bank of the Philippine Islands</option>
<option>Land Bank of the Philippines</option>
<option>Philippine National Bank</option>
<option>Security Bank Corporation</option>
<option>China Banking Corporation</option>
<option>Development Bank of the Philippines</option>
<option>Union Bank of the Philippines</option>

</select><!-- select Ends -->

</div><!-- form-group Ends -->

<div class="text-center"><!-- text-center Starts -->

<button type="submit" name="confirm_payment" class="btn btn-primary btn-lg">

<i class="fa fa-user-md"></i> Confirm Payment

</button>

</div><!-- text-center Ends -->

</form><!--- form Ends -->

<?php

if(isset($_POST['confirm_payment'])){

$update_id = $_GET['update_id'];

$invoice_no = $_POST['invoice_no'];

$amount = $_POST['amount_sent'];

$payment_mode = $_POST['payment_mode'];

$complete = "Complete";

$insert_payment = "insert into payments (invoice_no,amount,payment_mode) values ('$invoice_no','$amount','$payment_mode')";

$run_payment = mysqli_query($con,$insert_payment);

$update_customer_order = "update customer_orders set order_status='$complete' where order_id='$update_id'";

$run_customer_order = mysqli_query($con,$update_customer_order);

$update_pending_order = "update pending_orders set order_status='$complete' where order_id='$update_id'";

$run_pending_order = mysqli_query($con,$update_pending_order);

if($run_pending_order){

echo "<script>alert('Thank you for ordering. Order again')</script>";

echo "<script>window.open('my_account.php?my_orders','_self')</script>";

}



}



?>


</div><!-- box Ends -->

</div><!-- col-md-9 Ends -->

</div><!-- container Ends -->
</div><!-- content Ends -->



<?php

include("includes/footer.php");

?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php } ?>
