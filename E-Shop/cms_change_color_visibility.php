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
    $product_color_sql = "SELECT * FROM product_color WHERE id = :id";
    $stmt = $pdo->prepare($product_color_sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $_GET['id'];
    $sql = "SELECT * FROM product_color WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $visibility = $row['is_hidden'] == 1 ? 0 : 1;
        $sql = "UPDATE product_color SET is_hidden = :visibility WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':visibility', $visibility);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
} else {
    header('Location: cms_edit_product.php?id=' . $row['product_id']);
    exit();
}

header('Location: cms_edit_product.php?id=' . $row['product_id'] . '&mode=color_visibility');
?>