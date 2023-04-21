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
        $delete_datetime = $row['delete_datetime'] == NULL ? date('Y-m-d H:i:s') : NULL;
        $sql = "UPDATE user SET delete_datetime = :delete_datetime WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':delete_datetime', $delete_datetime);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
    }
} else {
    header('Location: cms_customer.php');
    exit();
}

header('Location: cms_customer.php?mode=delete');
?>