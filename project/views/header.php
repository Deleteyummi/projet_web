<?php
require_once "../controllers/CartController.php";

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
$user = 1; // à modifier pendant l intégration
$cartController = new CartController();
$nbrCart = $cartController->countOrderActive($user)
?>


<header class="header">

<div class="header-1">
   <div class="flex">
      <div class="share">
      <a href="#" class="logo">CultureHub <i class="fa-solid fa-globe"></i></a>
      </div>
      <p> new <a href="#">login</a> | <a href="#">register</a> </p>
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

         ?>

            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $nbrCart; ?>)</span> </a>
         </div>
      
      <div class="user-box">
            <p>username : <span>Koussay</span></p>
            <p>email : <span>koussay@esprit.tn</span></p>
            <a href="#" class="delete-btn">logout</a>
      </div>
   </div>
</div>

</header>


