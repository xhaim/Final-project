<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CRoboto" rel="stylesheet">
  <meta http-equiv="x-ua-compatible" content="IE=edge, chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest"> 
  <title>VeSerAnCa</title>
  <link href="styles/bootstrap.min.css" rel="stylesheet">
  <link href="styles/backend.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">

  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!--Bootstrap-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!--JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Function to update Customer Address based on selected inputs
            function updateCustomerAddress() {
                var region = $('#region option:selected').text();
                var province = $('#province option:selected').text();
                var city = $('#city option:selected').text();
                var barangay = $('#barangay option:selected').text();
                var street = $('#street-text').val();
                
                // Concatenate address parts
                var address = street + ', ' + barangay + ', ' + city + ', ' + province + ', ' + region;
                
                // Update the value of the Customer Address input field
                $('input[name="c_address"]').val(address);
            }
            
            // Call the function to update the Customer Address whenever a selection is changed
            $('#region, #province, #city, #barangay, #street-text').on('change keyup', function() {
                updateCustomerAddress();
            });
        });
    </script>
    <script src="ph-address-selector.js"></script>
    <script>
var timeoutInMinutes = 5; // Set the timeout duration in minutes
var timeoutId;

function startLogoutTimer() {
    clearTimeout(timeoutId); // Clear any existing timeout
    timeoutId = setTimeout(logout, timeoutInMinutes * 60 * 1000); // Convert minutes to milliseconds
}

function logout() {
    // Perform logout action here, such as redirecting to logout page
    window.location.href = 'logout.php';
}

// Start the timer when the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if the user is logged in (you need to replace '<?= $_SESSION['customer_email'] ?? '' ?>' with your actual server-side session variable)
    var isLoggedIn = '<?= isset($_SESSION['customer_email']) ? 'true' : 'false' ?>';
    if (isLoggedIn === 'true') {
        startLogoutTimer();
    }
});

// Reset the timer on user activity
document.addEventListener('mousemove', function() {
    startLogoutTimer();
});
document.addEventListener('keypress', function() {
    startLogoutTimer();
});
</script>
