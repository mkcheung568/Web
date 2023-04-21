<?php
session_start();
require('components/database.php');
$current_page = 'contact';
?>

<!DOCTYPE html>
<html lang="en">
<head
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contact_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <?php include_once('components/header.php'); ?>

    <section id="page-header" class="about-header">
        <h2>Contact Us</h2>
        <p>Leava a message, we would like to heard from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
       <div class="details">
        <span>Approach Us</span>
        <h2>Visit our locations or contact us today</h2>
        <h3>Main Office</h3>
            <div>
                <li>
                    <i class="fa-sharp fa-solid fa-map-marker-alt"></i>
                    <p>Address: Suite 2303 Office Tower Convention Plaza 1 Harbour Road Wanchai</p>
                </li>

                <li>
                    <i class="fa-sharp fa-solid fa-phone-alt"></i>
                    <p>Phone: +852 1234 5678</p>
                </li>

                <li>
                    <i class="fa-sharp fa-solid fa-envelope"></i>
                    <p>Email:contact.example.com
                </li>

                <li>
                    <i class="fa-sharp fa-solid fa-clock"></i>
                    <p>Hours: 10:00 - 18:00, Mon - Sat</p>
                </li>
            </div>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1845.641586156559!2d114.17836928887797!3d22.305127894920794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x340400e809c71ff1%3A0xeb7151a34a54910d!2z6aaZ5riv55CG5bel5aSn5a24!5e0!3m2!1szh-TW!2shk!4v1678545639119!5m2!1szh-TW!2shk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>   

        </div>
    </section>

    <section id="form-details">

         <form id="contactForm" action="">
            <span>Leave your message</span>
            <h2>Get in touch with us</h2>
            <input id="nameInput" type="text" placeholder="Your Name" required>
            <input id="emailInput" type="email" placeholder="Your Email" required>
            <input id="subjectInput" type="text" placeholder="Subject">
            <textarea id="messageInput" name="" id="" cols="30" rows="10" placeholder="Your Message" required></textarea>
            <button id="submitContactForm" type="button" class="normal">Submit</button>
        </form>
        
        <div id="confirmationModal" class="modal">
            <div class="modal-content">
              <h4>Confirm Your Details</h4>
              <p>Name: <span id="confirmName"></span></p>
              <p>Email: <span id="confirmEmail"></span></p>
              <p>Subject: <span id="confirmSubject"></span></p>
              <p>Message: <span id="confirmMessage"></span></p>

              <div class="button-container">
                <button id="confirmButton" class="normal">Confirm</button>
                <button id="cancelButton" class="normal">Cancel</button>
              </div>
            </div>
            
          </div>
        

        <div class="people">
            <div>
                <img src="../image/illustration/face1.png" alt="people">
                <p><span>John Doe</span> Senior Marketing Manager <br> Phone: +852 1234 5678 <br> Email: contact@example.com</p>
            </div>

            <div>
                <img src="../image/illustration/face2.png" alt="people">
                <p><span>William Smith</span> Senior Marketing Manager <br> Phone: +852 1234 5678 <br> Email: contact@example.com</p>
            </div>

            <div>
                <img src="../image/illustration/face3.png" alt="people">
                <p><span>Helen Stone</span> Senior Marketing Manager <br> Phone: +852 1234 5678 <br> Email: contact@example.com</p>
            </div>

        </div>
    </section>
     

   
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Subscribe to our newsletter</h4>
            <p>Get the <span>latest news and offers</span> from TECHLIVE</p>
        </div>
        <div class="form">
            <input id="newsletterEmailInput" type="email" placeholder="Enter your email">
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




    <script src="javascript/contact_script.js"></script>
</body>
</html>