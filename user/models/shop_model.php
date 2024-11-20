<?php

include '../config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Prepare the query to check if the product is already in the cart
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = :name AND user_id = :user_id");
   $check_cart_numbers->bindParam(':name', $product_name, PDO::PARAM_STR);
   $check_cart_numbers->bindParam(':user_id', $user_id, PDO::PARAM_INT);
   $check_cart_numbers->execute();

   if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {
      // Prepare the query to insert a new product into the cart
      $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, name, price, quantity, image) VALUES (:user_id, :name, :price, :quantity, :image)");
      $insert_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $insert_cart->bindParam(':name', $product_name, PDO::PARAM_STR);
      $insert_cart->bindParam(':price', $product_price, PDO::PARAM_STR);
      $insert_cart->bindParam(':quantity', $product_quantity, PDO::PARAM_INT);
      $insert_cart->bindParam(':image', $product_image, PDO::PARAM_STR);
      $insert_cart->execute();

      $message[] = 'product added to cart!';
   }
}
?>