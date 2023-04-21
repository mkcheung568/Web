<?php 
session_start();
require('components/database.php');
$current_page = 'shop';
$message = '';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT * FROM product WHERE id = :id AND is_hidden = 0 AND delete_datetime IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_GET['id']);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $query_sql = "SELECT * FROM user_cart WHERE user_id = :user_id AND product_color_id = :product_color_id";
    $query_stmt = $pdo->prepare($query_sql);
    $query_stmt->bindValue(':user_id', $_SESSION['user_id']);
    $query_stmt->bindValue(':product_color_id', $_POST['product_color_id']);
    $query_stmt->execute();
    $query = $query_stmt->fetch(PDO::FETCH_ASSOC);

    if ($query) {
        $sql = "UPDATE user_cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_color_id = :product_color_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
        $stmt->bindValue(':product_color_id', $_POST['product_color_id']);
        $stmt->bindValue(':quantity', $_POST['quantity']);
        $stmt->execute();
        $message = 'Your product has been added to the shopping cart';
    } else {
        $sql = "INSERT INTO user_cart (user_id, product_color_id, quantity) VALUES (:user_id, :product_color_id, :quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
        $stmt->bindValue(':product_color_id', $_POST['product_color_id']);
        $stmt->bindValue(':quantity', $_POST['quantity']);
        $stmt->execute();
        $message = 'Your product has been added to the shopping cart';    
    }
}

$pcategory_sql = "SELECT * FROM product_category WHERE product_id = :id";
$pcategory_stmt = $pdo->prepare($pcategory_sql);
$pcategory_stmt->bindValue(':id', $_GET['id']);
$pcategory_stmt->execute();
$pcategories = $pcategory_stmt->fetchAll(PDO::FETCH_ASSOC);

$cat_text = '';
foreach ($pcategories as $pcategory) {
    $category_sql = "SELECT * FROM category WHERE id = :id";
    $category_stmt = $pdo->prepare($category_sql);
    $category_stmt->bindValue(':id', $pcategory['category_id']);
    $category_stmt->execute();
    $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
    $cat_text .= $category['name'] . ' / ';
}

$color_sql = "SELECT * FROM product_color WHERE product_id = :id AND is_hidden = 0";
$color_stmt = $pdo->prepare($color_sql);
$color_stmt->bindValue(':id', $_GET['id']);
$color_stmt->execute();
$colors = $color_stmt->fetchAll(PDO::FETCH_ASSOC);

$image_sql = "SELECT * FROM product_image WHERE product_id = :id AND is_hidden = 0";
$image_stmt = $pdo->prepare($image_sql);
$image_stmt->bindValue(':id', $_GET['id']);
$image_stmt->execute();
$images = $image_stmt->fetchAll(PDO::FETCH_ASSOC);

$feature_products_sql = "SELECT * FROM product WHERE is_hidden = 0 AND id <> :id ORDER BY RAND() LIMIT 4";
$feature_products_stmt = $pdo->prepare($feature_products_sql);
$feature_products_stmt->bindValue(':id', $_GET['id']);
$feature_products_stmt->execute();
$feature_products = $feature_products_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sproduct_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <?php include_once('components/header.php'); ?>

    <section id="prodetails"class="section-p1">
        <div class="single-pro-image">
            <img src="<?=$images[0]['image_path']?>" width="100%" id="MainImg" alt="<?=$product['name']?>">
            <div class="small-img-group">
                <?php foreach ($images as $image) { ?>
                <div class="small-img-col">
                    <img src="<?=$image['image_path']?>" width="100%" class="small-img" alt="ip14">
                </div>
                <?php } ?>
            </div>
        </div>

        <form class="single-pro-details" method="POST" action="product.php?id=<?=$_GET['id']?>">
            <h6><?=$cat_text . $product['brand']?></h6>
            <h4><?=$product['name']?></h4>
            <h2>$<?=$product['unit_price']?></h2>
            <select id="color-select" name="product_color_id" required>
                <?php foreach ($colors as $color) { ?>
                    <option value="<?=$color['id']?>"><?=$color['color']?></option>
                <?php } ?>
            </select>
            <input type="number" id="quantity-input" name="quantity" value="1" min="1" max="10" />
            <input type="submit" class="normal" id="add-to-cart-btn" name="submit" value="Add to Cart" />
            <h4>Product Details</h4>
            <span>
                <?=$product['description']?>
            </span>
        </form>
    </section>

    <section id="product1" class="section-p1">
        <h2>Feature Products</h2>
        <p>Weekly big sale product</p>
        <div class="pro-container">
            <?php foreach ($feature_products as $feature_product) { ?>
                <div class="pro" onclick="window.location.href='product.php?id=<?=$feature_product['id']?>';">
                <?php
                $feature_image_sql = "SELECT * FROM product_image WHERE product_id = :id AND is_hidden = 0 LIMIT 1";
                $feature_image_stmt = $pdo->prepare($feature_image_sql);
                $feature_image_stmt->bindValue(':id', $feature_product['id']);
                $feature_image_stmt->execute();
                $feature_image = $feature_image_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                    <img src="<?=$feature_image['image_path']?>" alt="<?=$feature_product['name']?>">
                    <div class="des">
                        <span><?=$feature_product['brand']?></span>
                        <h5><?=$feature_product['name']?></h5>
                        <div class="star">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <h4>$<?=$feature_product['unit_price']?></h4>
                    </div>
                    <a href="#"><i class="fa-sharp fa-solid fa-cart-shopping cart "></i></a>
                </div>
            <?php } ?>
        </div>
    </section>



    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Subscribe to our newsletter</h4>
            <p>Get the <span>latest news and offers</span>  from TECHLIVE</p>
        </div>
        <div class="form">
                <input type="text" placeholder="Enter your email">
                <button class="normal">Subscribe</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="../image/logo/T-logo-trans.png" alt="logo">
            <h4>Contact</h4>
            <p><strong>Address: </strong> Suite 2303 Office Tower Convention Plaza 1 Harbour Road Wanchai</p>
            <p><strong>Phone: </strong> +852 1234 5678</p>
            <p><strong>Hours: </strong> 10:00 - 18:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <a href="#"><i class="fa-sharp fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-sharp fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-sharp fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-sharp fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
           
            <a href="about.php">About us</a>
            <a href="contact.php">Contact us</a>
            <a href="terms_condition.php">Terms & Conditions</a>
            <a href="privacy_policy.php">Privacy Policy</a>
            <a href="faq.php">FAQ</a>
        </div>

        <div class="col">
            <h4>Our Account</h4>
            <a href="login.php">Login</a>
            <a href="cart.php">View Cart</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="../image/download/googleplay.png" alt="google play">
                <img src="../image/download/appstore.png" alt="app store">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="../image/payment/pay.png" alt="payment">
        </div>

        <div class="copyright">
            <p>© 2021 TECHLIVE. All Rights Reserved.</p>
        </div>


    </footer>



    <script src="javascript/sproduct_script.js"></script>
</body>

<script>
    <?php if ($message != '') { ?>
        alert('<?=$message?>');
    <?php } ?>
</script>
</html>