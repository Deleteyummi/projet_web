<?php
require_once "../controllers/ProductsController.php";
require_once "../controllers/CartController.php";
require_once "../controllers/CartProductsController.php";
require_once "../models/cartproducts.php";
require_once "../models/cart.php";

$productController = new ProductsController();
$cartController = new CartController();
$cartProductController = new CartProductsController();
$user = 1;

if (isset($_POST['product_id']) && isset($_POST['product_price']) && isset($_POST['product_quantity'])) {
    $id_cart = $cartController->getNotConfirmedCart($user);
    $quantity = $_POST['product_quantity'];
    $product_id = $_POST['product_id'];
    $product_price = $_POST['product_price'];
    if ($id_cart) {
        $cart = $cartController->getCart($id_cart);
        $cp = $cartProductController->getOneCartProduct($id_cart, $product_id);
        if ($cp) {
            $updatedPrice = $quantity * $product_price;
            $updatedQuantity = $cp['quantite'] + $quantity;
            $updatedTotal = $cart['total'] + $updatedPrice;
            $cartController->updateTotal($updatedTotal, $id_cart);
            $cartProductController->updateQuantite($updatedQuantity, $id_cart, $product_id);
            header("Location: shop.php");
        } else {
            $price = $quantity * $product_price;
            $updatedTotal = $cart['total'] + $price;
            $cartController->updateTotal($updatedTotal, $id_cart);
            $cp = new cartproducts(
                $id_cart, $product_id, $quantity
            );
            $cartProductController->addCartProduct($cp);
            header("Location: shop.php");
        }
    } else {
        $total = $quantity * $product_price;
        $cart = new Cart(
            0, $user, $total, "", "Non confirmé"
        );
        $cartController->addCart($cart);
        $id_cart = $cartController->getNotConfirmedCart($user);
        $cp = new cartproducts(
            $id_cart, $product_id, $quantity
        );
        $cartProductController->addCartProduct($cp);
        header("Location: shop.php");
    }
}

if (!isset($_POST['art']) && !isset($_POST['vetements']) && !isset($_POST['search'])) {
    $products = $productController->getProductsByCategory('Accessoire');
} else if (isset($_POST['art'])) {
    $products = $productController->getProductsByCategory('Art et Artisanat');
} else if (isset($_POST['vetements'])) {
    $products = $productController->getProductsByCategory('Vêtements');
} else if (isset($_POST['search'])) {
    $products = $productController->searchProduct($_POST['search']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>

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
        /******************************************/
        .category-box{
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 1rem !important;
            margin: 2rem !important;
        }

        .category-box button{
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            text-decoration: none !important;
            padding: 10px 20px !important;
            height: 100% !important;
            width: 100% !important;
            border: none !important;
            outline: none !important;
            border-radius: 4px !important;
            background: #c0392b !important;
            color: #fff !important;
            cursor: pointer !important;
        }
        .category-box button.active{
            background: #ff0844 !important;
        }
        .category-box button:hover{
            background: #ff0844 !important;
            transition: all 0.3s ease !important;
        }

    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>our shop</h3>
    <p><a href="#">home</a> / shop </p>
</div>
    <div class="category-box">
        <div>
            <form action="shop.php" method="post">
                <input type="text" name="accessoire" hidden>
                <button type="submit" class="active" id="btn-acc">Accessoire</button>
            </form>
        </div>
        <div>
            <form action="shop.php" method="post">
                <input type="text" name="art" hidden>
                <button class="" type="submit" id="btn-art">Art et Artisanat</button>
            </form>
        </div>
        <div>
            <form action="shop.php" method="post">
                <input type="text" name="vetements" hidden>
                <button class="" type="submit" id="btn-vet">Vêtements</button>
            </form>
        </div>
        <div>
            <form action="shop.php" method="post" >
                <div
                style="
                display: flex; flex-direction: row; gap: 0.5rem;
                "
                >
                    <input style="border: 1px solid slategray; padding: 0.2rem" type="text" name="search" placeholder="Search ...">
                    <button  type="submit">Find</button>
                </div>
            </form>
        </div>
    </div>
<section class="products">

    <h1 class="title">latest products</h1>
    <div class="box-container">
        <?php
        // Check if any products were returned
        if ($products) {
            foreach ($products as $product) {
                ?>
                <form action="" method="post" class="box">
                    <img class="image" src="images/<?php echo $product['image']; ?>" alt="">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">TND<?php echo $product['price']; ?>/-</div>
                    <input type="number" min="1" name="product_quantity" value="1" class="qty">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>

</section>

<?php include 'footer.php'; ?>
<?php
if(isset($_POST['art'])){
    echo "
        <script>
            document.getElementById('btn-acc').classList.remove('active');
            document.getElementById('btn-art').classList.add('active');
            document.getElementById('btn-vet').classList.remove('active');
        </script>
        ";
} else if(isset($_POST['vetements'])){
    echo "
        <script>
            document.getElementById('btn-acc').classList.remove('active');
            document.getElementById('btn-vet').classList.add('active');
            document.getElementById('btn-art').classList.remove('active');
        </script>
        ";
} else if(isset($_POST['search'])){
    echo "
        <script>
            document.getElementById('btn-acc').classList.remove('active');
            document.getElementById('btn-vet').classList.remove('active');
            document.getElementById('btn-art').classList.remove('active');
        </script>
        ";
}
?>
<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>

</body>
</html>