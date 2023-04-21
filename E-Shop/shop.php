<?php
session_start();
require('components/database.php');
$current_page = 'shop';

$product_sql = "SELECT * FROM product WHERE is_hidden = 0 AND delete_datetime IS NULL";
$product_stmt = $pdo->prepare($product_sql);
$product_stmt->execute();
$products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shop_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <?php include_once('components/header.php'); ?>

    <section id="page-header">
        <h2>TECHLIVE Online Shop</h2>
        <p>Buy your devices with cheaper price</p>
    </section>


    <section id="product1" class="section-p1">
        
        <div class="pro-container">
            <?php foreach ($products as $product) {?>
                <div class="pro" onclick="window.location.href='product.php?id=<?=$product['id']?>';">
                    <?php
                    $image_sql = "SELECT * FROM product_image WHERE product_id = :id AND is_hidden = 0 LIMIT 1";
                    $image_stmt = $pdo->prepare($image_sql);
                    $image_stmt->bindValue(':id', $product['id']);
                    $image_stmt->execute();
                    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <img src="<?=$image['image_path']?>" alt="<?=$product['name']?>">
                    <div class="des">
                        <span><?=$product['brand']?></span>
                        <h5><?=$product['name']?></h5>
                        <div class="star">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <h4>$<?=$product['unit_price']?></h4>
                    </div>
                    <a href="#"><i class="fa-sharp fa-solid fa-cart-shopping cart "></i></a>
                </div>
            <?php } ?>
        </div>
    </section>

    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <!-- <a href="#"><i class="fa-solid fa-right-long"></i></a> -->
    </section>



   <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Subscribe to our newsletter</h4>
            <p>Get the <span>latest news and offers</span> from TECHLIVE</p>
        </div>
        <div class="form">
                <input id="emailInput" type="text" placeholder="Enter your email">
                <button id="subscribeButton" class="normal">Subscribe</button>
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




    <script src="javascript/shop_script.js"></script>
</body>
</html>