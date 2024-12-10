<?php
require_once "../controllers/CartController.php";

$cartController = new CartController();
$orders = $cartController->getConfirmedCart();
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


<!-- show products  -->

<section class="show-products">
    <br>
    <div
    style="display: flex; align-items: center; justify-content: center"
    >
        <h1 style="font-size: 24px;">Orders List :</h1>
    </div>
    <br>
    <div class="box-container">
        <?php if ($orders) {
                foreach ($orders as $order) {
                    ?>
                    <div class="box">
                        <div class="name"><strong>#<?php echo $order['id_cart']; ?></strong></div>
                        <div class="name"><?php echo $order['date_cart']; ?></div>
                        <div class="price"><?php echo $order['total']; ?> TND</div>
                        <div class="price"><?php echo $order['name']; ?> - <?php echo $order['numtel']; ?></div>
                        <a href="order_details.php?id_cart=<?php echo $order['id_cart']; ?>" class="option-btn">details</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no orders added yet!</p>';
            }
        ?>
    </div>

</section>

<!-- custom admin js file link  -->
<script src="../controllers/js/admin_script.js"></script>
<script src="JS/addProduct.js"></script>
<script src="JS/updateProduct.js"></script>
</body>
</html>