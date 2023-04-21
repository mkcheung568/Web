<?php
session_start();
require('components/database.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $product_color = "SELECT * FROM product_color WHERE id = :id";
    $stmt = $pdo->prepare($product_color);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // remove from user_cart
    $sql = "DELETE FROM user_cart WHERE product_color_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();

    $sql = "DELETE FROM product_color WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
} else {
    header('Location: cms_edit_product.php?id=' . $row['product_id']);
    exit();
}

header('Location: cms_edit_product.php?id=' . $row['product_id'] . '&mode=delete_color');
?>