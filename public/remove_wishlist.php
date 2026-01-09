<?php
require_once '../app/helpers/session.php';
require_once '../app/models/Wishlist.php';

requireLogin();

Wishlist::remove($_SESSION['user_id'], $_POST['product_id']);
header('Location: wishlist.php');
exit;
