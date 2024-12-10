<?php
require_once "../controllers/CartController.php";
require_once "../controllers/ProductsController.php";
require_once "../controllers/CartProductsController.php";
require_once "send_invoice.php";

$cartController = new CartController();
$productsController = new ProductsController();
$cartProductsController = new CartProductsController();

$user = 1;
$carts = $cartController->joinCartCartProductsByUser($user);
if(isset($_GET['delete']) && isset($_GET['id_cart']) && isset($_GET['id_product'])){
    $id_cart = $_GET['id_cart'];
    $product_id = $_GET['id_product'];
    $cart = $cartController->getCart($id_cart);
    $cp = $cartProductsController->getOneCartProduct($id_cart, $product_id);
    $nbr = $cartController->countOrderActive($user);
    $product = $productsController->getProduct($product_id);
    if($nbr > 1){
        $updatedPrice = $cart['total'] - ( $cp['quantite'] * $product['price']);
        $cartController->updateTotal($updatedPrice, $id_cart);
        $cartProductsController->deleteCartProduct($id_cart, $product_id);
        header("Location: cart.php");
    } else {
        $cartController->deleteCart($id_cart);
        header("Location: shop.php");
    }
}

if(isset($_POST['cart_id']) && isset($_POST['product_id']) && isset($_POST['cart_quantity'])) {
    $product_id = $_POST['product_id'];
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $cp = $cartProductsController->getOneCartProduct($cart_id, $product_id);
    $cart = $cartController->getCart($cart_id);
    $product = $productsController->getProduct($product_id);
    $initPrice = $cart['total'] - ( $cp['quantite'] * $product['price']);
    $updatedPrice = $initPrice + ($cart_quantity * $product['price']);
    $cartController->updateTotal($updatedPrice, $cart_id);
    $cartProductsController->updateQuantite($cart_quantity, $cart_id, $product_id);
    header("Location: cart.php");
}

if(isset($_GET['confirm']) && isset($_GET['id_cart'])){
    send_invoice($_GET['id_cart']);
}
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
          if ($carts) {
              foreach ($carts as $cart) {
                  $product = $productsController->getProduct($cart['id_product']);
                  ?>
                  <div class="box">
                     <a href="cart.php?delete=1&id_cart=<?php echo $cart['id_cart']; ?>&id_product=<?php echo $product['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                     <img src="images/<?php echo $product['image']; ?>" alt="">
                     <div class="name"><?php echo $product['name']; ?></div>
                     <div class="price">TND<?php echo $product['price']; ?>/-</div>
                     <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $cart['id_cart']; ?>">
                         <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" required min="1" name="cart_quantity" value="<?php echo $cart['quantite']; ?>">
                        <input type="submit" name="update_cart" value="update" class="option-btn">
                     </form>
                     <div class="sub-total"> sub total : <span>$<?php echo $product['price'] * $cart['quantite']; ?>/-</span> </div>
                  </div>
                  <?php
              }
          } else {
              echo '<p class="empty">your cart is empty</p>';
          }
   ?>
</div>



   <div class="cart-total">
       <?php if ($carts) { ?>
      <p>grand total : <span>TND<?php echo $cart['total']; ?>/-</span></p>
       <?php }?>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
          <?php if($carts){ ?>
         <a href="cart.php?id_cart=<?php echo $carts[0]['id_cart']; ?>&confirm=1" class="btn">confirm order</a>
          <?php }?>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>

</body>
</html>