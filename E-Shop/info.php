<!DOCTYPE html>
<html lang="en">
<head
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/info_style.css">
    <!-- <link rel="stylesheet" href="https://kit.fontawesome.com/8e3a25a73f.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>
<body>
    <section id="header">
        <a href="#"><img src="../image/logo/T-logo-trans.png" class="logo" alt="logo"></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li id="lg-bag" ><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-arrow-down"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-times"></i></a>
            </ul>
        </div>

        <div id="mobile">
            <a href="cart.html"><i class="fa-sharp fa-solid fa-cart-arrow-down"></i></a>
            <i id="bar" class="fa-solid fa-outdent"></i>
        </div>

    </section>

    <section id="page-header" class="info-head">
        <h2>My Profile</h2>
        <p>Thanks for being our member</p>
    </section>

    <section id="Personal-info" class="section-p1">
        <form id="account-info" action="">
            <h4>Account Information</h4>
            <!-- <div class="point">
                <h5>Point Remains</h5>
                <p>1000</p>
            </div> -->
            

            <spam>*required field(s) </spam>
            <div class="row">
                <div class="col">
                    <label for="fname">Given Name*</label>
                    <input type="text" id="fname" name="fname" placeholder="Your given name" value="Mike">
                </div>
                <div class="col">
                    <label for="lname">Surname*</label>
                    <input type="text" id="lname" name="lname" placeholder="Your surname" value="Cheung">
                </div>
                <div class="col">
                    <label for="nname">Nickname(public)</label>
                    <input type="text" id="nname" name="nname" placeholder="Your nickname" value="mike5566">
                </div>
                <div class="col">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" placeholder="Your email.." value="mikechueng@example.com">
                </div>
                <div class="col">
                    <label for="phone">Phone*</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your phone number.."value="55766257">
                </div>

                <div class="col">
                    <label for="gender">Gender*</label>
                    <div class="gender-container">
                      <div class="gender-option">
                        <input type="radio" id="male" name="my_gender" value="Male" checked>
                        <label for="male">Male</label>
                      </div>
                      <div class="gender-option">
                        <input type="radio" id="female" name="my_gender" value="Female">
                        <label for="female">Female</label>
                      </div>
                      <div class="gender-option">
                        <input type="radio" id="not_specific" name="my_gender" value="Not Specific">
                        <label for="not_specific">Not Specific</label>
                      </div>
                    </div>
                </div>

                  
                
                <div class="col">
                    <input type="submit" value="Save Changes">
                </div>
            </div>
        </form>
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




    <script src="info_script.js"></script>
</body>
</html>