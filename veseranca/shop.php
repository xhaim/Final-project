<?php

session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

?>
<?php
$query = "SELECT * FROM products";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $search = mysqli_real_escape_string($con, $search); // Prevent SQL injection
    $search = strtolower($search); // Convert search term to lowercase
    $query .= " WHERE LOWER(product_keywords) LIKE '%$search%'";
}

$result = mysqli_query($con, $query);
?>

<!-- start of search form -->
<style>
    .hidden {
        display: none;
    }
    #search-form {
        text-align: right;
    }
</style>

<form class="form-inline" >
    <div id="search-form">
    <div class="form-group">
        <input type="text" class="form-control hidden" id="searchInput" placeholder="Search products..." name="search">
    </div>
    <button class="btn btn-default" id="searchButton" type="button"><i class="glyphicon glyphicon-search"></i> </button>
    </div>
</form>

<script>
    // JavaScript to show input field when button is clicked
    document.getElementById("searchButton").addEventListener("click", function() {
        var inputField = document.getElementById("searchInput");
        inputField.classList.toggle("hidden");
        if (!inputField.classList.contains("hidden")) {
            inputField.focus();
        }
    });
</script>
<!-- end of search form -->




  <!-- MAIN -->
  <main>
    <!-- HERO -->
    <div class="nero">
      <div class="nero__heading">
        <span class="nero__bold">shop</span>
      </div>
      <p class="nero__text">
      </p>
    </div>
  </main>


<div id="content" ><!-- content Starts -->
<div class="container" ><!-- container Starts -->





<div class="col-md-10" ><!-- col-md-12 Starts --->
<!-- start of search code -->
<?php if(isset($_GET['search']) && mysqli_num_rows($result) > 0): ?>
<div class="row">
    <?php while ($row = mysqli_fetch_array($result)): ?>
        <?php
        $pro_id = $row['product_id'];
        $pro_title = $row['product_title'];
        $pro_price = $row['product_price'];
        $pro_img1 = $row['product_img1'];
        ?>
        <div class="col-md-4 col-sm-6 single">
            <div class="product">
                <a href="details.php?pro_id=<?= $pro_id ?>">
                    <img src="admin_area/product_images/<?= $pro_img1 ?>" class="img-responsive">
                </a>
                <div class="text">
                    <h3><a href="details.php?pro_id=<?= $pro_id ?>"><?= $pro_title ?></a></h3>
                    <p class="price">₱ <?= $pro_price ?></p>
                    <p class="buttons">
                        <a href="details.php?pro_id=<?= $pro_id ?>" class="btn btn-default">View details</a>
                        <a href="details.php?pro_id=<?= $pro_id ?>" class="btn btn-primary">
                            <i class="fa fa-shopping-cart"></i> Add to cart
                        </a> 
                    </p>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php elseif(isset($_GET['search'])): ?>
<div class="row">
    <div class="col-md-12">
        <p>No products found</p>
    </div>
</div>
<?php endif; ?>
<!-- end of search -->

    <?php getProducts(); ?>



</div><!-- row Ends -->

<center><!-- center Starts -->

<ul class="pagination" ><!-- pagination Starts -->

<?php getPaginator(); ?>

</ul><!-- pagination Ends -->

</center><!-- center Ends -->



</div><!-- col-md-9 Ends --->



</div><!--- wait Ends -->

</div><!-- container Ends -->
</div><!-- content Ends -->



<?php

include("includes/footer.php");

?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

<script>

$(document).ready(function(){

/// Hide And Show Code Starts ///

$('.nav-toggle').click(function(){

$(".panel-collapse,.collapse-data").slideToggle(700,function(){

if($(this).css('display')=='none'){

$(".hide-show").html('Show');

}
else{

$(".hide-show").html('Hide');

}

});

});

/// Hide And Show Code Ends ///

/// Search Filters code Starts ///

$(function(){

$.fn.extend({

filterTable: function(){

return this.each(function(){

$(this).on('keyup', function(){

var $this = $(this),

search = $this.val().toLowerCase(),

target = $this.attr('data-filters'),

handle = $(target),

rows = handle.find('li a');

if(search == '') {

rows.show();

} else {

rows.each(function(){

var $this = $(this);

$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();

});

}

});

});

}

});

$('[data-action="filter"][id="dev-table-filter"]').filterTable();

});

/// Search Filters code Ends ///

});



</script>


<script>


$(document).ready(function(){

  // getProducts Function Code Starts

  function getProducts(){

  // Manufacturers Code Starts

    var sPath = '';

var aInputs = $('li').find('.get_manufacturer');

var aKeys = Array();

var aValues = Array();

iKey = 0;

$.each(aInputs,function(key,oInput){

if(oInput.checked){

aKeys[iKey] =  oInput.value

};

iKey++;

});

if(aKeys.length>0){

var sPath = '';

for(var i = 0; i < aKeys.length; i++){

sPath = sPath + 'man[]=' + aKeys[i]+'&';

}

}

// Manufacturers Code ENDS

// Products Categories Code Starts

var aInputs = Array();

var aInputs = $('li').find('.get_p_cat');

var aKeys = Array();

var aValues = Array();

iKey = 0;

$.each(aInputs,function(key,oInput){

if(oInput.checked){

aKeys[iKey] =  oInput.value

};

iKey++;

});

if(aKeys.length>0){

for(var i = 0; i < aKeys.length; i++){

sPath = sPath + 'p_cat[]=' + aKeys[i]+'&';

}

}

// Products Categories Code ENDS

   // Categories Code Starts

var aInputs = Array();

var aInputs = $('li').find('.get_cat');

var aKeys  = Array();

var aValues = Array();

iKey = 0;

    $.each(aInputs,function(key,oInput){

    if(oInput.checked){

    aKeys[iKey] =  oInput.value

};

    iKey++;

});

if(aKeys.length>0){

    for(var i = 0; i < aKeys.length; i++){

    sPath = sPath + 'cat[]=' + aKeys[i]+'&';

}

}

   // Categories Code ENDS

   // Loader Code Starts

$('#wait').html('<img src="images/load.gif">');

// Loader Code ENDS

// ajax Code Starts

$.ajax({

url:"load.php",

method:"POST",

data: sPath+'sAction=getProducts',

success:function(data){

 $('#Products').html('');

 $('#Products').html(data);

 $("#wait").empty();

}

});

    $.ajax({
url:"load.php",
method:"POST",
data: sPath+'sAction=getPaginator',
success:function(data){
$('.pagination').html('');
$('.pagination').html(data);
}

    });

// ajax Code Ends

   }

   // getProducts Function Code Ends

$('.get_manufacturer').click(function(){

getProducts();

});


  $('.get_p_cat').click(function(){

getProducts();

});

$('.get_cat').click(function(){

getProducts();

});


 });

</script>

</body>

</html>
