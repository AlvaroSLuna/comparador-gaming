<?php
require_once '../app/helpers/session.php';
require_once '../config/database.php';

requireLogin();

$stmt = $pdo->prepare("
    INSERT INTO price_alerts (user_id, product_id, target_price)
    VALUES (:user, :product, :price)
");

$stmt->execute([
    'user' => $_SESSION['user_id'],
    'product' => $_POST['product_id'],
    'price' => $_POST['target_price']
]);

header('Location: wishlist.php');
