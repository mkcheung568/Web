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

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO product_image (product_id, image_path) VALUES (:product_id, :image_path)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':product_id', $_POST['product_id']);
    $stmt->bindValue(':image_path', $_POST['image_path']);
    $stmt->execute();
} else {
    header('Location: cms_edit_product.php?id=' . $_POST['product_id']);
    exit();
}

header('Location: cms_edit_product.php?id=' . $_POST['product_id'] . '&mode=add_image');
?>