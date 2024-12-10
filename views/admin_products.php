<?php
require_once "../controllers/ProductsController.php";
require_once "../models/Products.php";

$productController = new ProductsController();
$category = "Accessoire";
$products = null;
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])
    && isset($_POST['categorie']) && isset($_FILES['image']) && !isset($_POST['old_image'])) {
    $imageName = $_FILES["image"]["name"];
    $product = new Products(
        0, $_POST['name'], $_POST['price'], $imageName,
        $_POST['description'], $_POST['categorie']
    );
    $productController->addProduct($product);
    header('Location: admin_products.php');
} else if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])
    && isset($_POST['categorie']) && isset($_POST['old_image']) && isset($_POST['id_product'])) {
    $imageName = $_POST['old_image'];
    if (!empty($_FILES["image"]["name"]))
        $imageName = $_FILES["image"]["name"];
    $product = new Products(
        $_POST['id_product'], $_POST['name'], $_POST['price'], $imageName,
        $_POST['description'], $_POST['categorie']
    );
    $productController->updateProduct($product);
    header('Location: admin_products.php');
} else if (isset($_GET['update'])) {
    $product = $productController->getProduct($_GET['update']);
} else if (isset($_GET['delete'])) {
    $productController->deleteProduct($_GET['delete']);
    header('Location: admin_products.php');
} else {
    if(!isset($_POST['art']) && !isset($_POST['vetements'])){
        $products = $productController->getProductsByCategory('Accessoire');
    } else if(isset($_POST['art'])){
        $products = $productController->getProductsByCategory('Art et Artisanat');
    } else if(isset($_POST['vetements'])){
        $products = $productController->getProductsByCategory('Vêtements');
    }
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

    <form action="admin_products.php" method="post" enctype="multipart/form-data" id="productFormAdd">
        <h3>add product</h3>
        <input type="text" name="name" id="name" class="box" placeholder="enter product name">
        <span id="name_error" style="color: red; font-weight: 700;"></span>
        <input type="number" name="price" id="price" class="box" placeholder="enter product price">
        <span id="price_error" style="color: red; font-weight: 700;"></span>
        <textarea class="box" placeholder="enter product description" id="description" name="description"></textarea>
        <span id="description_error" style="color: red; font-weight: 700;"></span>
        <select class="box" name="categorie">
            <option value="Accessoire">Accessoire</option>
            <option value="Art et Artisanat">Art et Artisanat</option>
            <option value="Vêtements">Vêtements</option>
        </select>
        <input type="file" id="image" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
        <span id="image_error" style="color: red; font-weight: 700;"></span><br>
        <input type="submit" value="add product" name="add_product" class="btn">
    </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">
    <?php
    if (!isset($_GET['update'])) { ?>
        <div class="category-box">
            <div>
                <form action="admin_products.php" method="post">
                    <input type="text" name="accessoire" hidden>
                    <button type="submit"  class="active" id="btn-acc">Accessoire</button>
                </form>
            </div>
            <div>
                <form action="admin_products.php" method="post">
                    <input type="text" name="art" hidden>
                    <button class="" type="submit" id="btn-art">Art et Artisanat</button>
                </form>
            </div>
            <div>
                <form action="admin_products.php" method="post">
                    <input type="text" name="vetements" hidden>
                    <button class="" type="submit" id="btn-vet">Vêtements</button>
                </form>
            </div>
        </div>
        <div class="box-container">
            <?php
            if ($products) {
                foreach ($products as $product) {
                    ?>
                    <div class="box">
                        <img src="images/<?php echo $product['image']; ?>" alt="">
                        <div class="name"><?php echo $product['name']; ?></div>
                        <div class="price"><?php echo $product['price']; ?> TND</div>
                        <a href="admin_products.php?update=<?php echo $product['id']; ?>" class="option-btn">update</a>
                        <a href="admin_products.php?delete=<?php echo $product['id']; ?>" class="delete-btn"
                           onclick="return confirm('delete this product?');">delete</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>
    <?php }
    ?>
</section>
<?php
if (isset($_GET['update'])) {
    ?>
    <section class="edit-product-form">

        <form action="admin_products.php" method="post" enctype="multipart/form-data" id="updateProductForm">
            <img src="images/<?php echo $product['image']; ?>" alt="">
            <input type="number" value="<?php echo $product['id']; ?>" name="id_product" hidden>
            <input type="text" value="<?php echo $product['image']; ?>" name="old_image" hidden>
            <input type="text" name="name" id="name_update" class="box" placeholder="enter product name"
                   value="<?php echo $product['name']; ?>">
            <span id="name_error_update" style="color: red; font-weight: 700;"></span>
            <input type="number" name="price" id="price_update" class="box" placeholder="enter product price"
                   value="<?php echo $product['price']; ?>">
            <span id="price_error_update" style="color: red; font-weight: 700;"></span>
            <textarea class="box" placeholder="enter product description" id="description_update"
                      name="description"><?php echo $product['description']; ?></textarea>
            <span id="description_error_update" style="color: red; font-weight: 700;"></span>
            <select class="box" name="categorie">
                <option <?php if ($product['categorie'] == "Accessoire") echo 'selected'; ?> value="Accessoire">
                    Accessoire
                </option>
                <option <?php if ($product['categorie'] == "Art et Artisanat") echo 'selected'; ?>
                        value="Art et Artisanat">
                    Art et Artisanat
                </option>
                <option <?php if ($product['categorie'] == "Vêtements") echo 'selected'; ?> value="Vêtements">
                    Vêtements
                </option>
            </select>
            <input type="file" id="image_update" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <span id="image_error_update" style="color: red; font-weight: 700;"></span><br>
            <input type="submit" value="update" name="update_product" class="btn">
            <input type="reset" value="cancel" id="close-update" class="option-btn">
        </form>
    </section>
    <?php
}
?>

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
}
?>
<!-- custom admin js file link  -->
<script src="../controllers/js/admin_script.js"></script>
<script src="JS/addProduct.js"></script>
<script src="JS/updateProduct.js"></script>
</body>
</html>