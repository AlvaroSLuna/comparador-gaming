<?php
require_once '../app/helpers/session.php';
require_once '../app/models/Wishlist.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;

    if ($productId) {
        Wishlist::add($_SESSION['user_id'], $productId);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
