<?php

include '../models/cart_model.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .heading {
         min-height: 30vh;
         display: flex;
         flex-flow: column;
         align-items: center;
         justify-content: center;
         gap: 1rem;
         background: url('images/header-priorities.jpg');
         background-size: cover;
         background-position: center;
         text-align: center;
      }
   </style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>

<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">
   <?php
      $grand_total = 0;

      try {
          // Prepare and execute the query to select all items from the cart for the current user
          $stmt = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
          $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $stmt->execute();

          // Check if there are any items in the cart
          if ($stmt->rowCount() > 0) {
              while ($fetch_cart = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  // Calculate the sub-total for each item
                  $sub_total = $fetch_cart['quantity'] * $fetch_cart['price'];
                  $grand_total += $sub_total;
                  ?>
                  <div class="box">
                     <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                     <img src="images/<?php echo $fetch_cart['image']; ?>" alt="">
                     <div class="name"><?php echo $fetch_cart['name']; ?></div>
                     <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
                     <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                        <input type="submit" name="update_cart" value="update" class="option-btn">
                     </form>
                     <div class="sub-total"> sub total : <span>$<?php echo $sub_total; ?>/-</span> </div>
                  </div>
                  <?php
              }
          } else {
              echo '<p class="empty">your cart is empty</p>';
          }
      } catch (PDOException $e) {
          echo 'Error: ' . $e->getMessage();
      }
   ?>
</div>


   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>

</body>
</html>