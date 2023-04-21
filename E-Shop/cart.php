<?php
session_start();
require('components/database.php');
$current_page = 'cart';
$total_price = 0.00;
$discount = 0.00;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM user_cart WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id']);
$stmt->execute();
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/header.php'); ?>

    <section id="page-header" class="cart-header">
        <h2>My Cart</h2>
        <p>Be happy to choose your favorite products!</p>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>color</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $cart_product) { ?>
                    <?php
                    $product_sql = "SELECT product.id, name, unit_price, color FROM product INNER JOIN product_color ON product.id = product_color.product_id WHERE product_color.id = :id";
                    $product_stmt = $pdo->prepare($product_sql);
                    $product_stmt->bindValue(':id', $cart_product['product_color_id']);
                    $product_stmt->execute();
                    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

                    $product_image_sql = "SELECT * FROM product_image WHERE product_id = :product_id LIMIT 1";
                    $product_image_stmt = $pdo->prepare($product_image_sql);
                    $product_image_stmt->bindValue(':product_id', $product['id']);
                    $product_image_stmt->execute();
                    $product_image = $product_image_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><a href="remove_cart.php?product_color_id=<?= $cart_product['product_color_id'] ?>"><i class="fa fa-times-circle"></i></a></td>
                        <td><img src="<?= $product_image['image_path'] ?>" alt="<?= $product['name'] ?>" /></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['color'] ?></td>
                        <td><?= $product['unit_price'] ?></td>
                        <td><?= $cart_product['quantity'] ?></td>
                        <td><?= $product['unit_price'] * $cart_product['quantity'] ?></td>
                    </tr>
                <?php
                    $total_price += $product['unit_price'] * $cart_product['quantity'];
                }
                ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <form id="coupon" method="POST" action="apply_coupon.php">
            <!-- <h3>Use Coupon</h3>
            <div>
                <input id="coupon-input" type="text" name="coupon_code" placeholder="Enter your coupon code">
                <button id="apply-coupon" class="normal">Apply</button>
            </div> -->
        </form>

        <div id="subtotal">
            <h3>Cart Total</h3>
            <table>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$<?=$total_price?></strong></td>
                </tr>
            </table>
            <a href="checkout.php">
                <button id="checkout-btn" type="button" class="btn">Proceed to Checkout</button>
            </a>
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




    <script src="javascript/cart_script.js"></script>
</body>
<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'remove_cart') {
    ?>
            alert('Your product has been removed from the shopping cart!');
        <?php
        } else if ($_GET['mode'] == 'apply_coupon') {
        ?>
            alert('Your coupon has been applied!');
        <?php
        } else if ($_GET['mode'] == 'invalid_coupon') {
        ?>
            alert('Your coupon is invalid!');
    <?php
        }
    }
    ?>
</script>

</html>