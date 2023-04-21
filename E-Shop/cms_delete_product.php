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
    // get all colors of the product
    $sql = "SELECT * FROM product_color WHERE product_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete all colors from user_cart
    foreach ($colors as $color) {
        $sql = "DELETE FROM user_cart WHERE product_color_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $color['id']);
        $stmt->execute();
    }

    $sql = "UPDATE product SET delete_datetime = CURRENT_TIMESTAMP() WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
} else {
    header('Location: cms_inventory.php');
    exit();
}

header('Location: cms_inventory.php?mode=delete');
?>