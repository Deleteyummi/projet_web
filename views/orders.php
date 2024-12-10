<?php
include '../controllers/CartController.php';

$user_id = 1; // à changer pendant l intégration
$cartController = new CartController();
$carts = $cartController->showAllCartsByUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

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
   <h3>your orders</h3>
   <p> <a href="home.php">home</a> / orders </p>
</div>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
         if($carts){
             foreach($carts as $cart){
      ?>
      <div class="box">
         <p> placed on : <span><?php echo $cart['date_cart']; ?></span> </p>
         <p> #ID : <span><?php echo $cart['id_cart']; ?></span> </p>
         <p> total price : <span><?php echo $cart['total']; ?> TND /-</span> </p>
         </div>
      <?php
                }
         }
      ?>
   </div>

</section>
<?php include 'footer.php'; ?>


<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>

</body>
</html>