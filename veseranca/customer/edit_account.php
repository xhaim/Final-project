<?php

$customer_session = $_SESSION['customer_email'];

$get_customer = "select * from customers where customer_email='$customer_session'";

$run_customer = mysqli_query($con,$get_customer);

$row_customer = mysqli_fetch_array($run_customer);

$customer_id = $row_customer['customer_id'];

$customer_name = $row_customer['customer_name'];

$customer_email = $row_customer['customer_email'];

$customer_region = $row_customer['customer_region'];

$customer_province = $row_customer['customer_province'];
$customer_city = $row_customer['customer_city'];
$customer_barangay = $row_customer['customer_barangay'];
$customer_street = $row_customer['customer_street'];

$customer_contact = $row_customer['customer_contact'];

$customer_address = $row_customer['customer_address'];

$customer_image = $row_customer['customer_image'];

?>

<h1 align="center" > Edit Your Account </h1>

<form action="" method="post" enctype="multipart/form-data" ><!--- form Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label> Customer Name: </label>

<input type="text" name="c_name" class="form-control" required value="<?php echo $customer_name; ?>">


</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label> Customer Email: </label>

<input type="text" name="c_email" class="form-control" required value="<?php echo $customer_email; ?>">

</div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Region *</label>
            <select name="region" class="form-control form-control-md" id="region">
                <option value="<?php echo $customer_region; ?>"><?php echo $customer_region; ?></option>
            </select>
            <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text"  value="<?php echo $customer_region; ?>">
        </div>

        <div class="col-sm-6 mb-3">
            <label class="form-label">Province *</label>
            <select name="province" class="form-control form-control-md" id="province">
                <option value="<?php echo $customer_province; ?>"><?php echo $customer_province; ?></option>
            </select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required value="<?php echo $customer_province; ?>">
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">City / Municipality *</label>
            <select name="city" class="form-control form-control-md" id="city">
                <option value="<?php echo $customer_city; ?>"><?php echo $customer_city; ?></option>
            </select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required value="<?php echo $customer_city; ?>">
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Barangay *</label>
            <select name="barangay" class="form-control form-control-md" id="barangay">
                <option value="<?php echo $customer_barangay; ?>"><?php echo $customer_barangay; ?></option>
            </select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required value="<?php echo $customer_barangay; ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label for="street-text" class="form-label">Street (Optional)</label>
            <input type="text" class="form-control form-control-md" name="street_text" id="street-text" value="<?php echo $customer_street; ?>">
        </div>
        <div class="col-md-6 mb-3">

        <label> Customer Contact </label>

        <input type="number" class="form-control" name="c_contact" required value="<?php echo $customer_contact; ?>">
        </div>
   



<div class="form-group" ><!-- form-group Starts -->

<label> Customer Address: </label>

<input type="text" name="c_address" class="form-control" required value="<?php echo $customer_address; ?>">


</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label> Customer Image: </label>

<input type="file" name="c_image" class="form-control" required ><br>

<img src="customer_images/<?php echo $customer_image; ?>" width="100" height="100" class="img-responsive" >


</div><!-- form-group Ends -->

<div class="text-center" ><!-- text-center Starts -->

<button name="update" class="btn btn-primary" >

<i class="fa fa-user-md" ></i> Update Now

</button>


</div><!-- text-center Ends -->


</form><!--- form Ends -->

<?php

if(isset($_POST['update'])){

$update_id = $customer_id;

$c_name = $_POST['c_name'];

$c_email = $_POST['c_email'];

$region_text = $_POST['region_text'];

$province_text = $_POST['province_text'];

$city_text = $_POST['city_text'];

$barangay_text = $_POST['barangay_text'];

$street_text = $_POST['street_text'];

$c_contact = $_POST['c_contact'];

$c_address = $_POST['c_address'];

$c_image = $_FILES['c_image']['name'];

$c_image_tmp = $_FILES['c_image']['tmp_name'];

move_uploaded_file($c_image_tmp,"customer_images/$c_image");

$update_customer = "update customers set customer_name='$c_name',
                                        customer_email='$c_email',
                                        customer_region='$region_text',
                                        customer_province='$province_text',
                                        customer_city='$city_text',
                                        customer_barangay='$barangay_text', 
                                        customer_street='$street_text',
                                        customer_contact='$c_contact',
                                        customer_address='$c_address',
                                        customer_image='$c_image' where customer_id='$update_id'";

$run_customer = mysqli_query($con,$update_customer);

if($run_customer){

echo "<script>alert('Your account has been updated please login again')</script>";

echo "<script>window.open('logout.php','_self')</script>";

}

}


?>
<script src="ph-address-selector.js"></script>