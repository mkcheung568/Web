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
    $sql = "UPDATE `order` SET status_id = :status_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':status_id', $_POST['status_id']);
    $stmt->bindValue(':id', $_POST['order_id']);
    $stmt->execute();
} else {
    header('Location: cms_order.php');
    exit();
}

header('Location: cms_order_detail.php?id=' . $_POST['order_id'] . '&mode=update_status');

?>