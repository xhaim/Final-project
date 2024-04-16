<?php
$con = mysqli_connect("localhost", "root", "", "ecom_store");

$query = "SELECT * FROM products";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $search = mysqli_real_escape_string($con, $search); // Prevent SQL injection
    $search = strtolower($search); // Convert search term to lowercase
    $query .= " WHERE LOWER(product_keywords) LIKE '%$search%'";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Product Search</h2>
    <div class="row">
        <div class="col-md-12">
        <form method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search products..." name="search">
                    <div id="btn-search"  class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
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
</div>

</body>
</html>
