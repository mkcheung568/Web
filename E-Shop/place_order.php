<?php
session_start();
require('components/database.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $order_sn = date('YmdHis') . rand(100000, 999999);

    $sql = "SELECT * FROM user_cart WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cart) == 0) {
        header('Location: cart.php');
        exit();
    }

    $sql = "INSERT INTO `order` (order_sn, user_id, promotion_code_id, payment_id) VALUES (:order_sn, :user_id, :promotion_code_id, :payment_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':order_sn', $order_sn);
    $stmt->bindValue(':user_id', $_SESSION['user_id']);
    if (isset($_SESSION['coupon_code'])) {
        $stmt->bindValue(':promotion_code_id', $_SESSION['coupon_code']);
    } else {
        $stmt->bindValue(':promotion_code_id', null);
    }
    $stmt->bindValue(':payment_id', $_POST['payment_id']);
    $stmt->execute();
    $order_id = $pdo->lastInsertId();

    $order_shipping_sql = "INSERT INTO order_shipping (order_id, first_name, last_name, email, phone, address1, address2, region_id) VALUES (:order_id, :first_name, :last_name, :email, :phone, :address1, :address2, :region_id)";
    $order_shipping_stmt = $pdo->prepare($order_shipping_sql);
    $order_shipping_stmt->bindValue(':order_id', $order_id);
    $order_shipping_stmt->bindValue(':first_name', $_POST['first_name']);
    $order_shipping_stmt->bindValue(':last_name', $_POST['last_name']);
    if (isset($_POST['email'])) {
        $order_shipping_stmt->bindValue(':email', $_POST['email']);
    } else {
        $order_shipping_stmt->bindValue(':email', null);
    }
    $order_shipping_stmt->bindValue(':phone', $_POST['phone']);
    $order_shipping_stmt->bindValue(':address1', $_POST['address1']);
    $order_shipping_stmt->bindValue(':address2', $_POST['address2']);
    $order_shipping_stmt->bindValue(':region_id', $_POST['region_id']);
    $order_shipping_stmt->execute();

    foreach ($cart as $product) {
        $product_sql = "SELECT * FROM product INNER JOIN product_color ON product.id = product_color.product_id WHERE product_color.id = :id";
        $product_stmt = $pdo->prepare($product_sql);
        $product_stmt->bindValue(':id', $product['product_color_id']);
        $product_stmt->execute();
        $product_stat = $product_stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO order_product (order_id, product_color_id, quantity, unit_price) VALUES (:order_id, :product_color_id, :quantity, :unit_price)";
        $order_product_stmt = $pdo->prepare($sql);
        $order_product_stmt->bindValue(':order_id', $order_id);
        $order_product_stmt->bindValue(':product_color_id', $product['product_color_id']);
        $order_product_stmt->bindValue(':quantity', $product['quantity']);
        $order_product_stmt->bindValue(':unit_price', $product_stat['unit_price']);
        $order_product_stmt->execute();
    }

    $sql = "DELETE FROM user_cart WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['user_id']);
    $stmt->execute();

    unset($_SESSION['coupon_code']);
    
    header('Location: index.php?mode=success');
} else {
    header('Location: index.php');
}
?>