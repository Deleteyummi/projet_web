<?php

include '../config.php';

session_start();

$user_id = $_SESSION['user_id'];

// Redirect to login if user is not logged in
if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];

   try {
       $stmt = $conn->prepare("UPDATE `cart` SET quantity = :quantity WHERE id = :id");
       $stmt->bindParam(':quantity', $cart_quantity, PDO::PARAM_INT);
       $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
       $stmt->execute();
       $message[] = 'Cart quantity updated!';
   } catch (PDOException $e) {
       die('Query failed: ' . $e->getMessage());
   }
}

// Delete single item from cart
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   try {
       $stmt = $conn->prepare("DELETE FROM `cart` WHERE id = :id");
       $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
       $stmt->execute();
       header('location:cart.php');
       exit();
   } catch (PDOException $e) {
       die('Query failed: ' . $e->getMessage());
   }
}

// Delete all items from cart for the current user
if (isset($_GET['delete_all'])) {
   try {
       $stmt = $conn->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
       $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
       $stmt->execute();
       header('location:cart.php');
       exit();
   } catch (PDOException $e) {
       die('Query failed: ' . $e->getMessage());
   }
}

?>
