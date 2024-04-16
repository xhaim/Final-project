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
  <!-- Cover -->
  <main>
    <div class="hero">
      <a href="shop.php" class="btn1">View all products
</a>
    </div>
    <!-- Main -->
    <div class="wrapper">
            <h1>Featured Collection<h1>
            
      </div>



    <div id="content" class="container"><!-- container Starts -->

    <div class="row"><!-- row Starts -->

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
                        <a href="javascript:void(0);" class="btn btn-primary add-to-cart" data-pro-id="<?= $pro_id ?>" data-pro-price="<?= $pro_price ?>">
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

    <?php getPro(); ?>



    </div><!-- row Ends -->

    </div><!-- container Ends -->
    <!-- FOOTER -->
    <footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4" >
        <h5>About Us</h5>
        <p>VeSerAnCa is a swimwear store founded by Vea, Sergio, Angelina, and Carla - friends with a passion for fashion and beach life. Our store offers a wide range of stylish and comfortable swimwear to make your beach days even more enjoyable.</p>
        <p class="about"><strong>"Dive into Style with VeSerAnCa"</strong> </p>
      </div>
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <p>Email: veseranca@gmail.com</p>
        <p>Phone: 123-456-7890</p>
        <h5>Follow Us</h5>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Facebook</a></li>
          <li class="list-inline-item"><a href="#">Twitter</a></li>
          <li class="list-inline-item"><a href="#">Instagram</a></li>
        </ul>
      </div>
      <div class="col-md-4">
      <h2>Subscribe to Our Newsletter</h2>
          <form>
            <div class="form-group">
              <input type="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <button type="submit" class="btn btn-primary">Subscribe</button>
          </form>
      </div>
    </div>
  </div>

      <div class="page-footer__subline">
        <div class="container clearfix">

          <div class="copyright">
            &copy; <?php echo date("Y");?> VeSerAnCa&trade;
          </div>

          

        </div>
      </div>
    </footer>
</body>

</html>
