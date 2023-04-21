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
    $sql = "SELECT * FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $is_admin = $row['is_admin'] == 1 ? 0 : 1;
        $sql = "UPDATE user SET is_admin = :is_admin WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':is_admin', $is_admin);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
    }
} else {
    header('Location: cms_customer.php');
    exit();
}

header('Location: cms_customer.php?mode=admin');
?>