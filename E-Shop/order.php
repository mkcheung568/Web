<?php
session_start();
require('components/database.php');
$current_page = 'order';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$order_sql = "SELECT * FROM `order` WHERE user_id = :user_id ORDER BY create_datetime DESC";
$order_stmt = $pdo->prepare($order_sql);
$order_stmt->bindValue(':user_id', $_SESSION['user_id']);
$order_stmt->execute();
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/order_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/header.php'); ?>

    <section id="page-header">
        <h2>View Orders</h2>
    </section>

    <section id="order" class="section-p1">
        <table id="order-table">
            <thead>
                <tr>
                    <th>Order Datetime</th>
                    <th>Order SN</th>
                    <th>Paid Total</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order['create_datetime']; ?></td>
                        <td><?= $order['order_sn']; ?></td>
                        <?php
                        $sum_sql = "SELECT SUM(unit_price * quantity) AS sum FROM order_product WHERE order_id = :order_id";
                        $sum_stmt = $pdo->prepare($sum_sql);
                        $sum_stmt->bindValue(':order_id', $order['id']);
                        $sum_stmt->execute();
                        $sum = $sum_stmt->fetch(PDO::FETCH_ASSOC);
                        $order['total_cost'] = $sum['sum'];
                        ?>
                        <td><?= number_format((float)$order['total_cost'], 2, '.', ''); ?></td>
                        <?php
                        $payment_sql = "SELECT * FROM payment WHERE id = :id";
                        $payment_stmt = $pdo->prepare($payment_sql);
                        $payment_stmt->bindValue(':id', $order['payment_id']);
                        $payment_stmt->execute();
                        $payment = $payment_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <td><?= $payment['description']; ?></td>
                        <?php
                        $status_sql = "SELECT * FROM status WHERE id = :id";
                        $status_stmt = $pdo->prepare($status_sql);
                        $status_stmt->bindValue(':id', $order['status_id']);
                        $status_stmt->execute();
                        $status = $status_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <td><?= $status['name']; ?></td>
                        <td>
                            <a class="action-link" href="order_detail.php?id=<?= $order['id']; ?>" class="btn btn-primary">Check Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

    <script src="javascript/order_script.js"></script>
</body>

<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'void') {
    ?>
            alert('Order has been voided.');
    <?php
        }
    }
    ?>
</script>

</html>