<?php

include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
   <link rel="stylesheet" href="css/admin_styles.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>
<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $stmt_pending = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = 'pending'");
            $stmt_pending->execute();
            $result_pending = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

            foreach($result_pending as $fetch_pendings){
               $total_pendings += $fetch_pendings['total_price'];
            }
         ?>
         <h3>$<?php echo $total_pendings; ?>/-</h3>
         <p>total pendings</p>
      </div>

      <div class="box">
         <?php
            $total_completed = 0;
            $stmt_completed = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = 'completed'");
            $stmt_completed->execute();
            $result_completed = $stmt_completed->fetchAll(PDO::FETCH_ASSOC);

            foreach($result_completed as $fetch_completed){
               $total_completed += $fetch_completed['total_price'];
            }
         ?>
         <h3>$<?php echo $total_completed; ?>/-</h3>
         <p>completed payments</p>
      </div>

      <div class="box">
         <?php 
            $stmt_orders = $conn->prepare("SELECT * FROM `orders`");
            $stmt_orders->execute();
            $number_of_orders = $stmt_orders->rowCount();
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>order placed</p>
      </div>

      <div class="box">
         <?php 
            $stmt_products = $conn->prepare("SELECT * FROM `products`");
            $stmt_products->execute();
            $number_of_products = $stmt_products->rowCount();
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>products added</p>
      </div>

      <div class="box">
         <?php 
            $stmt_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = 'user'");
            $stmt_users->execute();
            $number_of_users = $stmt_users->rowCount();
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>normal users</p>
      </div>

      <div class="box">
         <?php 
            $stmt_admins = $conn->prepare("SELECT * FROM `users` WHERE user_type = 'admin'");
            $stmt_admins->execute();
            $number_of_admins = $stmt_admins->rowCount();
         ?>
         <h3><?php echo $number_of_admins; ?></h3>
         <p>admin users</p>
      </div>

      <div class="box">
         <?php 
            $stmt_accounts = $conn->prepare("SELECT * FROM `users`");
            $stmt_accounts->execute();
            $number_of_accounts = $stmt_accounts->rowCount();
         ?>
         <h3><?php echo $number_of_accounts; ?></h3>
         <p>total accounts</p>
      </div>

      <div class="box">
         <?php 
            $stmt_messages = $conn->prepare("SELECT * FROM `message`");
            $stmt_messages->execute();
            $number_of_messages = $stmt_messages->rowCount();
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>new messages</p>
      </div>

   </div>

</section>
<script src="js/admin_script.js"></script>
</body>
</html>