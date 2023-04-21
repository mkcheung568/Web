<?php
session_start();
require('components/database.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_POST['coupon_code'])) {
    header('Location: cart.php');
    exit();
}

$sql = "SELECT * FROM promotion_code WHERE code = :code AND is_valid = 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':code', $_POST['coupon_code']);
$stmt->execute();
$promotion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$promotion) {
    header('Location: cart.php?mode=invalid_coupon');
    exit();
}

$_SESSION['coupon_code'] = $promotion['id'];
header('Location: cart.php?mode=apply_coupon');
?>