<?php
session_start();
require('components/database.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['product_color_id'])) {
    $sql = "DELETE FROM user_cart WHERE product_color_id = :product_color_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':product_color_id', $_GET['product_color_id']);
    $stmt->bindValue(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    header('Location: cart.php?mode=remove_cart');
}
?>