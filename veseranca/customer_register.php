<?php
session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

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
        $c_pass = $_POST['c_pass'];

        $region_text = $_POST['region_text'];

        $province_text = $_POST['province_text'];

        $city_text = $_POST['city_text'];

        $barangay_text = $_POST['barangay_text'];

        $street_text = $_POST['street_text'];

        $c_contact = $_POST['c_contact'];

        $c_address = $_POST['c_address'];

        $c_image = $_FILES['c_image']['name'];

        $c_image_tmp = $_FILES['c_image']['tmp_name'];

        $c_ip = getRealUserIp();

        move_uploaded_file($c_image_tmp,"customer/customer_images/$c_image");
        // Add more fields as needed
        
        // Insert data into database
        
          $insert_customer = "insert into customers (customer_name,
          customer_email,
          customer_pass,
          customer_region,
          customer_province,
          customer_city,
          customer_barangay,
          customer_street,
          customer_contact,
          customer_address,
          customer_image,
          customer_ip,
          customer_confirm_code) values
          ('$c_name',
          '$c_email',
          '$c_pass',
          '$region_text',
          '$province_text',
          '$city_text',
          '$barangay_text',
          '$street_text',
          '$c_contact',
          '$c_address',
          '$c_image',
          '$c_ip',
          '$customer_confirm_code')";

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

?>

  <!-- MAIN -->
  <main>
    <!-- HERO -->
    <div class="nero">
      <div class="nero__heading">
        <span class="nero__bold">Register</span>
      </div>
      <p class="nero__text">
      </p>
    </div>
  </main>

  <div id="content"><!-- content Starts -->
  <div class="container"><!-- container Starts -->
    <div class="col-md-12"><!-- col-md-12 Starts -->
      <div class="box"><!-- box Starts -->
        <div class="box-header"><!-- box-header Starts -->
          <center><!-- center Starts -->
            <h2>Register A New Account</h2>
          </center><!-- center Ends -->
        </div><!-- box-header Ends -->
        <form action="customer_register.php" method="post" enctype="multipart/form-data"><!-- form Starts -->
          <div class="form-group"><!-- form-group Starts -->
            <label>Customer Name</label>
            <input type="text" class="form-control" name="c_name" required>
          </div><!-- form-group Ends -->

        <div class="form-group"><!-- form-group Starts -->

        <label> Customer Email</label>

        <input type="text" class="form-control" name="c_email" required>

        </div><!-- form-group Ends -->

        <div class="form-group"><!-- form-group Starts -->

        <label> Customer Password </label>

        <div class="input-group"><!-- input-group Starts -->

        <span class="input-group-addon"><!-- input-group-addon Starts -->

        <i class="fa fa-check tick1"> </i>

        <i class="fa fa-times cross1"> </i>

        </span><!-- input-group-addon Ends -->

        <input type="password" class="form-control" id="pass" name="c_pass" required>

        <span class="input-group-addon"><!-- input-group-addon Starts -->

        <div id="meter_wrapper"><!-- meter_wrapper Starts -->

        <span id="pass_type"> </span>

        <div id="meter"> </div>
        </div><!-- meter_wrapper Ends -->

        </span><!-- input-group-addon Ends -->

        </div><!-- input-group Ends -->

        </div><!-- form-group Ends -->

        <div class="form-group"><!-- form-group Starts -->

        <label> Confirm Password </label>

        <div class="input-group"><!-- input-group Starts -->

        <span class="input-group-addon"><!-- input-group-addon Starts -->

        <i class="fa fa-check tick2"> </i>

        <i class="fa fa-times cross2"> </i>

        </span><!-- input-group-addon Ends -->

        <input type="password" class="form-control confirm" id="con_pass" required>

        </div><!-- input-group Ends -->

        </div><!-- form-group Ends -->

        <div class="col-sm-6 mb-3">
            <label class="form-label">Region *</label>
            <select name="region" class="form-control form-control-md" id="region"></select>
            <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Province *</label>
            <select name="province" class="form-control form-control-md" id="province"></select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">City / Municipality *</label>
            <select name="city" class="form-control form-control-md" id="city"></select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Barangay *</label>
            <select name="barangay" class="form-control form-control-md" id="barangay"></select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="street-text" class="form-label">Street (Optional)</label>
            <input type="text" class="form-control form-control-md" name="street_text" id="street-text">
        </div>
        <div class="col-md-6 mb-3">

        <label> Customer Contact </label>

        <input type="number" class="form-control" name="c_contact" required>
        </div>
   
      <div class="form-group"><!-- form-group Starts -->

      <label> Customer Address </label>

      <input type="text" class="form-control" name="c_address" required>

      </div><!-- form-group Ends -->

      <div class="form-group"><!-- form-group Starts -->

      <label> Customer Image </label>

      <input type="file" class="form-control" name="c_image" required>

      </div><!-- form-group Ends -->


            <div class="form-group">
                        <center>
                            <label>Captcha Verification</label> 
                            <div class="g-recaptcha" data-sitekey="6LcP-KQpAAAAADdKwqSGNXeOTZ5cxtwgf1sYmWwo"></div>
                        </center>
                    </div>

                    <div class="text-center"><!-- text-center Starts -->
            <button type="submit" name="register" class="btn btn-primary">
              <i class="fa fa-user-md"></i> Register
            </button>
          </div><!-- text-center Ends -->
        </form><!-- form Ends -->
      </div><!-- box Ends -->
    </div><!-- col-md-12 Ends -->
  </div><!-- container Ends -->
</div><!-- content Ends -->


<?php

include("includes/footer.php");

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

<script>

$(document).ready(function(){

$('.tick1').hide();
$('.cross1').hide();

$('.tick2').hide();
$('.cross2').hide();


$('.confirm').focusout(function(){

var password = $('#pass').val();

var confirmPassword = $('#con_pass').val();

if(password == confirmPassword){

$('.tick1').show();
$('.cross1').hide();

$('.tick2').show();
$('.cross2').hide();



}
else{

$('.tick1').hide();
$('.cross1').show();

$('.tick2').hide();
$('.cross2').show();


}


});


});

</script>

<script>

$(document).ready(function(){

$("#pass").keyup(function(){

check_pass();

});

});

function check_pass() {
 var val=document.getElementById("pass").value;
 var meter=document.getElementById("meter");
 var no=0;
 if(val!="")
 {
// If the password length is less than or equal to 6
if(val.length<=6)no=1;

 // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
  if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;

  // If the password length is greater than 6 and contain alphabet,number,special character respectively
  if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;

  // If the password length is greater than 6 and must contain alphabets,numbers and special characters
  if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;

  if(no==1)
  {
   $("#meter").animate({width:'50px'},300);
   meter.style.backgroundColor="red";
   document.getElementById("pass_type").innerHTML="Very Weak";
  }

  if(no==2)
  {
   $("#meter").animate({width:'100px'},300);
   meter.style.backgroundColor="#F5BCA9";
   document.getElementById("pass_type").innerHTML="Weak";
  }

  if(no==3)
  {
   $("#meter").animate({width:'150px'},300);
   meter.style.backgroundColor="#FF8000";
   document.getElementById("pass_type").innerHTML="Good";
  }

  if(no==4)
  {
   $("#meter").animate({width:'200px'},300);
   meter.style.backgroundColor="#00FF40";
   document.getElementById("pass_type").innerHTML="Strong";
  }
 }

 else
 {
  meter.style.backgroundColor="";
  document.getElementById("pass_type").innerHTML="";
 }
}

</script>

</body>

</html>

<?php

if(isset($_POST['register'])){

 $secret = "6LcHnoQaAAAAAF3_pqQ55sZMDgaWCGcXq4ucLgkH";

 $response = $_POST['g-recaptcha-response'];

$remoteip = $_SERVER['REMOTE_ADDR'];

 $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");

 $result = json_decode($url, TRUE);

if($result['success'] == 0){

$c_name = $_POST['c_name'];

$c_email = $_POST['c_email'];

$c_pass = $_POST['c_pass'];

$region_text = $_POST['region_text'];

$province_text = $_POST['province_text'];

$city_text = $_POST['city_text'];

$barangay_text = $_POST['barangay_text'];

$street_text = $_POST['street_text'];

$c_contact = $_POST['c_contact'];

$c_address = $_POST['c_address'];

$c_image = $_FILES['c_image']['name'];

$c_image_tmp = $_FILES['c_image']['tmp_name'];

$c_ip = getRealUserIp();

move_uploaded_file($c_image_tmp,"customer/customer_images/$c_image");

$get_email = "select * from customers where customer_email='$c_email'";

$run_email = mysqli_query($con,$get_email);

$check_email = mysqli_num_rows($run_email);

if($check_email == 1){

echo "<script>alert('This email is already registered, try another one')</script>";

exit();

}

$customer_confirm_code = mt_rand();

$subject = "Email Confirmation Message";

$from = "sad.ahmed22224@gmail.com";

$message = "

<h2>
Email Confirmation $c_name
</h2>

<a href='localhost/ecom_store/customer/my_account.php?$customer_confirm_code'>

Click Here To Confirm Email

</a>

";

$headers = "From: $from \r\n";

$headers .= "Content-type: text/html\r\n";

mail($c_email,$subject,$message,$headers);


$insert_customer = "insert into customers (customer_name,
                                          customer_email,
                                          customer_pass,
                                          customer_region,
                                          customer_province,
                                          customer_city,
                                          customer_barangay,
                                          customer_street,
                                          customer_contact,
                                          customer_address,
                                          customer_image,
                                          customer_ip,
                                          customer_confirm_code) values
                                           ('$c_name',
                                           '$c_email',
                                           '$c_pass',
                                           '$region_text',
                                           '$province_text',
                                           '$city_text',
                                           '$barangay_text',
                                           '$street_text',
                                           '$c_contact',
                                           '$c_address',
                                           '$c_image',
                                           '$c_ip',
                                           '$customer_confirm_code')";


$run_customer = mysqli_query($con,$insert_customer);
$sel_cart = "select * from cart where ip_add='$c_ip'";

$run_cart = mysqli_query($con,$sel_cart);

$check_cart = mysqli_num_rows($run_cart);

if($check_cart>0){

$_SESSION['customer_email']=$c_email;

echo "<script>alert('You have been Registered Successfully')</script>";

echo "<script>window.open('checkout.php','_self')</script>";

}else{

$_SESSION['customer_email']=$c_email;

echo "<script>alert('You have been Registered Successfully')</script>";

echo "<script>window.open('index.php','_self')</script>";


}


}
else{

echo "<script>alert('Please Select Captcha, Try Again')</script>";

}


}

?>
