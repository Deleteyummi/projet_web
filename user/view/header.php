<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>


<header class="header">

<div class="header-1">
   <div class="flex">
      <div class="share">
      <a href="home.php" class="logo">CultureHub <i class="fa-solid fa-globe"></i></a>
      </div>
      <p> new <a href="login.php">login</a> | <a href="register.php">register</a> </p>
   </div>
</div>

<div class="header-2" >
   <div class="flex" >
     
   <div aling="center"></div>
      <nav class="navbar" >
         <a href="home.php">home</a>
         <a href="about.php">about</a>
         <a href="shop.php">shop</a>
         <a href="orders.php">orders</a>
      </nav>

      <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
            try {
               // Prepare the query to select all items from the cart for the current user
               $stmt = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
               $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
               $stmt->execute();

               // Get the number of rows returned by the query
               $cart_rows_number = $stmt->rowCount();
            } catch (PDOException $e) {
               echo 'Error: ' . $e->getMessage();
            }
         ?>

            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>
      
      <div class="user-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
      </div>
   </div>
</div>

</header>


