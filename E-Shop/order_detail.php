<?php
session_start();
require('components/database.php');
$current_page = 'order';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `order` WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->bindValue(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header('Location: order.php');
        exit();
    }

    $order_shipping_sql = "SELECT * FROM order_shipping WHERE order_id = :order_id";
    $order_shipping_stmt = $pdo->prepare($order_shipping_sql);
    $order_shipping_stmt->bindValue(':order_id', $_GET['id']);
    $order_shipping_stmt->execute();
    $order_shipping = $order_shipping_stmt->fetch(PDO::FETCH_ASSOC);

    $order_product_sql = "SELECT * FROM order_product WHERE order_id = :order_id";
    $order_product_stmt = $pdo->prepare($order_product_sql);
    $order_product_stmt->bindValue(':order_id', $_GET['id']);
    $order_product_stmt->execute();
    $order_products = $order_product_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: order.php');
    exit();
}
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
            <tr>
                <th>Order Datetime</th>
                <td><?= $row['create_datetime']; ?></td>
            </tr>
            <tr>
                <th>Order SN</th>
                <td><?= $row['order_sn']; ?></td>
            </tr>
            <tr>
                <th>Paid Total</th>
                <td>
                    <?php
                    $sum_sql = "SELECT SUM(unit_price * quantity) AS sum FROM order_product WHERE order_id = :order_id";
                    $sum_stmt = $pdo->prepare($sum_sql);
                    $sum_stmt->bindValue(':order_id', $row['id']);
                    $sum_stmt->execute();
                    $sum = $sum_stmt->fetch(PDO::FETCH_ASSOC);
                    echo number_format((float)$sum['sum'], 2, '.', '');
                    ?>
                </td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>
                    <?php
                    $payment_sql = "SELECT * FROM payment WHERE id = :id";
                    $payment_stmt = $pdo->prepare($payment_sql);
                    $payment_stmt->bindValue(':id', $row['payment_id']);
                    $payment_stmt->execute();
                    $payment = $payment_stmt->fetch(PDO::FETCH_ASSOC);
                    echo $payment['description'];
                    ?>
                </td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td>
                    <?php
                    $status_sql = "SELECT * FROM status WHERE id = :id";
                    $status_stmt = $pdo->prepare($status_sql);
                    $status_stmt->bindValue(':id', $row['status_id']);
                    $status_stmt->execute();
                    $status = $status_stmt->fetch(PDO::FETCH_ASSOC);
                    echo $status['name'];
                    ?>
                </td>
            </tr>
        </table>
    </section>

    <form id="order" class="section-p1" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $row['id'] ?>" method="POST">
        <table id="order-table">
            <tr>
                <th>First Name</th>
                <td><?= $order_shipping['first_name']; ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?= $order_shipping['last_name']; ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?= $order_shipping['email']; ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?= $order_shipping['phone']; ?></td>
            </tr>
            <tr>
                <th>Address (Line 1)</th>
                <td><?= $order_shipping['address1']; ?></td>
            </tr>
            <tr>
                <th>Address (Line 2)</th>
                <td><?= $order_shipping['address2']; ?></td>
            </tr>
            <tr>
                <th>Region</th>
                <td>
                    <?php
                    $region_sql = "SELECT * FROM region WHERE id = :id";
                    $region_stmt = $pdo->prepare($region_sql);
                    $region_stmt->bindValue(':id', $order_shipping['region_id']);
                    $region_stmt->execute();
                    $region = $region_stmt->fetch(PDO::FETCH_ASSOC);
                    echo $region['name'];
                    ?>
                    </select>
                </td>
            </tr>
        </table>
    </form>

    <section id="order" class="section-p1">
        <table id="order-table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Color</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($order_products as $order_product) {
                    $product_color_sql = "SELECT * FROM product_color WHERE id = :id";
                    $product_color_stmt = $pdo->prepare($product_color_sql);
                    $product_color_stmt->bindValue(':id', $order_product['product_color_id']);
                    $product_color_stmt->execute();
                    $product_color = $product_color_stmt->fetch(PDO::FETCH_ASSOC);

                    $product_sql = "SELECT * FROM product WHERE id = :id";
                    $product_stmt = $pdo->prepare($product_sql);
                    $product_stmt->bindValue(':id', $product_color['product_id']);
                    $product_stmt->execute();
                    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

                    $product_image_sql = "SELECT * FROM product_image WHERE product_id = :id LIMIT 1";
                    $product_image_stmt = $pdo->prepare($product_image_sql);
                    $product_image_stmt->bindValue(':id', $product['id']);
                    $product_image_stmt->execute();
                    $product_image = $product_image_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td><img src="<?= $product_image['image_path'] ?>" alt="<?= $product['name'] ?>" width="100px" /></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product_color['color'] ?></td>
                        <td>$<?= $order_product['unit_price'] ?></td>
                        <td><?= $order_product['quantity'] ?></td>
                        <td>$<?= $order_product['unit_price'] * $order_product['quantity'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>


    <script src="javascript/order_script.js"></script>
</body>

</html>