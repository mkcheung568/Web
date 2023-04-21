<?php
session_start();
require('components/database.php');
$current_page = 'cart';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$cart_sql = "SELECT user_cart.*, product.unit_price FROM user_cart INNER JOIN product_color ON user_cart.product_color_id = product_color.id INNER JOIN product ON product.id = product_color.product_id WHERE user_id = :user_id";
$cart_stmt = $pdo->prepare($cart_sql);
$cart_stmt->bindValue(':user_id', $_SESSION['user_id']);
$cart_stmt->execute();
$cart = $cart_stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$cart) {
    header('Location: index.php');
    exit();
}

$total = 0.00;
foreach ($cart as $item) {
    $total += $item['unit_price'] * $item['quantity'];
}

$payment_sql = "SELECT * FROM payment WHERE delete_datetime IS NULL";
$payment_stmt = $pdo->prepare($payment_sql);
$payment_stmt->execute();
$payments = $payment_stmt->fetchAll(PDO::FETCH_ASSOC);

$discount_rate = 0.00;
if (isset($_SESSION['coupon_code'])) {
    $coupon_sql = "SELECT * FROM promotion_code WHERE id = :code AND delete_datetime IS NULL";
    $coupon_stmt = $pdo->prepare($coupon_sql);
    $coupon_stmt->bindValue(':code', $_SESSION['coupon_code']);
    $coupon_stmt->execute();
    $coupon = $coupon_stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        $discount_rate = $coupon['discount_rate'];
    }
}

$region_sql = "SELECT * FROM region WHERE delete_datetime IS NULL";
$region_stmt = $pdo->prepare($region_sql);
$region_stmt->execute();
$regions = $region_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/checkout/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>TECHLIVE | Online Shop Smart Device</title>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/checkout_style.css" rel="stylesheet">
</head>


<body class="bg-body-tertiary">
    <?php include_once('components/header.php'); ?>

    <div class="container">

        <main>
            <div class="py-5 text-center">
                <h2>Checkout</h2>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span>Your cart</span>
                    </h4>
                    <ul class="list-group mb-3">

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (HKD)</span>
                            <strong id="checkout-total">$<?= $discount_rate == 0.00 ? $total : $total * (1 - $discount_rate) ?></strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>
                    <form class="needs-validation" novalidate method="POST" action="place_order.php">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>


                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-body-secondary">(Optional)</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Phone <span class="text-body-secondary"></span></label>
                                <input type="phone" class="form-control" id="phone" name="phone" placeholder="55766234" value="" required>
                                <div class="invalid-feedback">
                                    Phone number is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address1" placeholder="Street Name/District/Region" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address2" class="form-label">Address 2 </label>
                                <input type="text" class="form-control" id="address2" name="address2" placeholder="Room/Unit, Floor, Tower/Block, Estate/Building Name" required>
                            </div>

                            <div class="col-md-5">
                                <label for="country" class="form-label">Region</label>
                                <select class="form-select" id="country" name="region_id" required>
                                    <option value="">Choose...</option>
                                    <?php foreach ($regions as $region) { ?>
                                        <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>


                            <hr class="my-4">

                            <h4 class="mb-3">Payment</h4>

                            <div class="my-3">
                                <?php foreach ($payments as $payment) { ?>
                                    <div class="form-check">
                                        <input id="<?= $payment['code'] ?>" name="payment_id" type="radio" class="form-check-input" value="<?= $payment['id'] ?>" checked required>
                                        <label class="form-check-label" for="<?= $payment['code'] ?>"><?= $payment['description'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>

                            <hr class="my-4">

                            <input class="w-100 btn btn-primary btn-lg" type="submit" id="checkoutBtn" name="submit" value="Checkout and Pay" />
                    </form>
                </div>
            </div>
        </main>



    </div>



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

    <script src="javascript/bootstrap.bundle.min.js"></script>
    <script src="javascript/checkout_script.js"></script>


</body>

</html>