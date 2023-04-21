<?php
session_start();
require('components/database.php');
$current_page = 'order';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $sql = "UPDATE order_shipping SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, address1 = :address1, address2 = :address2, region_id = :region_id WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':first_name', $_POST['first_name']);
    $stmt->bindValue(':last_name', $_POST['last_name']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':phone', $_POST['phone']);
    $stmt->bindValue(':address1', $_POST['address1']);
    $stmt->bindValue(':address2', $_POST['address2']);
    $stmt->bindValue(':region_id', $_POST['region_id']);
    $stmt->bindValue(':order_id', $_POST['order_id']);
    $stmt->execute();

    header('Location: cms_order_detail.php?id=' . $_POST['order_id'] . '&mode=update_shipping');
} else if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `order` WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header('Location: cms_order.php');
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
    header('Location: cms_order.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cms_order_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/cms_header.php'); ?>

    <section id="page-header">
        <h2>Content Management System</h2>
        <h4>Order Management</h4>
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
                <th>Username / Email</th>
                <td>
                    <?php
                    $user_sql = "SELECT * FROM user WHERE id = :id";
                    $user_stmt = $pdo->prepare($user_sql);
                    $user_stmt->bindValue(':id', $row['user_id']);
                    $user_stmt->execute();
                    $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?= $user['username'] ?>
                </td>
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
            <?php if (is_null($row['cancel_datetime'])) { ?>
                <tr>
                    <td colspan="2">
                        <form action="cms_order_change_status.php" method="POST">
                            Update status to:
                            <select class="selection-type" name="status_id" id="status">
                                <?php
                                $status_sql = "SELECT * FROM status WHERE id != :id AND name != 'Voided'";
                                $status_stmt = $pdo->prepare($status_sql);
                                $status_stmt->bindValue(':id', $row['status_id']);
                                $status_stmt->execute();
                                while ($status = $status_stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?= $status['id'] ?>"><?= $status['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <input  type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <input class="action-link" type="submit" name="submit" value="Update" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </section>

    <form id="order" class="section-p1" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $row['id'] ?>" method="POST">
        <table id="order-table">
            <tr>
                <th>First Name</th>
                <td><input type="text" name="first_name" value="<?= $order_shipping['first_name']; ?>" required <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" name="last_name" value="<?= $order_shipping['last_name']; ?>" required <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><input type="email" name="email" value="<?= $order_shipping['email']; ?>" <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><input type="text" name="phone" value="<?= $order_shipping['phone']; ?>" required <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Address (Line 1)</th>
                <td><input type="text" name="address1" value="<?= $order_shipping['address1']; ?>" required <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Address (Line 2)</th>
                <td><input type="text" name="address2" value="<?= $order_shipping['address2']; ?>" required <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> /></td>
            </tr>
            <tr>
                <th>Region</th>
                <td>
                    <?php
                    $region_sql = "SELECT * FROM region";
                    $region_stmt = $pdo->prepare($region_sql);
                    $region_stmt->execute();
                    ?>
                    <select class="selection-type" name="region_id" id="region" <?= is_null($row['cancel_datetime']) ? '' : 'disabled' ?> >
                        <?php
                        while ($region = $region_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?= $region['id'] ?>" <?= $region['id'] == $order_shipping['region_id'] ? 'selected' : '' ?>><?= $region['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php if (is_null($row['cancel_datetime'])) { ?>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>" />
                        <input class="action-link" type="submit" name="submit" value="Update Shipping Address" />
                    </td>
                </tr>
            <?php } ?>
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


    <script src="javascript/cms_order_script.js"></script>
</body>

<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'update_status') {
    ?>
            alert('Order status has been updated.');
        <?php
        } else if ($_GET['mode'] == 'update_shipping') {
        ?>
            alert('Shipping address has been updated.');
    <?php
        }
    }
    ?>
</script>

</html>