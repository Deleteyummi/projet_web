<?php

include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit;
}

if(isset($_POST['add_product'])) {

   // Sanitize inputs
   $name = htmlspecialchars($_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'images/' . $image;

   // Check if product name already exists
   $select_product_name = $conn->prepare("SELECT name FROM products WHERE name = :name");
   $select_product_name->bindParam(':name', $name);
   $select_product_name->execute();

   if ($select_product_name->rowCount() > 0) {
      $message[] = 'Product name already added';
   } else {
      // Insert new product
      $add_product_query = $conn->prepare("INSERT INTO products (name, price, image) VALUES (:name, :price, :image)");
      $add_product_query->bindParam(':name', $name);
      $add_product_query->bindParam(':price', $price);
      $add_product_query->bindParam(':image', $image);

      if ($add_product_query->execute()) {
         if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      } else {
         $message[] = 'Product could not be added!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = $conn->prepare("SELECT image FROM products WHERE id = :id");
   $delete_image_query->bindParam(':id', $delete_id);
   $delete_image_query->execute();
   $fetch_delete_image = $delete_image_query->fetch(PDO::FETCH_ASSOC);

   if ($fetch_delete_image) {
      unlink('uploaded_img/' . $fetch_delete_image['image']);
   }

   $delete_product = $conn->prepare("DELETE FROM products WHERE id = :id");
   $delete_product->bindParam(':id', $delete_id);
   $delete_product->execute();

   header('location:admin_products.php');
   exit;
}

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $update_name = htmlspecialchars($_POST['update_name']);
   $update_price = $_POST['update_price'];

   // Update product name and price
   $update_query = $conn->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
   $update_query->bindParam(':name', $update_name);
   $update_query->bindParam(':price', $update_price);
   $update_query->bindParam(':id', $update_p_id);
   $update_query->execute();

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   // Update product image if a new one is uploaded
   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'Image file size is too large';
      } else {
         $update_image_query = $conn->prepare("UPDATE products SET image = :image WHERE id = :id");
         $update_image_query->bindParam(':image', $update_image);
         $update_image_query->bindParam(':id', $update_p_id);
         $update_image_query->execute();

         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/' . $update_old_image);
      }
   }

   header('location:admin_products.php');
   exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_styles.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">
   <?php
   // Prepare and execute the query
   $select_products = $conn->prepare("SELECT * FROM products");
   $select_products->execute();

   // Check if there are any products
   if($select_products->rowCount() > 0) {
      // Fetch each product as an associative array
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
?>
<div class="box">
         <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">
<?php
   if(isset($_GET['update'])){
      $update_id = $_GET['update'];
      
      // Prepare and execute the query using PDO
      $update_query = $conn->prepare("SELECT * FROM products WHERE id = :id");
      $update_query->bindParam(':id', $update_id, PDO::PARAM_INT);
      $update_query->execute();

      // Check if any results were returned
      if($update_query->rowCount() > 0) {
         while($fetch_update = $update_query->fetch(PDO::FETCH_ASSOC)) {
?>
<form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="images/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<!-- custom admin js file link  -->
<script src="../controllers/js/admin_script.js"></script>

</body>
</html>