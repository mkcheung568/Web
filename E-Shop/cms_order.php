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

$order_sql = "SELECT * FROM `order` ORDER BY create_datetime DESC";
$order_stmt = $pdo->prepare($order_sql);
$order_stmt->execute();
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <thead>
                <tr>
                    <th>Order Datetime</th>
                    <th>Order SN</th>
                    <th>Username / Email</th>
                    <th>Used Coupon Code</th>
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
                        $user_sql = "SELECT * FROM user WHERE id = :id";
                        $user_stmt = $pdo->prepare($user_sql);
                        $user_stmt->bindValue(':id', $order['user_id']);
                        $user_stmt->execute();
                        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <td><?= $user['username'] ?></td>
                        <?php
                        if ($order['promotion_code_id'] != null) {
                            $sql = "SELECT * FROM promotion_code WHERE id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindValue(':id', $order['promotion_code_id']);
                            $stmt->execute();
                            $promotion_code = $stmt->fetch(PDO::FETCH_ASSOC);
                            $order['promotion_code_id'] = $promotion_code['code'] . ' (Discount Rate: ' . $promotion_code['discount_rate'] * 100 . '%)';
                        } else $order['promotion_code_id'] = 'No';
                        ?>
                        <td><?= $order['promotion_code_id']; ?></td>
                        <?php
                        $sum_sql = "SELECT SUM(unit_price * quantity) AS sum FROM order_product WHERE order_id = :order_id";
                        $sum_stmt = $pdo->prepare($sum_sql);
                        $sum_stmt->bindValue(':order_id', $order['id']);
                        $sum_stmt->execute();
                        $sum = $sum_stmt->fetch(PDO::FETCH_ASSOC);
                        if ($order['promotion_code_id'] != 'No') {
                            $order['total_cost'] = $sum['sum'] * (1 - $promotion_code['discount_rate']);
                        } else $order['total_cost'] = $sum['sum'];
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
                            <a class="action-link" href="cms_order_detail.php?id=<?= $order['id']; ?>" class="btn btn-primary">Check Details</a>
                            <?php if ($order['status_id'] != 4) { ?><a class="action-link" href="cms_delete_order.php?id=<?= $order['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to void <?= $order['order_sn']; ?>?');">Void</a> <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <script src="javascript/cms_order_script.js"></script>
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