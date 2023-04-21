<?php
session_start();
require('components/database.php');
$current_page = 'about';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/about_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <?php include_once('components/header.php'); ?>
    
    <section id="page-header" class="about-header">
        <h2>Who we are</h2>
        <p> TECHLIVE e-commerce platform established in 2023</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="../image/illustration/shopwithus.png" alt="about">
        <div>
            <h2>We are TECHLIVE</h2>
            <p>
            TECHLIVE is a cutting-edge e-commerce platform established in 2023 that specializes in offering a wide range of top-quality 3C products, including tablets, computers, and smartphones.
             Our mission is to provide our customers with the latest and greatest technology at competitive prices, all while delivering unparalleled customer service.
              At TECHLIVE, we are passionate about technology and strive to make the latest gadgets accessible to everyone. 
              Shop with us today and experience the future of 3C technology!
            </p>
            <abbr title="">
            Experience the future with TECHLIVE - Your destination for cutting-edge 3C technology
            </abbr>
            
            <br><br>

            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">
            Stay ahead of the curve with TECHLIVE - Where innovation meets affordability!
            </marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Download TECHLIVE <a href="#"> App</a></h1>
        <div class="video">
            <video autoplay muted loop src="../image/illustration/MeetiOS17.mp4"></video>
        </div>

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

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Subscribe to our newsletter</h4>
            <p>Get the <span>latest news and offers</span> from TECHLIVE</p>
        </div>
        <div class="form">
                <input id="emailInput" type="email" placeholder="Enter your email">
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




    <script src="javascript/about_script.js"></script>
</body>
</html>