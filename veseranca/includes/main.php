

<link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest"> 
</head>

<body>

  <header class="page-header">
    <!-- topline -->
    <div class="page-header__topline">
      <div class="container clearfix">

        <div class="currency">
          <a class="currency__change" href="customer/my_account.php?my_orders">
          <?php
          if(!isset($_SESSION['customer_email'])){
          echo "Welcome :Guest"; 
          }
          else
          { 
              echo "Welcome : " . $_SESSION['customer_email'] . "";
            }
?>
          </a>
        </div>

        <div class="basket">
          <a href="cart.php" class="btn btn--basket">
            <i class="icon-basket"></i>
            <?php items(); ?> items
          </a>
        </div>
        
        
        <ul class="login">

      <li class="login__item">
      <?php
      if(!isset($_SESSION['customer_email'])){
        echo '<a href="customer_register.php" class="login__link">Register</a>';
      } 
        else
        { 
            echo '<a href="customer/my_account.php?my_orders" class="login__link">My Account</a>';
        }   
      ?>  
      </li>


      <li class="login__item">
      <?php
      if(!isset($_SESSION['customer_email'])){
        echo '<a href="checkout.php" class="login__link">Log in</a>';
      } 
        else
        { 
            echo '<a href="./logout.php" class="login__link">Logout</a>';
        }   
      ?>  
        
      </li>
      </ul>
      
      </div>
    </div>
    <!-- bottomline -->
    <div class="page-header__bottomline">
      <div class="container clearfix">

        <div class="logo">
          <a class="logo__link" href="index.php">
            <img class="logo__img" src="images/logo.png" alt="Avenue fashion logotype" width="237" height="19">
          </a>
        </div>

        <nav class="main-nav">
    <ul class="categories">
        
        <li class="categories__item">
            <a class="categories__link categories__link--active" href="index.php">Home</a>
        </li>
        <li class="categories__item">
            <a class="categories__link " href="shop.php">Shop</a>
        </li>
    </ul> 
</nav>


      </div>
    </div>
    <style>
      .categories {
    display: flex;
    align-items: center;
}

.categories__item {
    list-style: none;
    margin-right: 10px;
}

.input-group {
    margin: 0;
}

.input-group-btn {
    padding: 0;
    
}
#btn-search{
  height: 5px;
}
      </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </header>