
<div class="box" ><!-- box Starts -->

<div class="box-header" ><!-- box-header Starts -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<center>

<h1>Login</h1>

<p class="lead" >Already our Customer</p>


</center>

<p class="text-muted" style="text-align: center;">
Log in to your account
</p>




</div><!-- box-header Ends -->

<form action="checkout.php" method="post" ><!--form Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label>Email</label>

<input type="text" class="form-control" name="c_email" required >

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label>Password</label>

<input type="password" class="form-control" name="c_pass" required >

<h4 align="center">

<a href="forgot_pass.php"> Forgot Password </a>

</h4>

</div><!-- form-group Ends -->
<!-- reCAPTCHA -->
<div class="form-group">
                        <center>
                            <label>Captcha Verification</label> 
                            <div class="g-recaptcha" data-sitekey="6LcP-KQpAAAAADdKwqSGNXeOTZ5cxtwgf1sYmWwo"></div>
                        </center>
                    </div>

<div class="text-center" ><!-- text-center Starts -->

<button name="login" value="Login" class="btn btn-primary" >

<i class="fa fa-sign-in" ></i> Log in


</button>

</div><!-- text-center Ends -->


</form><!--form Ends -->

<center><!-- center Starts -->

<a href="customer_register.php" >

<h3>New ? Register Here</h3>

</a>


</center><!-- center Ends -->


</div><!-- box Ends -->

<?php
// Your secret key for reCAPTCHA
$secretKey = "6LcP-KQpAAAAABMNsLu7nNQtbZLtasaftteKogMz";

if(isset($_POST['register'])){
    // Verify reCAPTCHA response
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $response,
        'remoteip' => $remoteip
    ];
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultJson = json_decode($result);
    
    if($resultJson->success) {
        // Captcha verification passed, continue with form submission
        
        // Retrieve form data
        $c_name = $_POST['c_name'];
        $c_email = $_POST['c_email'];
        // Add more fields as needed
        
        // Insert data into database
        $insert_customer = "INSERT INTO customers (customer_name, customer_email) VALUES ('$c_name', '$c_email')";
        $run_customer = mysqli_query($con, $insert_customer);
        
        if($run_customer) {
          // Insertion successful, log in the user
          $_SESSION['customer_email'] = $c_email;
          echo "<script>alert('Registration successful.')</script>";
          echo "<script>window.open('index.php','_self')</script>"; // Redirect to home page or dashboard
      } else {
            // Insertion failed
            echo "<script>alert('Registration failed. Please try again.')</script>";
        }
    } else {
        // Captcha verification failed, handle the error
        echo "<script>alert('Please complete the Captcha verification.')</script>";
    }
}
if(isset($_POST['login'])){

$customer_email = $_POST['c_email'];

$customer_pass = $_POST['c_pass'];

$select_customer = "select * from customers where customer_email='$customer_email' AND customer_pass='$customer_pass'";

$run_customer = mysqli_query($con,$select_customer);

$get_ip = getRealUserIp();

$check_customer = mysqli_num_rows($run_customer);

$select_cart = "select * from cart where ip_add='$get_ip'";

$run_cart = mysqli_query($con,$select_cart);

$check_cart = mysqli_num_rows($run_cart);

if($check_customer==0){

echo "<script>alert('password or email is wrong')</script>";

exit();

}

if($check_customer==1 AND $check_cart==0){

$_SESSION['customer_email']=$customer_email;

echo "<script>alert('You are Logged In')</script>";

echo "<script>window.open('customer/my_account.php?my_orders','_self')</script>";

}
else {

$_SESSION['customer_email']=$customer_email;

echo "<script>alert('You are Logged In')</script>";

echo "<script>window.open('checkout.php','_self')</script>";

} 


}


?>

