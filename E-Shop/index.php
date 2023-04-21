<?php 
session_start();
require_once('components/database.php'); 
$current_page = 'index';

$feature_product_sql = "SELECT * FROM product WHERE is_hidden = 0 AND delete_datetime IS NULL ORDER BY RAND() LIMIT 4";
$feature_product_stmt = $pdo->prepare($feature_product_sql);
$feature_product_stmt->execute();
$feature_products = $feature_product_stmt->fetchAll(PDO::FETCH_ASSOC);

$new_product_sql = "SELECT * FROM product WHERE is_hidden = 0 AND delete_datetime IS NULL ORDER BY id DESC LIMIT 4";
$new_product_stmt = $pdo->prepare($new_product_sql);
$new_product_stmt->execute();
$new_products = $new_product_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <?php include_once('components/header.php'); ?>
    <section id="hero">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all products</h1>
        <p>Save more with coupons & up to 70% off</p>
        <button onclick="window.location.href='shop.php';" >Shop Now</button>
    </section>

    <section id="feature" class="section-p1">
        <div class="feature-box">
            <i class="fa-sharp fa-solid fa-truck fa-5x"></i>
            <h6>Free Shipping</h6>
        </div> 
        <div class="feature-box">
            <i class="fa-solid fa-computer-mouse fa-5x"></i>
            <h6>Online Order</h6>
        </div> 
        <div class="feature-box">
            <i class="fa-solid fa-piggy-bank fa-5x"></i>
            <h6>Save Money</h6>
        </div> 
        <div class="feature-box">
            <i class="fa-solid fa-hourglass-end fa-5x"></i>
            <h6>Save Time</h6>
        </div> 
        <div class="feature-box">
            <i class="fa-solid fa-basket-shopping fa-5x"></i>
            <h6>Happy Shopping</h6>
        </div> 
        <div class="feature-box">
            <i class="fa-solid fa-circle-info fa-5x"></i>
            <h6>24/7 Support</h6>
        </div> 
    </section>

    <section id="product1" class="section-p1">
        <h2>Feature Products</h2>
        <p>Summer big sale product</p>
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

    <section id="banner" class="section-m1">
        <h4>Repair Service</h4>
        <h2>Up to <span>$500</span> warranty Claim for all devices</h2>
        <a href="https://www.polyu.edu.hk/" target="_blank">
        <button class="normal">Explore More</button>
        </a>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Summer big sale product</p>
        <div class="pro-container">
        <?php foreach ($new_products as $new_product) { ?>
                <div class="pro" onclick="window.location.href='product.php?id=<?=$new_product['id']?>';">
                <?php
                $new_image_sql = "SELECT * FROM product_image WHERE product_id = :id AND is_hidden = 0 LIMIT 1";
                $new_image_stmt = $pdo->prepare($new_image_sql);
                $new_image_stmt->bindValue(':id', $new_product['id']);
                $new_image_stmt->execute();
                $new_image = $new_image_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                    <img src="<?=$new_image['image_path']?>" alt="<?=$new_product['name']?>">
                    <div class="des">
                    <span><?=$new_product['brand']?></span>
                        <h5><?=$new_product['name']?></h5>
                        <div class="star">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <h4>$<?=$new_product['unit_price']?></h4>
                    </div>
                    <a href="#"><i class="fa-sharp fa-solid fa-cart-shopping cart "></i></a>
                </div>
            <?php } ?>
        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>up to 50% off</h2>
            <span>The best classic phone is on sale at TECHLIVE</span>
            
            <a href="https://www.polyu.edu.hk/" target="_blank">
            <button class="white">Learn More</button>
            </a>
        </div>

        <div class="banner-box banner-box2">
            <h4>Spring/Summer</h4>
            <h2>New product</h2>
            <span >welcome to summer</span>

            <a href="https://www.polyu.edu.hk/" target="_blank">
            <button class="white">Join Now</button>
            </a>
        </div>

    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>Season SALE</h2>
            <h3>Spring discount -30% OFF</h3>
        </div>

        <div class="banner-box banner-box2">
            <h2>Genuine Guarantee</h2>
            <h3>All goods are certified</h3>
        </div>

        <div class="banner-box banner-box3">
            <h2>7 Days Return</h2>
            <h3>7 days product return and exchange service</h3>
        </div>

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




    <script src="../javascript/index_script.js"></script>
</body>
<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'success') {
    ?>
        alert('Your payment has finished, and we will ship the product to you within 7 days');
    <?php
        }
    }
    ?>
</script>
</html>